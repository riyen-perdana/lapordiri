<?php

namespace App\Filament\Resources;

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
                    ->searchable()
            ])
            ->filters([
                //
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make()
                    ->label('Detail')
                    ->modalHeading(fn(Ppg $record) => 'Detail Data Peserta ' . $record->ppg_nama . ''),
                Tables\Actions\DeleteAction::make()
                    ->label('Hapus')
                    ->requiresConfirmation()
                    ->successNotification(
                        Notification::make()
                            ->success()
                            ->title('Sukses')
                            ->body('Data Peserta Berhasil Dihapus')
                    )
                    ->modalHeading(fn(Ppg $record) => 'Hapus Data Batch ' . $record->ppg_nama . '')
                    ->modalDescription('Apakah Anda Yakin Menghapus Data Ini?')
                    ->modalCancelActionLabel('Tidak')
                    ->modalSubmitActionLabel('Ya, Hapus Data'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
                    ->footerActions([
                        Action::make('Verifikasi')
                            ->action(function () {
                                // ...
                            }),
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
}
