<?php

namespace App\Filament\Admin\Widgets;

use App\Services\MetricsManager;
use Filament\Support\RawJs;
use Filament\Widgets\ChartWidget;
use Illuminate\Contracts\Support\Htmlable;

class ChurnChart extends ChartWidget
{
    protected static ?int $sort = 2;
    private MetricsManager $metricsManager;
    protected static ?string $pollingInterval = null;

    public function boot(MetricsManager $metricsManager): void
    {
        $this->metricsManager = $metricsManager;
    }

    protected function getData(): array
    {
        $data = $this->metricsManager->calculateChurnRateChart();
        return [
            'datasets' => [
                [
                    'label' => 'Churn rate',
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
        return __('Churn rate overview');
    }

    public function getDescription(): string|Htmlable|null
    {
        return __('Churn rate is the percentage of users who cancel their subscription each month.');
    }

    protected function getOptions(): RawJs
    {
        return RawJs::make(<<<JS
        {
            scales: {
                y: {
                    ticks: {
                        callback: (value) => value + '%',
                    },
                },
            },
        }
    JS);
    }
}
