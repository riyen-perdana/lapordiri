<?php

namespace App\Filament\Imports;

use App\Models\Kkot;
use App\Models\Prov;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Models\Import;

class KkotImporter extends Importer
{
    protected static ?string $model = Kkot::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('kkot_prov_id')
                ->label('Kode Provinsi')
                ->requiredMapping()
                ->rules([
                    'required',
                ]),
            ImportColumn::make('kkot_kode')
                ->label('Kode Kabupaten Kota')
                ->requiredMapping()
                ->rules([
                    'required',
                    'unique:kkot,kkot_kode'
                ]),
            ImportColumn::make('kkot_nama')
                ->label('Nama Kabupaten Kota')
                ->requiredMapping()
                ->rules([
                    'required',
                ])
                ->fillRecordUsing(function (Kkot $record, string $state): void {
                    $record->kkot_nama = strtolower($state);
                }),
        ];
    }

    public function resolveRecord(): ?Kkot
    {
        // $prov = Prov::select('id')->where('prov_kode', $this->data['prov'])->first();
        // print_r($this->data);
        return Kkot::firstOrNew([
            'kkot_kode' => $this->data['kkot_kode'],
        ],[
            'kkot_nama' => $this->data['kkot_nama'],
            'kkot_prov_id' => $this->data['kkot_prov_id'],
        ]);

        // return new Kkot();
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Proses Import Data Kabupaten-Kota Selesai, Sebanyak ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' Data Berhasil Diimport.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' Sebanyak ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' Gagal Diimport.';
        }

        return $body;
    }
}
