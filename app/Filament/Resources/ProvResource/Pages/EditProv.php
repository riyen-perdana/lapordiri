<?php

namespace App\Filament\Resources\ProvResource\Pages;

use Filament\Actions;
use Filament\Actions\Action;
use App\Filament\Resources\ProvResource;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditProv extends EditRecord
{
    protected static string $resource = ProvResource::class;
    protected static ?string $breadcrumb = 'Ubah Provinsi';
    protected static ?string $title = 'Ubah Provinsi';

    /**
     * TODO: Redirect To Index Page After Edit Data
     * @return string
     */
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    /**
     * TODO : Notification After Edit Data
     * @return ?Notification
     */
    protected function getSavedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Sukses')
            ->body('Data Provinsi Berhasil Diubah');
    }

    /**
     * TODO : Cancel Form Action Button
     * @return Action
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
     * TODO : Save Form Action Button
     * @return Action
     */
    protected function getSaveFormAction(): Action
    {
        return parent::getSaveFormAction()
            ->label('Ubah')
            ->color('success')
            ->icon('heroicon-o-pencil-square');
    }
}
