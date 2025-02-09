<?php

namespace App\Filament\Imports;

use App\Models\Prdp;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class PrdpImporter extends Importer
{
    protected static ?string $model = Prdp::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('id')
                ->label('ID Program Studi')
                ->requiredMapping()
                ->rules([
                    'required',
                ]),
            ImportColumn::make('prdp_unv_id')
                ->label('ID Universitas')
                ->requiredMapping()
                ->rules([
                    'required',
                ]),
            ImportColumn::make('prdp_kode')
                ->label('Kode Program Studi')
                ->requiredMapping()
                ->rules([
                    'required',
                ]),
            ImportColumn::make('prdp_nama')
                ->label('Nama Program Studi')
                ->requiredMapping()
                ->rules([
                    'required',
                ])
                ->fillRecordUsing(function (Prdp $record, string $state): void {
                    $record->prdp_nama = strtolower($state);
                })
        ];
    }

    public function resolveRecord(): ?Prdp
    {
        return Prdp::firstOrNew([
            // Update existing records, matching them by `$this->data['column_name']`
            'id' => $this->data['id'],
        ],[
            'prdp_unv_id' => $this->data['prdp_unv_id'],
            'prdp_kode' => $this->data['prdp_kode'],
            'prdp_nama' => $this->data['prdp_nama'],
        ]);

        // return new Prdp();
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Proses Import Data Program Studi Selesai, Sebanyak ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' Data Berhasil Diimport.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' Sebanyak ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' Gagal Diimport.';
        }

        return $body;
    }
}
