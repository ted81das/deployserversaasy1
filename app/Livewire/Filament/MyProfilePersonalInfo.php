<?php

namespace App\Livewire\Filament;

use Filament\Forms;
use Jeffgreco13\FilamentBreezy\Livewire\PersonalInfo;

class MyProfilePersonalInfo extends PersonalInfo
{
    public array $only = ['name'];

    protected function getProfileFormSchema()
    {
        $groupFields = Forms\Components\Group::make([
            $this->getNameComponent(),
        ])->columnSpan(2);

        return ($this->hasAvatars)
            ? [filament('filament-breezy')->getAvatarUploadComponent(), $groupFields]
            : [$groupFields];
    }
}
