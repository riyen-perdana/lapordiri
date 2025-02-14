<?php

namespace App\Livewire;

use DB;
use Wizard\Step;
use App\Models\Agm;
use App\Models\Bch;
use App\Models\Jlp;
use App\Models\Jnp;
use App\Models\Kec;
use App\Models\Ppg;
use App\Models\Unv;
use App\Models\Kkot;
use App\Models\Prdp;
use App\Models\Prov;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Livewire\Component;
use Filament\Forms\Form;
use App\Models\Set as Smt;
use Livewire\Attributes\Title;
use Illuminate\Support\Collection;
use Illuminate\Support\HtmlString;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Wizard;
use Illuminate\Support\Facades\Blade;
use Filament\Forms\Components\Actions;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Actions\Concerns\InteractsWithActions;

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
    public $ppg_sklh;
    public $ppg_no_ops;
    public $univ;
    public $ppg_prdp_id;
    public $ppg_ipk;
    public $ppg_uktp;
    public $ppg_foto;
    public $ppg_ijz;
    public $ppg_trsk;
    public $ppg_sk_ajr;
    public $ppg_prkt_ajr;
    public $ppg_strf;
    public $ppg_dkmn;
    public $ppg_invs;
    public $ppg_jlp_id;
    public $ppg_jnp_id;
    public $ppg_set_id;

    public $semester;
    public $batch;
    public $jalur;
    public $jenis;



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
                                ->required()
                                ->rules(['digits:16', 'unique:ppg,ppg_nik'])
                                ->numeric()
                                ->validationMessages([
                                    'unique' => 'Nomor Induk Kependudukan Sudah Terdaftar, Isikan Yang Lain',
                                    'required' => 'Nomor Induk Kependudukan Harus Diisi',
                                    'numeric' => 'Nomor Induk Kependudukan Harus Angka',
                                ]),
                            TextInput::make('ppg_simpatika')
                                ->label('Nomor Akun Siaga/SIMPATIKA')
                                ->placeholder('Nomor Akun Siaga/Simpatika')
                                ->rules(['unique:ppg,ppg_simpatika'])
                                ->required()
                                ->validationMessages([
                                    'required' => 'Nomor Akun Siaga/SIMPATIKA Harus Diisi',
                                    'unique' => 'Nomor Akun Siaga/SIMPATIKA Sudah Terdaftar, Isikan Yang Lain',
                                ]),
                            TextInput::make('ppg_nisn')
                                ->label('Nomor Induk Siswa Nasional')
                                ->placeholder('Contoh: 0009321234')
                                ->required()
                                ->numeric()
                                ->rules(['digits:10', 'unique:ppg,ppg_nisn'])
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
                                ->rules(['email', 'unique:ppg,ppg_email'])
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
                            Select::make('ppg_agm_id')
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
                            TextInput::make('ppg_no_hp')
                                ->label('Nomor HP Aktif')
                                ->placeholder('Contoh: 08123456789')
                                ->numeric()
                                ->regex('/^0(8[1-9][0-9]{5,8})$/')
                                ->required()
                                ->validationMessages([
                                    'required' => 'Nomor HP Harus Diisi',
                                    'numeric' => 'Nomor HP Harus Berupa Angka',
                                    'regex' => 'Format Nomor HP Harus Valid',
                                ]),
                            TextInput::make('ppg_no_wa')
                                ->label('Nomor WhatsApp Aktif')
                                ->placeholder('Contoh: 08123456789')
                                ->numeric()
                                ->regex('/^0(8[1-9][0-9]{5,8})$/')
                                ->required()
                                ->validationMessages([
                                    'required' => 'Nomor WhatsApp Harus Diisi',
                                    'numeric' => 'Nomor WhatsApp Harus Berupa Angka',
                                    'regex' => 'Format Nomor WhatsApp Harus Valid',
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
                        ->columns(2)
                        ->completedIcon('heroicon-m-hand-thumb-up'),
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
                                ->regex('/^0(8[1-9][0-9]{5,8})$/')
                                ->numeric()
                                ->required()
                                ->validationMessages([
                                    'required' => 'Nomor Operator Sekolah Harus Diisi',
                                    'numeric' => 'Nomor Operator Sekolah Harus Berupa Angka',
                                    'regex' => 'Nomor Operator Sekolah Tidak Sesuai Format',
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
                            Select::make('ppg_prdp_id')
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
                        ->columns(2)
                        ->completedIcon('heroicon-m-hand-thumb-up'),
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
                        ->columns(2)
                        ->completedIcon('heroicon-m-hand-thumb-up'),
                ])
                    ->startOnStep(1)
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
        // dd($this->form->getState());
        $data = $this->form->getState();

        try {
            DB::beginTransaction();

            $semester = Smt::where('set_sts','=',1)->first();
            $batch = Bch::where('bch_sts','=',1)->first();
            $jalur = Jlp::where('jlp_status','=',1)->first();
            $jenis = Jnp::where('jnp_status','=',1)->first();


            Ppg::create([
                'ppg_nik' => $data['ppg_nik'],
                'ppg_simpatika' => $data['ppg_simpatika'],
                'ppg_nisn' => $data['ppg_nisn'],
                'ppg_nama' => $data['ppg_nama'],
                'ppg_email' => $data['ppg_email'],
                'ppg_kps' => $data['ppg_kps'],
                'ppg_jk' => $data['ppg_jk'],
                'ppg_agm_id' => $data['ppg_agm_id'],
                'ppg_tpt_lhr' => $data['ppg_tpt_lhr'],
                'ppg_tgl_lhr' => $data['ppg_tgl_lhr'],
                'ppg_ibu' => $data['ppg_ibu'],
                'ppg_kec_id' => $data['ppg_kec_id'],
                'ppg_kel' => $data['ppg_kel'],
                'ppg_no_hp' => $data['ppg_no_hp'],
                'ppg_no_wa' => $data['ppg_no_wa'],
                'ppg_wrgn_id' => $data['ppg_wrgn_id'],
                'ppg_sklh' => $data['ppg_sklh'],
                'ppg_no_ops' => $data['ppg_no_ops'],
                'ppg_prdp_id' => $data['ppg_prdp_id'],
                'ppg_ipk' => $data['ppg_ipk'],
                'ppg_uktp' => $data['ppg_uktp'],
                'ppg_foto' => $data['ppg_foto'],
                'ppg_ijz' => $data['ppg_ijz'],
                'ppg_trsk' => $data['ppg_trsk'],
                'ppg_sk_ajr' => $data['ppg_sk_ajr'],
                'ppg_prkt_ajr' => $data['ppg_prkt_ajr'],
                'ppg_strf' => $data['ppg_strf'],
                'ppg_dkmn' => $data['ppg_dkmn'],
                'ppg_invs' => $data['ppg_invs'],
                'ppg_jlp_id' => $jalur->id,
                'ppg_jnp_id' => $jenis->id,
                'ppg_set_id' => $semester->id,
                'ppg_batch_id' => $batch->id,
            ]);

            DB::commit();

            $this->form->fill();
            session()->flash('message', 'Data Peserta Program Profesi Guru Berhasil Disimpan, Silahkan Tunggu Konfirmasi Dari Panitia Melalui Website Aplikasi Lapor Diri Program Profesi Guru, Terima Kasih');
            
            redirect()->route('pendaftaran.index');

        } catch (\Throwable $th) {
            //throw $th;
            session()->flash('message', 'Error : '.$th->getMessage());
            DB::rollback();
        }


    }
}
