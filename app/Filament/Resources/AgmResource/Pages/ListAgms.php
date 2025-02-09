<?php

namespace App\Filament\Resources\AgmResource\Pages;

use App\Filament\Resources\AgmResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAgms extends ListRecords
{
    protected static string $resource = AgmResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Tambah Agama')
                ->color('success')
                ->icon('heroicon-o-plus-circle')
        ];
    }
}
