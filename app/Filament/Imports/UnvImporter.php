<?php

namespace App\Filament\Imports;

use App\Models\Unv;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class UnvImporter extends Importer
{
    protected static ?string $model = Unv::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('id')
                ->label('ID Universitas')
                ->requiredMapping()
                ->rules([
                    'required',
                    'unique:unv,id'
                ]),
            ImportColumn::make('unv_kode')
                ->label('Kode Universitas')
                ->requiredMapping()
                ->rules([
                    'required',
                ]),
            ImportColumn::make('unv_nama')
                ->label('Nama Universitas')
                ->requiredMapping()
                ->rules([
                    'required',
                ])
                ->fillRecordUsing(function (Unv $record, string $state): void {
                    $record->unv_nama = strtolower($state);
                }),
        ];
    }

    public function resolveRecord(): ?Unv
    {
        return Unv::firstOrNew([
            'id' => $this->data['id'],
        ],[
            'unv_kode' => $this->data['unv_kode'],
            'unv_nama' => $this->data['unv_nama'],
        ]);

        // return new Unv();
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Proses Import Data Universitas Selesai, Sebanyak ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' Data Berhasil Diimport.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' Sebanyak ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' Gagal Diimport.';
        }

        return $body;
    }
}
