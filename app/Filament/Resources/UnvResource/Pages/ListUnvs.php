<?php

namespace App\Filament\Resources\UnvResource\Pages;

use App\Filament\Imports\UnvImporter;
use Filament\Actions;
use Filament\Actions\ImportAction;
use Illuminate\Validation\Rules\File;
use App\Filament\Resources\UnvResource;
use Filament\Resources\Pages\ListRecords;

class ListUnvs extends ListRecords
{
    protected static string $resource = UnvResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Tambah Universitas')
                ->color('success')
                ->icon('heroicon-o-plus-circle'),
            ImportAction::make('importUniversitas')
                ->importer(UnvImporter::class)
                ->label('Import Universitas')
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
