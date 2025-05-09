<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum Semester : string implements HasLabel
{
    case Ganjil = '1';
    case Genap = '2';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Ganjil => 'Ganjil',
            self::Genap => 'Genap',
        };
    }

    public function getColor(): ?string
    {
        return match ($this) {
            self::Ganjil => 'danger',
            self::Genap => 'success',
        };
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function isGanjil(): bool
    {
        return $this === self::Ganjil;
    }

    public function isGenap(): bool
    {
        return $this === self::Genap;
    }
}
