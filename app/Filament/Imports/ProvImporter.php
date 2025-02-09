<?php

namespace App\Filament\Imports;

use App\Models\Prov;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class ProvImporter extends Importer
{
    protected static ?string $model = Prov::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('prov_kode')
                ->label('Kode Provinsi')
                ->requiredMapping()
                ->rules([
                    'required',
                    'unique:prov,prov_kode'
                ]),
            ImportColumn::make('prov_nama')
                ->label('Nama Provinsi')
                ->requiredMapping()
                ->rules([
                    'required',
                ])
                ->fillRecordUsing(function (Prov $record, string $state): void {
                    $record->prov_nama = strtolower($state);
                }),
        ];
    }

    public function resolveRecord(): ?Prov
    {
        return Prov::firstOrNew([
            'prov_kode' => $this->data['prov_kode'],
        ],[
            'prov_nama' => $this->data['prov_nama'],
        ]);

        // return new Prov();
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Proses Import Data Provinsi Selesai, Sebanyak ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' Data Berhasil Diimport.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' Sebanyak ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' Gagal Diimport.';
        }

        return $body;
    }

}
