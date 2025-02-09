<?php

namespace App\Filament\Resources\BchResource\Pages;

use App\Filament\Resources\BchResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBches extends ListRecords
{
    protected static string $resource = BchResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
            ->label('Tambah Kelompok')
            ->color('success')
            ->icon('heroicon-o-plus-circle'),
        ];
    }
}
