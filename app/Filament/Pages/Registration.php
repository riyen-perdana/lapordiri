<?php

namespace App\Filament\Pages;

use Filament\Forms\Form;
use Filament\Pages\Auth\Register;
use Illuminate\Support\HtmlString;
use Filament\Forms\Components\Wizard;
use Illuminate\Support\Facades\Blade;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\TextInput;
use Illuminate\Contracts\Support\Htmlable;

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
                            TextInput::make('ppg_nuptk')
                                ->label('NUPTK')
                                ->required()
                                ->validationMessages([
                                    'required' => 'NUPTK Harus Diisi',
                                ])
                        ])
                        ->columns(2),
                    Wizard\Step::make('step2')
                        ->schema([
                            TextInput::make('agm_nama')
                        ]),
                    Wizard\Step::make('step3')
                        ->schema([
                            TextInput::make('agm_nama')
                        ]),
                ])
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
