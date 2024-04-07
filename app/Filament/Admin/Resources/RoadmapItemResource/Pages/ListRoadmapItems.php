<?php

namespace App\Filament\Admin\Resources\RoadmapItemResource\Pages;

use App\Filament\Admin\Resources\RoadmapItemResource;
use App\Filament\ListDefaults;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRoadmapItems extends ListRecords
{
    use ListDefaults;

    protected static string $resource = RoadmapItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
