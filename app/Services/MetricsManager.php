<?php

namespace App\Services;

use App\Constants\SubscriptionStatus;
use App\Constants\TransactionStatus;
use App\Models\Interval;
use App\Models\Subscription;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class MetricsManager
{
    public function calculateAverageRevenuePerUserChart()
    {
        $transactions = DB::table('transactions')
            ->select([DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'), DB::raw('SUM(amount) as total_revenue')])
            ->groupBy('month')
            ->get();

        $users = DB::table('users')
            ->select([DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'), DB::raw('COUNT(*) as total_users')])
            ->groupBy('month')
            ->get();

        $allMonths = [];
        $transactionsByDateMap = [];
        foreach ($transactions as $transaction) {
            $transactionsByDateMap[$transaction->month] = $transaction;
            $allMonths[$transaction->month] = $transaction->month;
        }

        $usersByDateMap = [];
        foreach ($users as $user) {
            $usersByDateMap[$user->month] = $user;
            $allMonths[$user->month] = $user->month;
        }

        $arpuData = [];

        sort($allMonths);

        $totalRevenueUpToMonth = 0;
        $totalUsersUpToMonth = 0;
        $monthToTotalRevenueMap = [];
        $monthToTotalUsersMap = [];
        foreach ($allMonths as $month) {
            if (isset($transactionsByDateMap[$month])) {
                $totalRevenueUpToMonth += $transactionsByDateMap[$month]->total_revenue;
            }

            if (isset($usersByDateMap[$month])) {
                $totalUsersUpToMonth += $usersByDateMap[$month]->total_users;
            }
            // only format the amount without adding the currency symbol
            if ($totalUsersUpToMonth > 0) {
                $arpuData[$month] = money(intval(round($totalRevenueUpToMonth / $totalUsersUpToMonth)), config('app.default_currency'))->formatByDecimal();
            }

            $monthToTotalRevenueMap[$month] = $totalRevenueUpToMonth;
            $monthToTotalUsersMap[$month] = $totalUsersUpToMonth;
        }

        if (count($arpuData) == 0) {
            return $arpuData;
        }

        // fill in gap months
        // fill gaps in $monthToTotalRevenueMap

        $startMonth = $allMonths[0];
        $endMonth = $allMonths[count($allMonths) - 1];
        $currentMonth = $startMonth;

        while ($currentMonth != $endMonth) {
            if (!isset($monthToTotalRevenueMap[$currentMonth])) {
                $previousMonth = date('Y-m', strtotime($currentMonth . ' -1 month'));
                $monthToTotalRevenueMap[$currentMonth] = $monthToTotalRevenueMap[$previousMonth];
            }

            $currentMonth = date('Y-m', strtotime($currentMonth . ' +1 month'));
        }

        // fill gaps in $monthToTotalUsersMap
        $currentMonth = $startMonth;
        while ($currentMonth != $endMonth) {
            if (!isset($monthToTotalUsersMap[$currentMonth])) {
                $previousMonth = date('Y-m', strtotime($currentMonth . ' -1 month'));
                $monthToTotalUsersMap[$currentMonth] = $monthToTotalUsersMap[$previousMonth];
            }

            $currentMonth = date('Y-m', strtotime($currentMonth . ' +1 month'));
        }

        // fill gaps in $arpuData

        $startMonth = $allMonths[0];
        $endMonth = $allMonths[count($allMonths) - 1];
        $currentMonth = $startMonth;

        while ($currentMonth != $endMonth) {
            if (!isset($arpuData[$currentMonth])) {
                $previousMonth = date('Y-m', strtotime($currentMonth . ' -1 month'));
                $arpuData[$currentMonth] = money(intval(round($monthToTotalRevenueMap[$previousMonth] / $monthToTotalUsersMap[$previousMonth])), config('app.default_currency'))->formatByDecimal();
            }

            $currentMonth = date('Y-m', strtotime($currentMonth . ' +1 month'));
        }

        ksort($arpuData);

        return $arpuData;
    }

    public function calculateMRRChart()
    {
        $intervals = Interval::all();

        $intervalMap = [];
        foreach ($intervals as $interval) {
            $intervalMap[$interval->id] = $interval;
        }

        $intervalsInDays = [
            'day' => 1,
            'week' => 7,
            'month' => 30,
            'year' => 360,  // to get a monthly value, we divide by 30 (12 months * 30 days)
        ];

        $cases = [];
        foreach ($intervals as $interval) {
            $calculationDays = $intervalsInDays[$interval->name];
            $cases[] = "WHEN interval_id = $interval->id THEN subscriptions.price * subscriptions.interval_count / " . $calculationDays . " * 30";
        }

        $results = DB::table('subscriptions')
            ->select([
                DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
                DB::raw('
                SUM(CASE
                    ' . implode("\n", $cases) . '
                    ELSE 0
                END) as monthly_revenue
            ')
            ])
            ->where('status', SubscriptionStatus::ACTIVE->value)
            ->where(function ($query) {
                $query->whereNull('trial_ends_at')
                    ->orWhere('trial_ends_at', '<', Carbon::now());
            })
            ->groupBy('month')
            ->get();

        $allMonths = [];
        $mrrByDateMap = [];
        foreach ($results as $result) {
            $mrrByDateMap[$result->month] = $result;
            $allMonths[$result->month] = $result->month;
        }

        sort($allMonths);

        $currentMrr = 0;
        $mrrData = [];
        foreach ($allMonths as $month) {
            if (isset($mrrByDateMap[$month])) {
                $currentMrr += $mrrByDateMap[$month]->monthly_revenue;
            }

            $mrrData[$month] =  money(intval(round($currentMrr)), config('app.default_currency'))->formatByDecimal();
        }

        if (count($mrrData) == 0) {
            return $mrrData;
        }

        // fill in gap months
        $startMonth = $allMonths[0];
        $endMonth = $allMonths[count($allMonths) - 1];
        $currentMonth = $startMonth;

        // format is Y-m

        while ($currentMonth != $endMonth) {
            if (!isset($mrrData[$currentMonth])) {
                $previousMonth = date('Y-m', strtotime($currentMonth . ' -1 month'));
                $mrrData[$currentMonth] = $mrrData[$previousMonth];
            }

            $currentMonth = date('Y-m', strtotime($currentMonth . ' +1 month'));


        }

        ksort($mrrData);

        return $mrrData;
    }
    public function calculateChurnRateChart()
    {
        # subscriptions that end each month
        $endsEachMonthResults = DB::table('subscriptions')
            ->select([
                DB::raw('DATE_FORMAT(ends_at, "%Y-%m") as month'),
                DB::raw('count(*) as total_ended')
            ])
            ->where('status', '!=', SubscriptionStatus::ACTIVE->value)
            ->whereNotNull('ends_at')
            ->where('ends_at', '<', Carbon::now()->addMonth()->startOfMonth())
            ->groupBy('month')
            ->get();

        $datesMap = [];

        $endsEachMonthMap = [];
        foreach ($endsEachMonthResults as $result) {
            $endsEachMonthMap[$result->month] = $result;
            $datesMap[$result->month] = $result->month;
        }

        # subscriptions that start each month
        $startsEachMonthResults = DB::table('subscriptions')
            ->select([
                DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
                DB::raw('count(*) as total_started')
            ])
            ->where('status', SubscriptionStatus::ACTIVE->value)
            ->where(function ($query) {
                $query->whereNull('trial_ends_at')
                    ->orWhere('trial_ends_at', '<', Carbon::now());
            })
            ->groupBy('month')
            ->get();

        $startsEachMonthMap = [];

        foreach ($startsEachMonthResults as $result) {
            $startsEachMonthMap[$result->month] = $result;
            $datesMap[$result->month] = $result->month;
        }

        sort($datesMap);

        // Churn = "(Lost Customers ÷ Total Customers at the Start of Time Period) x 100."
        $churnData = [];
        $totalSubscriptions = 0;
        foreach ($datesMap as $date) {
            $churnData[$date] = $totalSubscriptions > 0 ? ($endsEachMonthMap[$date]->total_ended ?? 0) / $totalSubscriptions * 100 : 0;

            if (isset($startsEachMonthMap[$date])) {
                $totalSubscriptions += $startsEachMonthMap[$date]->total_started;
            }
        }

        if (count($churnData) == 0) {
            return $churnData;
        }

        // fill in gap months

        $startMonth = $datesMap[0];
        $endMonth = $datesMap[count($datesMap) - 1];
        $currentMonth = $startMonth;

        while ($currentMonth != $endMonth) {
            if (!isset($churnData[$currentMonth])) {
                $previousMonth = date('Y-m', strtotime($currentMonth . ' -1 month'));
                $churnData[$currentMonth] = 0;
            }

            $currentMonth = date('Y-m', strtotime($currentMonth . ' +1 month'));
        }

        ksort($churnData);

        return $churnData;
    }

    public function calculateMRR()
    {
        $mrrs = array_values($this->calculateMRRChart());

        $previous = null;
        $diff = 0;
        if (count($mrrs) > 1) {
            $previous = $mrrs[count($mrrs) - 2];
            $diff = abs(end($mrrs) - $previous);
        }

        return [
            'current' => end($mrrs) ?? 0,
            'previous' => $previous,
            'diff' => $diff,
        ];
    }

    public function getTotalUsers()
    {
        return User::all()->count();
    }

    public function getTotalTransactions()
    {
        return Transaction::all()->count();
    }

    public function getTotalRevenue()
    {
        return money(Transaction::where('status', TransactionStatus::SUCCESS->value)->sum('amount'), config('app.default_currency'));
    }

    public function getActiveSubscriptions()
    {
        return Subscription::where('status', SubscriptionStatus::ACTIVE->value)
            ->where('ends_at', '>', Carbon::now())
            ->count();
    }

    public function totalTrials()
    {
        return Subscription::where('trial_ends_at', '>', Carbon::now())
            ->where('status', SubscriptionStatus::ACTIVE->value)
            ->count();
    }


    public function getTotalCustomerConversion()
    {
        $totalSubscriptions = $this->getActiveSubscriptions();
        $totalUsers = User::all()->count();

        return number_format(($totalUsers > 0 ? $totalSubscriptions / $totalUsers * 100 : 0), 2) . '%';
    }
}
