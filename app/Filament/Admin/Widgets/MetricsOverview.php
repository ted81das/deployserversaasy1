<?php

namespace App\Filament\Admin\Widgets;

use App\Services\MetricsManager;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Carbon;

class MetricsOverview extends BaseWidget
{
    protected static ?int $sort = 0;
    protected static ?string $pollingInterval = null;

    private MetricsManager $metricsManager;

    public function boot(MetricsManager $metricsManager): void
    {
        $this->metricsManager = $metricsManager;
    }
    protected function getStats(): array
    {
        $currentMrr = $this->metricsManager->calculateMRR(now());
        $previewMrr = $this->metricsManager->calculateMRR(Carbon::yesterday());
        $mrrDescription = '';
        $mrrIcon = '';
        $color = 'success';

        if ($previewMrr) {
            $mrrDescription = $previewMrr > $currentMrr ? __('decrease') : __('increase');
            $mrrDescription = money(abs($currentMrr - $previewMrr), config('app.default_currency')) . ' ' . $mrrDescription;
            $mrrIcon = $previewMrr > $currentMrr ? 'heroicon-m-arrow-down' : 'heroicon-m-arrow-up';
            $color = $previewMrr > $currentMrr ? 'danger' : 'success';
        }

        return [
            Stat::make(
                __('MRR'),
                money($currentMrr, config('app.default_currency'))
            )->description($mrrDescription)
                ->descriptionIcon($mrrIcon)
                ->color($color)
                ->chart([7, 2, 10, 3, 15, 4, 17])  // just for decoration :)
            ,
            Stat::make(
                __('Active Subscriptions'),
                $this->metricsManager->getActiveSubscriptions()
            ),
            Stat::make(
                __('Total revenue'),
                $this->metricsManager->getTotalRevenue()
            ),
            Stat::make(
                __('Total user subscription conversion'),
                $this->metricsManager->getTotalCustomerConversion()
            )->description(__('subscribed / total users')),
            Stat::make(
                __('Total Transactions'),
                $this->metricsManager->getTotalTransactions()
            ),

            Stat::make(
                __('Total Users'),
                $this->metricsManager->getTotalUsers()
            ),
        ];
    }
}
