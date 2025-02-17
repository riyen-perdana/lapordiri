<?php

namespace App\Filament\Resources\PpgResource\Pages;

use App\Filament\Resources\PpgResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPpg extends EditRecord
{
    protected static string $resource = PpgResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
