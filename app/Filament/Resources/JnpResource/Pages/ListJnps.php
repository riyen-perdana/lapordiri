<?php

namespace App\Filament\Resources\JnpResource\Pages;

use App\Filament\Resources\JnpResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListJnps extends ListRecords
{
    protected static string $resource = JnpResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
            ->label('Tambah Jenis Penerimaan')
            ->color('success')
            ->icon('heroicon-o-plus-circle'),
        ];
    }
}
