<?php

namespace App\Filament\Resources\UnvResource\Pages;

use App\Filament\Resources\UnvResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditUnv extends EditRecord
{
    protected static string $resource = UnvResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
