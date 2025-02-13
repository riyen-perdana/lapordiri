<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Title;


class Beranda extends Component
{
    public $hasTitle;
    #[Layout('layouts.app')]
    #[Title('Beranda - Aplikasi Lapor Diri Program Profesi Guru')]

    public function render()
    {
        return view('livewire.beranda');
    }

    public function mount()
    {
        $this->hasTitle = true;
    }
}
