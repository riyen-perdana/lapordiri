<?php

namespace App\Filament\Imports;

use App\Models\Kec;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class KecImporter extends Importer
{
    protected static ?string $model = Kec::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('kec_kkot_id')
                ->label('Kode Kabupaten Kota')
                ->requiredMapping()
                ->rules([
                    'required',
                ]),
            ImportColumn::make('kec_kode')
                ->label('Kode Kecamatan')
                ->requiredMapping()
                ->rules([
                    'required',
                    'unique:kec,kec_kode'
                ]),
            ImportColumn::make('kec_nama')
                ->label('Nama Kecamatan')
                ->requiredMapping()
                ->rules([
                    'required',
                ])
                ->fillRecordUsing(function (Kec $record, string $state): void {
                    $record->kec_nama = strtolower($state);
                }),
        ];
    }

    public function resolveRecord(): ?Kec
    {
        return Kec::firstOrNew([
            'kec_kode' => $this->data['kec_kode'],
        ],[
            'kec_nama' => $this->data['kec_nama'],
            'kec_kkot_id' => $this->data['kec_kkot_id'],
        ]);

        // return new Kec();
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Proses Import Data Kecamatan Selesai, Sebanyak ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' Data Berhasil Diimport.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' Sebanyak ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' Gagal Diimport.';
        }

        return $body;
    }
}
