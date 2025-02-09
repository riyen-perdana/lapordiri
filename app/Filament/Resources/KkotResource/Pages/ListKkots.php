<?php

namespace App\Filament\Resources\KkotResource\Pages;

use App\Filament\Imports\KkotImporter;
use App\Filament\Resources\KkotResource;
use Filament\Actions;
use Filament\Actions\ImportAction;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Validation\Rules\File;

class ListKkots extends ListRecords
{
    protected static string $resource = KkotResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Tambah Kabupaten-Kota')
                ->color('success')
                ->icon('heroicon-o-plus-circle'),
            ImportAction::make('importKabupatenKota')
                ->importer(KkotImporter::class)
                ->label('Import Kabupaten-Kota')
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
