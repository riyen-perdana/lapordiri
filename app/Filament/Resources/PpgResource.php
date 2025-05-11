<?php

namespace App\Filament\Resources;

use App\Enums\Semester;
use App\Models\Ppg;
use Filament\Forms;
use Filament\Tables;
use Nette\Utils\Html;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Faker\Provider\ar_EG\Text;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Illuminate\Support\HtmlString;
use Filament\Support\Enums\Alignment;
use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\Tabs;
use Illuminate\Database\Eloquent\Model;
use Filament\Infolists\Components\Split;
use Filament\Notifications\Notification;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use App\Filament\Resources\PpgResource\Pages;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\Actions\Action;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PpgResource\RelationManagers;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class PpgResource extends Resource
{
    protected static ?string $model = Ppg::class;
    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';
    protected static ?string $navigationGroup = 'Data PPG';
    protected static ?string $navigationLabel = 'Peserta';
    protected static ?string $pluralModelLabel = 'Peserta';
    protected static ?int $navigationSort = 9;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->emptyStateIcon('heroicon-o-bookmark')
            ->emptyStateHeading('Data Tidak Ditemukan')
            ->emptyStateDescription('Kami Sudah Mencari Keseluruh Sumber Data, Namun Data Tidak Ditemukan')
            ->columns([
                Tables\Columns\TextColumn::make('index')
                    ->rowIndex()
                    ->label('No.')
                    ->width('3%'),
                Tables\Columns\ImageColumn::make('ppg_foto')
                    ->label('Pas Foto')
                    ->circular(),
                Tables\Columns\TextColumn::make('ppg_nama')
                    ->label('Nama Peserta')
                    ->sortable()
                    ->searchable()
                    ->description(function (Ppg $record) {
                        return (new HtmlString('NIK : ' . $record->ppg_nik . '<br>SIMPATIKA : ' . $record->ppg_simpatika));
                    })
                    ->width('20%'),
                Tables\Columns\TextColumn::make('ppg_nim')
                    ->label('NIM')
                    ->default('-')
                    ->sortable()
                    ->searchable()
                    ->width('10%'),
                Tables\Columns\TextColumn::make('ppg_no_wa')
                    ->label('No Whatsapp')
                    ->sortable()
                    ->searchable()
                    ->width('10%'),
                Tables\Columns\TextColumn::make('ppg_sklh')
                    ->label('Sekolah Asal')
                    ->sortable()
                    ->searchable()
                    ->width('10%')
                    ->description(function (Ppg $record) {
                        return (new HtmlString('No.Op Sekolah : ' . $record->ppg_no_ops));
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal Daftar')
                    ->dateTime(fn(Ppg $record): ?string => date_format($record->created_at, 'd-m-Y'))
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('ppg_sts_vrf')
                    ->label('Status')
                    ->sortable()
                    ->searchable()
                    ->badge()
                    ->color(function (Ppg $record) {
                        return $record->ppg_sts_vrf === 1 ? 'success' : 'danger';
                    })
                    ->formatStateUsing(fn($record) => $record->ppg_sts_vrf === 1 ? 'Verifikasi' : 'Belum Verifikasi'),
            ])
            ->filters([
                SelectFilter::make('ppg_set_id')
                    ->relationship('set', 'set_thn')
                    ->label('Tahun')
                    ->preload(),
                SelectFilter::make('ppg_bc_id')
                    ->relationship('bch', 'bch_sesi')
                    ->label('Batch')
                    ->preload(),
            ])
            ->actions([
                ActionGroup::make([
                    // Tables\Actions\EditAction::make(),
                    Tables\Actions\ViewAction::make()
                        ->label('Detail')
                        ->modalHeading(fn(Ppg $record) => 'Detail Data Peserta ' . $record->ppg_nama . '')
                        ->modalCloseButton(false),
                    Tables\Actions\DeleteAction::make()
                        ->label('Hapus')
                        ->requiresConfirmation()
                        ->successNotification(
                            Notification::make()
                                ->success()
                                ->title('Sukses')
                                ->body('Data Peserta Berhasil Dihapus')
                        )
                        ->modalHeading(fn(Ppg $record) => 'Hapus Data Peserta ' . $record->ppg_nama . '')
                        ->modalDescription('Apakah Anda Yakin Menghapus Data Ini?')
                        ->modalCancelActionLabel('Tidak')
                        ->modalSubmitActionLabel('Ya, Hapus Data'),
                ])
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ExportBulkAction::make()
                        ->label('Export Data PPG')
                        ->exporter('App\Filament\Exports\PpgExporter')
                        ->successNotification(
                            Notification::make()
                                ->success()
                                ->title('Sukses')
                                ->body('Data Peserta PPG Berhasil Diexport')
                        )
                ]),
                Tables\Actions\BulkAction::make('Export')
                    ->label('Export Ke iRaise')
                    ->icon('heroicon-o-arrow-down')
                    ->action(
                        function (Collection $records) {
                            $records->each(function (Ppg $record) {
                                $nim = $record->ppg_nim;
                                $mhs = DB::connection('iraise')->table('mahasiswa')->where('id_pd', $nim)->first();
                                if(!$mhs) {

                                    //Create Data Mahasiswa
                                    DB::connection('iraise')->table('mahasiswa')->insert([
                                        'id_pd' => $nim,
                                        'nm_pd' => $record->ppg_nama,
                                        'jk' => $record->ppg_jk,
                                        'tgl_lahir' => $record->ppg_tgl_lhr,
                                        'tmpt_lahir' => $record->ppg_tpt_lhr,
                                        'nm_ibu_kandung' => $record->ppg_ibu,
                                        'id_agama' => '1',
                                        'kewarganegaraan' => 'ID',
                                        'nisn' => $record->ppg_nisn,
                                        'nik' => $record->ppg_nik,
                                        'ds_kel' => $record->ppg_kel,
                                        'email' => $record->ppg_email,
                                        'id_wil' => str_pad($record->kec->kec_kode, 6, '0', STR_PAD_LEFT),
                                        'id_sp' => 'b2cb4d44-187c-4e2d-8e5b-f4f2ae1a6df8',
                                        'regpd_id_jns_daftar' => '18',
                                        'regpd_id_sms' => 'PPG',
                                        'id_jalur_penerimaan' => '11',
                                        'telepon_seluler' => $record->ppg_no_hp,
                                        'a_terima_kps' => '0',
                                        'stat_pd' => 'A',
                                        'regpd_nipd' => $nim,
                                        'regpd_mulai_smt' => $record->set->set_thn .''. $record->set->set_smt->getValue(),
                                        'password' => md5($nim),
                                        'pilihan_kelas' => 'A',
                                        'status_program' => 'REGULER'
                                    ]);

                                    //Create Data Mahasiswa History
                                    DB::connection('iraise')->table('mahasiswa_history')->insert([
                                        'id_sms' => 'PPG',
                                        'id_sp' => $nim,
                                        'id_jns_daftar' => '18',
                                        'nipd' => $nim,
                                        'tgl_masuk_sp' => now(),
                                        'a_pernah_paud' => '1',
                                        'a_pernah_tk' => '0',
                                        'mulai_smt' => $record->set->set_thn .''. $record->set->set_smt->getValue(),
                                        'biaya_masuk' => $record->jnp->jnp_mb,
                                        'id_jalur_masuk' => '11',
                                        'id_pembiayaan' => '3',
                                    ]);

                                    //Create Data Kuliah_mhs
                                    $id_smt = intval($record->set->set_thn .''. $record->set->set_smt->getValue());
                                    $jlh_bayar = $record->jnp->jnp_mb;
                                    $total_bayar = $record->jnp->jnp_mb;
                                    
                                    // for ($i=1; $i <= 2; $i++) {
                                    //     if($i == 1) {
                                    //         $id_smt = $id_smt;
                                    //         $jlh_bayar = $record->jnp->jnp_mb;
                                    //         $total_bayar = $record->jnp->jnp_mb;
                                    //     } else {
                                    //         if(intval($id_smt) % 2 == 0) {
                                    //             $id_smt = $id_smt + 9;
                                    //         } else {
                                    //             $id_smt = $id_smt + 1;
                                    //         }
                                    //         $jlh_bayar = 0;
                                    //         $total_bayar = 0;
                                    //     }

                                        DB::connection('iraise')->table('kuliah_mhs')->insert([
                                            'id_smt' => $id_smt,
                                            'id_reg_pd' => $nim,
                                            'ips' => 0,
                                            'sks_smt' => 24,
                                            'ipk' => 0,
                                            'sks_total' => 24,
                                            'id_stat_mhs' => 'A',
                                            'semester' => 1,
                                            'tgl_bayar' => now(),
                                            'jlh_bayar' => $jlh_bayar,
                                            'status_bayar' => 1,
                                            'sks_max' => 24,
                                            'paket' => 1,
                                            'total_bayar' => $total_bayar,
                                        ]);
                                    // }

                                    //Create Data Biodata_Transfer
                                    DB::connection('iraise')->table('biodata_transfer')->insert([
                                        'id_reg_pd' => $nim,
                                        'kategori_transfer' => 'Transfer Luar',
                                        'id_sp_asal' => $record->prdp->unv->id,
                                        'id_sms_asal' => $record->ppg_prdp_id,
                                    ]);
                                }
                            });
                            Notification::make()
                                ->title('Sukses')
                                ->body('Data Peserta PPG Berhasil Diexport')
                                ->success()
                                ->send();
                        }
                    )
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPpgs::route('/'),
            'create' => Pages\CreatePpg::route('/create'),
            'edit' => Pages\EditPpg::route('/{record}/edit'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canEdit(Model $record): bool
    {
        return false;
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Grid::make()
                    ->columns([
                        'sm' => 1,
                        'xl' => 1,
                        '2xl' => 1,
                    ]),

                Section::make('Data Peserta PPG Universitas Islam Negeri Sultan Syarif Kasim Riau')
                    ->hiddenLabel()
                    ->footerActions([
                        Action::make('Verifikasi')
                            ->label(fn(Ppg $ppg): ?string => $ppg->ppg_sts_vrf == 1 ? 'Sudah Diverifikasi' : 'Belum Diverifikasi')
                            ->action(
                                fn(Ppg $ppg) => $ppg->update([
                                    'ppg_sts_vrf' => 1
                                ])
                            )
                            ->disabled(fn(Ppg $ppg): bool => $ppg->ppg_sts_vrf == 1),
                    ])
                    ->footerActionsAlignment(Alignment::End)
                    ->schema([
                        Tabs::make('Tabs')
                            ->tabs([
                                Tabs\Tab::make('Data Pribadi')
                                    ->schema([
                                        Section::make('')
                                            ->schema([
                                                ImageEntry::make('ppg_foto')
                                                    ->label('')
                                                    ->square()
                                                    ->width(176)
                                                    ->height(236)
                                                    ->alignCenter(),
                                                Section::make('')
                                                    ->schema([
                                                        TextEntry::make('ppg_nama')
                                                            ->label('Nama Peserta')
                                                            ->extraAttributes([
                                                                'class' => 'font-bold -mt-4',
                                                            ]),
                                                        TextEntry::make('ppg_nik')
                                                            ->label('Nomor Induk Kependudukan')
                                                            ->extraAttributes([
                                                                'class' => 'font-bold -mt-4',
                                                            ]),
                                                        TextEntry::make('ppg_simpatika')
                                                            ->label('Akun SIMPATIKA')
                                                            ->extraAttributes([
                                                                'class' => 'font-bold -mt-4',
                                                            ]),
                                                        TextEntry::make('ppg_nisn')
                                                            ->label('Nomor Induk Siswa Nasional (NISN)')
                                                            ->extraAttributes([
                                                                'class' => 'font-bold -mt-4',
                                                            ]),
                                                        TextEntry::make('ppg_email')
                                                            ->label('Email')
                                                            ->extraAttributes([
                                                                'class' => 'font-bold -mt-4',
                                                            ]),
                                                        TextEntry::make('ppg_jk')
                                                            ->label('Jenis Kelamin')
                                                            ->extraAttributes([
                                                                'class' => 'font-bold -mt-4',
                                                            ]),
                                                        TextEntry::make('agm.agm_nama')
                                                            ->label('Agama')
                                                            ->extraAttributes([
                                                                'class' => 'font-bold -mt-4',
                                                            ]),
                                                        TextEntry::make('ppg_tpt_lhr')
                                                            ->label('Tempat Lahir')
                                                            ->extraAttributes([
                                                                'class' => 'font-bold -mt-4',
                                                            ]),
                                                        TextEntry::make('ppg_tgl_lhr')
                                                            ->label('Tempat Lahir')
                                                            ->extraAttributes([
                                                                'class' => 'font-bold -mt-4',
                                                            ]),
                                                        TextEntry::make('ppg_ibu')
                                                            ->label('Nama Ibu Kandung')
                                                            ->extraAttributes([
                                                                'class' => 'font-bold -mt-4',
                                                            ]),
                                                        TextEntry::make('kec.kkot.prov.prov_nama')
                                                            ->label('Provinsi Asal')
                                                            ->extraAttributes([
                                                                'class' => 'font-bold -mt-4',
                                                            ]),
                                                        TextEntry::make('kec.kkot.kkot_nama')
                                                            ->label('Kabupaten Kota Asal')
                                                            ->extraAttributes([
                                                                'class' => 'font-bold -mt-4',
                                                            ]),
                                                        TextEntry::make('kec.kec_nama')
                                                            ->label('Kecamatan Asal')
                                                            ->extraAttributes([
                                                                'class' => 'font-bold -mt-4',
                                                            ]),
                                                        TextEntry::make('ppg_no_wa')
                                                            ->label('No Whatsapp')
                                                            ->extraAttributes([
                                                                'class' => 'font-bold -mt-4',
                                                            ]),
                                                    ])
                                                    ->columns(2)
                                            ])
                                    ]),
                                Tabs\Tab::make('Sekolah dan Universitas')
                                    ->schema([
                                        Section::make('')
                                            ->schema([
                                                TextEntry::make('ppg_sklh')
                                                    ->label('Sekolah Asal')
                                                    ->extraAttributes([
                                                        'class' => 'font-bold -mt-4',
                                                    ]),
                                                TextEntry::make('ppg_no_ops')
                                                    ->label('No Op Sekolah')
                                                    ->extraAttributes([
                                                        'class' => 'font-bold -mt-4',
                                                    ]),
                                                TextEntry::make('prdp.unv.unv_nama')
                                                    ->label('Nama Universitas Asal')
                                                    ->extraAttributes([
                                                        'class' => 'font-bold -mt-4',
                                                    ]),
                                                TextEntry::make('prdp.prdp_nama')
                                                    ->label('Program Studi Asal')
                                                    ->extraAttributes([
                                                        'class' => 'font-bold -mt-4',
                                                    ]),
                                                TextEntry::make('ppg_ipk')
                                                    ->label('IPK')
                                                    ->extraAttributes([
                                                        'class' => 'font-bold -mt-4',
                                                    ])
                                            ])
                                    ]),
                                Tabs\Tab::make('Data Unggah RPL')
                                    ->schema([
                                        TextEntry::make('ppg_ijz')
                                            ->html()
                                            ->label('File Ijazah')
                                            ->state('Unduh File')
                                            ->extraAttributes([
                                                'class' => 'font-bold -mt-3',
                                            ])
                                            ->url(fn(Ppg $record): string => '/storage/' . $record->ppg_ijz, shouldOpenInNewTab: true),
                                        TextEntry::make('ppg_trsk')
                                            ->html()
                                            ->label('File Transkrip Nilai')
                                            ->state('Unduh File')
                                            ->extraAttributes([
                                                'class' => 'font-bold -mt-3',
                                            ])
                                            ->url(fn(Ppg $record): string => '/storage/' . $record->ppg_trsk, shouldOpenInNewTab: true),
                                        TextEntry::make('ppg_sk_ajr')
                                            ->html()
                                            ->label('File SK Mengajar')
                                            ->state('Unduh File')
                                            ->extraAttributes([
                                                'class' => 'font-bold -mt-3',
                                            ])
                                            ->url(fn(Ppg $record): string => '/storage/' . $record->ppg_sk_ajr, shouldOpenInNewTab: true),
                                        TextEntry::make('ppg_prkt_ajr')
                                            ->html()
                                            ->label('File Perangkat Mengajar')
                                            ->state('Unduh File')
                                            ->extraAttributes([
                                                'class' => 'font-bold -mt-3',
                                            ])
                                            ->url(fn(Ppg $record): string => '/storage/' . $record->ppg_prkt_ajr, shouldOpenInNewTab: true),
                                        TextEntry::make('ppg_strf')
                                            ->html()
                                            ->label('File Sertifikat')
                                            ->state('Unduh File')
                                            ->extraAttributes([
                                                'class' => 'font-bold -mt-3',
                                            ])
                                            ->url(fn(Ppg $record): string => '/storage/' . $record->ppg_strf, shouldOpenInNewTab: true),
                                        TextEntry::make('ppg_dkmn')
                                            ->html()
                                            ->label('File Dokumen Ajar')
                                            ->state('Unduh File')
                                            ->extraAttributes([
                                                'class' => 'font-bold -mt-3',
                                            ])
                                            ->url(fn(Ppg $record): string => '/storage/' . $record->ppg_dkmn, shouldOpenInNewTab: true),
                                        TextEntry::make('ppg_invs')
                                            ->html()
                                            ->label('File Inovasi Mengajar')
                                            ->state('Unduh File')
                                            ->extraAttributes([
                                                'class' => 'font-bold -mt-3',
                                            ])
                                            ->url(fn(Ppg $record): string => '/storage/' . $record->ppg_invs, shouldOpenInNewTab: true),
                                    ])
                                    ->columns(2),
                            ])
                    ])
            ]);
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
