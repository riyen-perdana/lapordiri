<?php

namespace App\Filament\Resources\JlpResource\Pages;

use App\Filament\Resources\JlpResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListJlps extends ListRecords
{
    protected static string $resource = JlpResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
            ->label('Tambah Jalur Penerimaan')
            ->color('success')
            ->icon('heroicon-o-plus-circle'),
        ];
    }
}
