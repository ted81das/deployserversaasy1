<?php

namespace App\Filament\Admin\Widgets;

use App\Services\MetricsManager;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

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
        $mrr = $this->metricsManager->calculateMRR();
        $mrrDescription = '';
        $mrrIcon = '';

        if (isset($mrr['previous']) ) {
            $mrrDescription = $mrr['previous'] > $mrr['current'] ? __('decrease') : __('increase');
            $mrrDescription = money($mrr['diff'], config('app.default_currency')) . ' ' . $mrrDescription;
            $mrrIcon = $mrr['previous'] > $mrr['current'] ? 'heroicon-m-arrow-down' : 'heroicon-m-arrow-up';
        }

        return [
            Stat::make(
                __('MRR'),
                money($mrr['current'], config('app.default_currency'))
            )->description($mrrDescription)
                ->descriptionIcon($mrrIcon)
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
                __('Total user conversion'),
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
