<?php

namespace App\Filament\Exports;

use App\Models\Ppg;
use Illuminate\Support\Str;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class PpgExporter extends Exporter
{
    protected static ?string $model = Ppg::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label('ID PPG'),
            ExportColumn::make('ppg_nik')
                ->label('NIK'),
            ExportColumn::make('ppg_simpatika')
                ->label('Simpatika'),
            ExportColumn::make('ppg_nisn')
                ->label('NISN'),
            ExportColumn::make('ppg_nama')
                ->label('Nama'),
            ExportColumn::make('ppg_email')
                ->label('Email'),
            ExportColumn::make('ppg_nim')
                ->label('NIM'),
            ExportColumn::make('ppg_kps')
                ->label('KPS'),
            // ExportColumn::make('ppg_jk')
            //     ->label('Jenis Kelamin'),
            ExportColumn::make('agm.agm_nama')
                ->label('Agama'),
            ExportColumn::make('ppg_tpt_lhr')
                ->label('Tempat Lahir'),
            ExportColumn::make('ppg_tgl_lhr')
                ->label('Tanggal Lahir'),
            ExportColumn::make('ppg_ibu')
                ->label('Nama Ibu Kandung'),
            ExportColumn::make('ppg_kel')
                ->label('Kelurahan'),
            ExportColumn::make('kec.kec_nama')
                ->label('Kecamatan'),
            ExportColumn::make('ppg_kec_id')
                ->formatStateUsing(fn (Model $record) => $record->kec->kkot->kkot_nama)
                ->label('Kabupaten/Kota'),
            ExportColumn::make('kec.kec_kkot_id')
                ->formatStateUsing(fn (Model $record) => $record->kec->kkot->prov->prov_nama)
                ->label('Provinsi'),
            ExportColumn::make('ppg_no_hp')
                ->label('No. HP'),
            ExportColumn::make('ppg_no_wa')
                ->label('No. WhatsApp'),
            ExportColumn::make('ppg_wrgn_id')
                ->label('Kewarganegaraan'),
            ExportColumn::make('ppg_sklh')
                ->label('Sekolah Asal'),
            ExportColumn::make('ppg_no_ops')
                ->label('No. Operator Sekolah'),
            ExportColumn::make('prdp.prdp_nama')
                ->label('Program Studi Asal'),
            ExportColumn::make('ppg_prdp_id')
                ->formatStateUsing(fn (Model $record) => $record->prdp->unv->unv_nama)
                ->label('Universitas Asal'),
            ExportColumn::make('ppg_ipk')
                ->label('IPK'),
            ExportColumn::make('set.set_thn')
                ->label('Tahun Masuk'),
            ExportColumn::make('bch.bch_sesi')
                ->label('Batch'),

        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your ppg export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
