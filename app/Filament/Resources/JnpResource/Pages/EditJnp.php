<?php

namespace App\Filament\Resources\JnpResource\Pages;

use App\Filament\Resources\JnpResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditJnp extends EditRecord
{
    protected static string $resource = JnpResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
