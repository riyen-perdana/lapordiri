<?php

namespace App\Livewire;

use Wizard\Step;
use App\Models\Agm;
use App\Models\Kec;
use App\Models\Unv;
use App\Models\Kkot;
use App\Models\Prdp;
use App\Models\Prov;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Livewire\Component;
use Filament\Forms\Form;
use Livewire\Attributes\Title;
use Filament\Forms\Components\Actions\Action;
use Illuminate\Support\Collection;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Actions;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Concerns\InteractsWithForms;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\HtmlString;

class Register extends Component implements HasForms, HasActions
{
    use InteractsWithForms;
    use InteractsWithActions;

    public ?array $data = [];

    public $hasTitle;

    public $ppg_nik;
    public $ppg_simpatika;
    public $ppg_nisn;
    public $ppg_nama;
    public $ppg_email;
    public $ppg_jnp_id;
    public $ppg_kps;
    public $ppg_jk;
    public $ppg_agm_id;
    public $ppg_tpt_lhr;
    public $ppg_tgl_lhr;
    public $ppg_ibu;
    public $prov;
    public $kabkot;
    public $ppg_kec_id;
    public $ppg_kel;
    public $ppg_no_hp;
    public $ppg_no_wa;
    public $ppg_wrgn_id;


    public function mount(): void
    {
        $this->form->fill();
        $this->hasTitle = false;
    }

    #[Layout('layouts.app')]
    #[Title('Registrasi Data - Aplikasi Lapor Diri Program Profesi Guru')]

    public function render()
    {
        return view('livewire.register');
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Wizard::make([
                    Wizard\Step::make('Data Pribadi')
                        ->schema([
                            TextInput::make('ppg_nik')
                                ->label('Nomor Induk Kependudukan')
                                ->placeholder('Contoh: 3602041211870001')
                                ->autofocus()
                                ->unique()
                                ->required()
                                ->rules(['digits:16'])
                                ->numeric()
                                ->validationMessages([
                                    'unique' => 'Nomor Induk Kependudukan Sudah Terdaftar, Isikan Yang Lain',
                                    'required' => 'Nomor Induk Kependudukan Harus Diisi',
                                    'numeric' => 'Nomor Induk Kependudukan Harus Angka',
                                ]),
                            TextInput::make('ppg_simpatika')
                                ->label('Nomor Akun Siaga/SIMPATIKA')
                                ->placeholder('Nomor Akun Siaga/Simpatika')
                                ->unique()
                                ->required()
                                ->validationMessages([
                                    'required' => 'Nomor Akun Siaga/SIMPATIKA Harus Diisi',
                                    'unique' => 'Nomor Akun Siaga/SIMPATIKA Sudah Terdaftar, Isikan Yang Lain',
                                ]),
                            TextInput::make('ppg_nisn')
                                ->label('Nomor Induk Siswa Nasional')
                                ->placeholder('Contoh: 0009321234')
                                ->unique()
                                ->required()
                                ->numeric()
                                ->rules(['digits:10'])
                                ->validationMessages([
                                    'required' => 'Nomor Induk Siswa Nasional Harus Diisi',
                                    'unique' => 'Nomor Induk Siswa Nasional Sudah Terdaftar, Isikan Yang Lain',
                                    'numeric' => 'Nomor Induk Siswa Nasional Harus Angka',
                                    'length' => 'Nomor Induk Siswa Nasional Harus 10 Karakter',
                                ]),
                            TextInput::make('ppg_nama')
                                ->label('Nama Lengkap Sesuai Ijazah Terakhir Tanpa Gelar')
                                ->placeholder('Contoh: Riyen Perdana')
                                ->required()
                                ->validationMessages([
                                    'required' => 'Nama Lengkap Sesuai Ijazah Terakhir Harus Diisi',
                                ]),
                            TextInput::make('ppg_email')
                                ->placeholder('Contoh: riyenperdana@example.com')
                                ->label('Email Aktif')
                                ->required()
                                ->email()
                                ->validationMessages([
                                    'required' => 'Nama Lengkap Sesuai Ijazah Terakhir Harus Diisi',
                                    'email' => 'Format Email Harus Valid',
                                ]),
                            Select::make('ppg_kps')
                                ->placeholder('Pilih Penerima KPS')
                                ->label('Apakah Anda Penerima Kartu Perlindungan Sosial ?')
                                ->required()
                                ->options([
                                    'Y' => 'Ya',
                                    'N' => 'Tidak',
                                ])
                                ->validationMessages([
                                    'required' => 'Penerima KPS Harus Dipilih',
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
                            Select::make('ppg_agama_id')
                                ->placeholder('Pilih Agama')
                                ->label('Agama')
                                ->options(Agm::orderBy('id')->pluck('agm_nama', 'id'))
                                ->required()
                                ->validationMessages([
                                    'required' => 'Agama Harus Dipilih',
                                ]),
                            TextInput::make('ppg_tpt_lhr')
                                ->label('Tempat Lahir')
                                ->placeholder('Contoh: Jakarta')
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
                            TextInput::make('ppg_ibu')
                                ->label('Nama Asli Ibu Kandung')
                                ->placeholder('Contoh: Khadijah')
                                ->required()
                                ->validationMessages([
                                    'required' => 'Nama Asli Ibu Kandung Harus Diisi',
                                ]),
                            Select::make('prov')
                                ->live()
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
                                // ->preload()
                                ->live()
                                // ->searchable()
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
                                // ->preload()
                                // ->searchable()
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
                                ->placeholder('Contoh: Bina Widya')
                                ->required()
                                ->validationMessages([
                                    'required' => 'Kelurahan/Desa Asal Harus Diisi',
                                ]),
                            TextInput::make('ppg_nohp')
                                ->label('Nomor HP Aktif')
                                ->placeholder('Contoh: 08123456789')
                                ->numeric()
                                ->required()
                                ->validationMessages([
                                    'required' => 'Nomor HP Harus Diisi',
                                    'numeric' => 'Nomor HP Harus Berupa Angka',
                                ]),
                            TextInput::make('ppg_nowa')
                                ->label('Nomor WhatsApp Aktif')
                                ->placeholder('Contoh: 08123456789')
                                ->numeric()
                                ->required()
                                ->validationMessages([
                                    'required' => 'Nomor WhatsApp Harus Diisi',
                                    'numeric' => 'Nomor WhatsApp Harus Berupa Angka',
                                ]),
                            Select::make('ppg_wrgn_id')
                                ->label('Kewarganegaraan')
                                ->required()
                                ->options([
                                    'ID' => 'Indonesia',
                                    'BN' => 'Brunei Darusallam',
                                    'KH' => 'Kamboja',
                                    'LA' => 'Laos',
                                    'MM' => 'Myanmar',
                                    'PH' => 'Filipina',
                                    'TH' => 'Thailand',
                                    'VN' => 'Vietnam',
                                    'MY' => 'Malaysia',
                                    'SG' => 'Singapore',
                                ])
                                ->placeholder('Pilih Kewarganegaraan')
                                ->validationMessages([
                                    'required' => 'Kewarganegaraan Harus Dipilih',
                                ]),
                        ])
                        ->columns(2),
                    Wizard\Step::make('Sekolah dan Perguruan Tinggi ')
                        ->schema([
                            TextInput::make('ppg_sklh')
                                ->label('Nama Sekolah Tempat Mengajar')
                                ->required()
                                ->validationMessages([
                                    'required' => 'Nomor Operator Sekolah Harus Diisi'
                                ]),
                            TextInput::make('ppg_no_ops')
                                ->label('Nomor Operator Sekolah')
                                ->numeric()
                                ->required()
                                ->validationMessages([
                                    'required' => 'Nomor Operator Sekolah Harus Diisi',
                                    'numeric' => 'Nomor Operator Sekolah Harus Berupa Angka',
                                ]),
                            Select::make('univ')
                                // ->preload()
                                ->live()
                                // ->searchable()
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
                                // ->preload()
                                ->live()
                                // ->searchable()
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
                                ->label('IPK Srata 1 [Gunakan Tanda Titik (.) Untuk Desimal]')
                                ->required()
                                ->regex('/^[0-3](\.[0-9]{1,2})?$|^4(\.[0]{1,2})?$/')
                                ->validationMessages([
                                    'required' => 'IPK Srata 1 Harus Diisi',
                                    'regex' => 'IPK Srata 1 Tidak Sesuai Format',
                                ]),
                        ])
                        ->columns(2),
                    Wizard\Step::make('Unggah Data Berkas')
                        ->schema([
                            FileUpload::make('ppg_uktp')
                                ->label('Unggah Kartu Tanda Penduduk [Format PDF]')
                                ->acceptedFileTypes(['application/pdf'])
                                ->required()
                                ->directory('ktp')
                                ->validationMessages([
                                    'required' => 'Kartu Tanda Penduduk Harus Diunggah',
                                ]),
                            FileUpload::make('ppg_foto')
                                ->label('Unggah Foto [Format JPG, PNG, JPEG]')
                                ->image()
                                ->required()
                                ->directory('foto')
                                ->validationMessages([
                                    'required' => 'Foto Peserta Harus Diunggah',
                                ]),
                            FileUpload::make('ppg_ijz')
                                ->label('Unggah Ijazah Strata 1 [Format PDF]')
                                ->acceptedFileTypes(['application/pdf'])
                                ->required()
                                ->directory('ijazah')
                                ->validationMessages([
                                    'required' => 'Ijazah Strata 1 Harus Diunggah',
                                ]),
                            FileUpload::make('ppg_trsk')
                                ->label('Unggah Tramskrip Nilai Strata 1 [Format PDF]')
                                ->acceptedFileTypes(['application/pdf'])
                                ->required()
                                ->directory('transkrip')
                                ->validationMessages([
                                    'required' => 'Transkrip Nilai Strata 1 Harus Diunggah',
                                ]),
                            FileUpload::make('ppg_sk_ajr')
                                ->label('Unggah SK Mengajar Sebagai Guru Maksimal 6 Tahun Terakhir [Format PDF]')
                                ->acceptedFileTypes(['application/pdf'])
                                ->required()
                                ->directory('rpl')
                                ->validationMessages([
                                    'required' => 'SK Mengajar sebagai Guru Harus Diunggah',
                                ]),
                            FileUpload::make('ppg_prkt_ajr')
                                ->label('Unggah Perangkat Pembelajaran maksimal 12 semester [Format PDF]')
                                ->acceptedFileTypes(['application/pdf'])
                                ->required()
                                ->directory('rpl')
                                ->validationMessages([
                                    'required' => 'Perangkat Pembelajaran Harus Diunggah',
                                ]),
                            FileUpload::make('ppg_strf')
                                ->label('Unggah Sertifikat Kegiatan Pengembangan Kompetensi Dalam 6 Tahun Terakhir [Format PDF]')
                                ->acceptedFileTypes(['application/pdf'])
                                ->required()
                                ->directory('rpl')
                                ->validationMessages([
                                    'required' => 'Sertifikat Pengembangan Kompetensi Harus Diunggah',
                                ]),
                            FileUpload::make('ppg_dkmn')
                                ->label('Upload Dokumen Keterlibatan Pengelolaan Aministrasi Pembelajaran 6 Tahun terakhir [Format PDF]')
                                ->acceptedFileTypes(['application/pdf'])
                                ->required()
                                ->directory('rpl')
                                ->validationMessages([
                                    'required' => 'Dokumen Keterlibatan Pengelolaan Aministrasi Harus Diunggah',
                                ]),
                            FileUpload::make('ppg_dkmn')
                                ->label('Unggah Dokumen Keterlibatan Pengelolaan Aministrasi Pembelajaran 6 Tahun terakhir [Format PDF]')
                                ->acceptedFileTypes(['application/pdf'])
                                ->required()
                                ->directory('rpl')
                                ->validationMessages([
                                    'required' => 'Dokumen Keterlibatan Pengelolaan Aministrasi Harus Diunggah',
                                ]),
                            FileUpload::make('ppg_invs')
                                ->label('Unggah Dokumen Inovasi Pembelajaran atau Karya Lain 6 Tahun Terakhir [Format PDF]')
                                ->acceptedFileTypes(['application/pdf'])
                                ->required()
                                ->directory('rpl')
                                ->validationMessages([
                                    'required' => 'Dokumen Inovasi Pembelajaran atau Karya Lain Harus Diunggah',
                                ]),
                            
                        ])
                        ->columns(2),
                ])
                    ->nextAction(
                        fn(Action $action) => $action->label('Selanjutnya')
                    )
                    ->previousAction(
                        fn(Action $action) => $action->label('Sebelumnya'),
                    )
                    ->submitAction(new HtmlString(Blade::render(<<<BLADE
                        <x-filament::button
                            type="submit"
                            size="sm"
                            wire:click="save"
                        >
                            Simpan
                        </x-filament::button>
                    BLADE)))
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        dd($this->form->getState());
    }
}
