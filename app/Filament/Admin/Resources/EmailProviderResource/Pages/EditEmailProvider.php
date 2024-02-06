<?php

namespace App\Filament\Admin\Resources\EmailProviderResource\Pages;

use App\Filament\Admin\Resources\EmailProviderResource;
use App\Models\EmailProvider;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEmailProvider extends EditRecord
{
    protected static string $resource = EmailProviderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            \Filament\Actions\Action::make('edit-credentials')
                ->label(__('Edit Credentials'))
                ->color('primary')
                ->icon('heroicon-o-rocket-launch')
                ->url(fn (EmailProvider $record): string => \App\Filament\Admin\Resources\EmailProviderResource::getUrl(
                    $record->slug . '-settings'
                )),
        ];
    }
}
