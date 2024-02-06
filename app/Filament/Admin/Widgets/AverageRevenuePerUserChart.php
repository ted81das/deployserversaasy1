<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Currency;
use App\Services\MetricsManager;
use Filament\Support\RawJs;
use Filament\Widgets\ChartWidget;
use Illuminate\Contracts\Support\Htmlable;

class AverageRevenuePerUserChart extends ChartWidget
{
    protected static ?int $sort = 3;
    protected static ?string $pollingInterval = null;
    private MetricsManager $metricsManager;

    public function boot(MetricsManager $metricsManager): void
    {
        $this->metricsManager = $metricsManager;
    }

    protected function getData(): array
    {
        $data = $this->metricsManager->calculateAverageRevenuePerUserChart();
        return [
            'datasets' => [
                [
                    'label' => 'ARPU',
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
        return __('Average revenue per user (ARPU) overview');
    }

    public function getDescription(): string|Htmlable|null
    {
        return __('ARPU takes into account all users, including those who churned or never subscribed.');
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
