<?php

namespace App\Filament\Resources\UnvResource\Pages;

use Filament\Actions;
use Filament\Actions\Action;
use App\Filament\Resources\UnvResource;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditUnv extends EditRecord
{
    protected static string $resource = UnvResource::class;
    protected static ?string $breadcrumb = 'Ubah Universitas';
    protected static ?string $title = 'Ubah Universitas';

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
            ->body('Data Universitas Berhasil Diubah');
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
