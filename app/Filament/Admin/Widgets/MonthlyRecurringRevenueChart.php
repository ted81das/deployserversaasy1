<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Currency;
use App\Services\MetricsManager;
use Filament\Support\RawJs;
use Filament\Widgets\ChartWidget;
use Illuminate\Contracts\Support\Htmlable;

class MonthlyRecurringRevenueChart extends ChartWidget
{
    protected static ?int $sort = 1;

    protected static ?string $pollingInterval = null;
    private MetricsManager $metricsManager;

    public function boot(MetricsManager $metricsManager): void
    {
        $this->metricsManager = $metricsManager;
    }

    protected function getData(): array
    {
        $data = $this->metricsManager->calculateMRRChart();
        return [
            'datasets' => [
                [
                    'label' => 'MRR',
                    'data' => array_values($data),
                ],
            ],
            'labels' => array_keys($data),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    public function getHeading(): string | Htmlable | null
    {
        return __('Monthly recurring revenue (MRR) overview');
    }

    public function getDescription(): string|Htmlable|null
    {
        return __('MRR takes into account only active subscriptions (no trials).');
    }

    protected function getOptions(): RawJs
    {
        $currentCurrency = config('app.default_currency');
        $currency = Currency::where('code', $currentCurrency)->first();
        $symbol = $currency->symbol;

        return RawJs::make(<<<JS
        {
            scales: {
                y: {
                    ticks: {
                        callback: (value) => '$symbol' + value,
                    },
                },
            },
        }
    JS);
    }
}
