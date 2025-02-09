<?php

namespace App\Filament\Resources\ProvResource\Pages;

use Filament\Actions;
use Filament\Actions\Action;
use App\Filament\Resources\ProvResource;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateProv extends CreateRecord
{
    protected static string $resource = ProvResource::class;
    protected static ?string $breadcrumb = 'Tambah Provinsi';
    protected static ?string $title = 'Tambah provinsi';
    protected static bool $canCreateAnother = true;

    /**
     * TODO: Redirect To Index Page After Add Data
     * @return string
     */
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    /**
     * TODO : Create Form Action Button
     */
    protected function getCreateFormAction(): Action
    {
        return Actions\CreateAction::make()
            ->label('Tambah')
            ->color('success')
            ->icon('heroicon-o-plus')
            ->submit('create');
    }

    /**
     * TODO : Cancel Form Action Button
     */
    protected function getCancelFormAction(): Action
    {
        return Actions\Action::make('cancel')
            ->label('Batal')
            ->color('danger')
            ->icon('heroicon-o-x-mark')
            ->extraAttributes(['onclick' => 'window.history.back()']);
    }

    /**
     * TODO : Notification After Add Data
     */
    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Sukses')
            ->body('Data Provinsi Berhasil Ditambahkan');
    }

    protected function getCreateAnotherFormAction() : Action
    {
        return Actions\CreateAction::make()
            ->label('Simpan dan Tambah Lagi')
            ->color('warning')
            ->extraAttributes(['wire:click' => 'createAnother']);
    }

}
