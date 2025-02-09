<?php

namespace App\Filament\Resources\BchResource\Pages;

use App\Filament\Resources\BchResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBch extends EditRecord
{
    protected static string $resource = BchResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
