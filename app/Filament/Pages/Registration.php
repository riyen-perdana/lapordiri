<?php

namespace App\Filament\Pages;

use App\Models\Agm;
use App\Models\Kec;
use App\Models\Unv;
use App\Models\Kkot;
use App\Models\Prdp;
use App\Models\Prov;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Pages\Auth\Register;
use Illuminate\Support\Collection;
use Illuminate\Support\HtmlString;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Wizard;
use Illuminate\Support\Facades\Blade;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Illuminate\Contracts\Support\Htmlable;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\FileUpload;

class Registration extends Register
{
    protected ?string $maxWidth = '4xl';
    protected static ?string $getTitle = 'test';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Wizard::make([
                    Wizard\Step::make('Data Pribadi')
                        ->schema([
                            TextInput::make('ppg_nik')
                                ->label('Nomor Induk Kependudukan')
                                ->autofocus()
                                ->required()
                                ->validationMessages([
                                    'required' => 'Nomor Induk Kependudukan Harus Diisi',
                                ]),
                            TextInput::make('ppg_akn_siaga')
                                ->label('Nomor Akun Siaga/SIMPATIKA')
                                ->required()
                                ->validationMessages([
                                    'required' => 'Nomor Akun Siaga/SIMPATIKA Harus Diisi',
                                ]),
                            TextInput::make('ppg_nama')
                                ->label('Nama Lengkap Sesuai Ijazah Terakhir Tanpa Gelar')
                                ->placeholder('Contoh: Riyen Perdana')
                                ->required()
                                ->validationMessages([
                                    'required' => 'Nama Lengkap Sesuai Ijazah Terakhir Harus Diisi',
                                ]),
                            Select::make('ppg_jk')
                                ->placeholder('Pilih Jenis Kelamin')
                                ->label('Jenis Kelamin')
                                ->options([
                                    'L' => 'Laki-laki',
                                    'P' => 'Perempuan',
                                ])
                                ->required()
                                ->validationMessages([
                                    'required' => 'Jenis Kelamin Harus Dipilih',
                                ]),
                            Select::make('ppg_agama')
                                ->placeholder('Pilih Agama')
                                ->label('Agama')
                                ->options(Agm::orderBy('id')->pluck('agm_nama', 'id'))
                                ->required()
                                ->validationMessages([
                                    'required' => 'Agama Harus Dipilih',
                                ]),
                            TextInput::make('ppg_tempat_lahir')
                                ->label('Tempat Lahir')
                                ->required()
                                ->validationMessages([
                                    'required' => 'Tempat Lahir Harus Diisi',
                                ]),
                            DatePicker::make('ppg_tgl_lhr')
                                ->label('Tanggal Lahir')
                                ->required()
                                ->validationMessages([
                                    'required' => 'Tanggal Lahir Harus Diisi',
                                ]),
                            TextInput::make('ppg_nmik')
                                ->label('Nama Asli Ibu Kandung')
                                ->required()
                                ->validationMessages([
                                    'required' => 'Nama Asli Ibu Kandung Harus Diisi',
                                ]),
                            Select::make('prov')
                                ->preload()
                                ->live()
                                ->searchable()
                                ->placeholder('Pilih Provinsi Asal')
                                ->label('Provinsi Asal')
                                ->options(Prov::orderBy('prov_kode')->pluck('prov_nama', 'id'))
                                ->required()
                                ->validationMessages([
                                    'required' => 'Provinsi Asal Harus Dipilih',
                                ])
                                ->afterStateUpdated(fn(Get $get, Set $set) => $set('kabkot', null))
                                ->afterStateUpdated(fn(Get $get, Set $set) => $set('ppg_kec_id', null))
                                ->dehydrated(true),
                            Select::make('kabkot')
                                ->preload()
                                ->live()
                                ->searchable()
                                ->placeholder('Pilih Kabupaten Kota Asal')
                                ->label('Kabupaten Kota Asal')
                                ->options(fn(Get $get): Collection => Kkot::query()
                                    ->where('kkot_prov_id', $get('prov'))
                                    ->pluck('kkot_nama', 'id'))
                                ->required()
                                ->validationMessages([
                                    'required' => 'Kabupaten Kota Asal Harus Dipilih',
                                ])
                                ->afterStateUpdated(fn(Get $get, Set $set) => $set('ppg_kec_id', null))
                                ->dehydrated(true),
                            Select::make('ppg_kec_id')
                                ->preload()
                                ->searchable()
                                ->placeholder('Pilih Kecamatan Asal')
                                ->label('Kecamatan Asal')
                                ->validationMessages([
                                    'required' => 'Kecamatan Asal Harus Dipilih',
                                ])
                                ->options(
                                    fn(Get $get): Collection => Kec::query()
                                        ->where('kec_kkot_id', $get('kabkot'))
                                        ->pluck('kec_nama', 'id')
                                )
                                ->required(),
                            TextInput::make('ppg_kel')
                                ->label('Kelurahan/Desa Asal')
                                ->required()
                                ->validationMessages([
                                    'required' => 'Kelurahan/Desa Asal Harus Diisi',
                                ]),
                            TextInput::make('ppg_noho')
                                ->label('Nomor HP Aktif')
                                ->numeric()
                                ->required()
                                ->validationMessages([
                                    'required' => 'Nomor HP Harus Diisi',
                                    'numeric' => 'Nomor HP Harus Berupa Angka',
                                ]),
                            TextInput::make('ppg_nowa')
                                ->label('Nomor WhatsApp Aktif')
                                ->numeric()
                                ->required()
                                ->validationMessages([
                                    'required' => 'Nomor WhatsApp Harus Diisi',
                                    'numeric' => 'Nomor WhatsApp Harus Berupa Angka',
                                ]),
                            Select::make('ppg_wn')
                                ->label('Kewarganegaraan')
                                ->required()
                                ->options([
                                    'Warga Negara Indonesia' => 'WNI',
                                    'Warga Negara Asing' => 'WNA',
                                ])
                                ->placeholder('Pilih Kewarganegaraan'),
                        ])
                        ->columns(2),
                    Wizard\Step::make('Sekolah dan Perguruan Tinggi ')
                        ->schema([
                            TextInput::make('ppg_sklh')
                                ->label('Nama Sekolah Asal')
                                ->required()
                                ->validationMessages([
                                    'required' => 'Nomor Operator Sekolah Harus Diisi'
                                ]),
                            TextInput::make('ppg_noops')
                                ->label('Nomor Operator Sekolah')
                                ->numeric()
                                ->required()
                                ->validationMessages([
                                    'required' => 'Nomor Operator Sekolah Harus Diisi',
                                    'numeric' => 'Nomor Operator Sekolah Harus Berupa Angka',
                                ]),
                            Select::make('univ')
                                ->preload()
                                ->live()
                                ->searchable()
                                ->placeholder('Perguruan Tinggi Asal')
                                ->label('Perguruan Tinggi Asal')
                                ->options(Unv::orderBy('unv_nama')->pluck('unv_nama', 'id'))
                                ->required()
                                ->validationMessages([
                                    'required' => 'Perguruan Tinggi Asal Harus Dipilih',
                                ])
                                ->afterStateUpdated(fn(Get $get, Set $set) => $set('ppg_prpd_id', null))
                                ->dehydrated(true),
                            Select::make('ppg_prpd_id')
                                ->preload()
                                ->live()
                                ->searchable()
                                ->placeholder('Program Studi Asal')
                                ->label('Program Studi Asal')
                                ->options(fn(Get $get): Collection => Prdp::query()
                                    ->where('prdp_unv_id', $get('univ'))
                                    ->pluck('prdp_nama', 'id'))
                                ->required()
                                ->validationMessages([
                                    'required' => 'Program Studi Asal Harus Dipilih',
                                ]),
                            TextInput::make('ppg_ipk')
                                ->label('IPK Srata 1')
                                ->required()
                                ->validationMessages([
                                    'required' => 'IPK Srata 1 Harus Diisi',
                                ]),
                        ]),
                    Wizard\Step::make('Unggah Data Berkas')
                        ->schema([
                            FileUpload::make('ppg_uktp')
                                ->label('Upload Kartu Tanda Penduduk')
                                ->acceptedFileTypes(['application/pdf'])
                                ->required()
                                ->validationMessages([
                                    'required' => 'Kartu Tanda Penduduk Harus Diunggah',
                                    'mimes' => 'Format Berkas Harus PDF',
                                ])
                        ])
                        ->columns(2),
                ])
                    ->nextAction(
                        fn(Action $action) => $action->label('Selanjutnya'),
                    )
                    ->previousAction(
                        fn(Action $action) => $action->label('Sebelumnya'),
                    )
            ]);
    }

    protected function getFormActions(): array
    {
        return [];
    }

    public function getHeading(): string | Htmlable
    {
        return 'Silahkan Isi Data Dan Berkas Anda';
    }
}
