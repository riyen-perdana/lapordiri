<?php

namespace App\Filament\Resources\KecResource\Pages;

use App\Filament\Resources\KecResource;
use Filament\Actions\Action;
use Filament\Actions;
use Filament\Actions\ImportAction;
use Illuminate\Validation\Rules\File;
use Filament\Resources\Pages\ListRecords;

class ListKecs extends ListRecords
{
    protected static string $resource = KecResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
            ->label('Tambah Kecamatan')
            ->color('success')
            ->icon('heroicon-o-plus-circle'),
        ImportAction::make('importProvinsi')
            ->importer(ProvImporter::class)
            ->label('Import Kecamatan')
            ->color('danger')
            ->icon('heroicon-o-arrow-up-on-square-stack')
            ->fileRules([
                File::types(['csv', 'txt'])->max(1024),
            ])
            ->csvDelimiter(';')
            ->chunkSize(250),
        Actions\Action::make('refresh')
            ->label('Refresh')
            ->color('warning')
            ->icon('heroicon-o-arrow-path')
            ->button()
            ->action(function () {
                redirect(static::getUrl(['index']));
            }),
        ];
    }
}
