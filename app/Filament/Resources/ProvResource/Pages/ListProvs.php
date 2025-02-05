<?php

namespace App\Filament\Resources\ProvResource\Pages;

use App\Filament\Imports\ProvImporter;
use App\Filament\Resources\ProvResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions\Action;
use Filament\Actions;
use Filament\Actions\ImportAction;
use Illuminate\Validation\Rules\File;

class ListProvs extends ListRecords
{
    protected static string $resource = ProvResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Tambah Provinsi')
                ->color('success')
                ->icon('heroicon-o-plus-circle'),
            ImportAction::make('importProvinsi')
                ->importer(ProvImporter::class)
                ->label('Import Provinsi')
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
