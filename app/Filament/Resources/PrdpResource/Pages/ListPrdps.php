<?php

namespace App\Filament\Resources\PrdpResource\Pages;

use App\Filament\Imports\PrdpImporter;
use App\Filament\Resources\PrdpResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions\ImportAction;
use Illuminate\Validation\Rules\File;

class ListPrdps extends ListRecords
{
    protected static string $resource = PrdpResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Tambah Program Studi')
                ->color('success')
                ->icon('heroicon-o-plus-circle'),
            ImportAction::make('importProdi')
                ->importer(PrdpImporter::class)
                ->label('Import Program Studi')
                ->color('danger')
                ->icon('heroicon-o-arrow-up-on-square-stack')
                ->fileRules([
                    File::types(['csv', 'txt']),
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
