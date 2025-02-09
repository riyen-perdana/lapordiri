<?php

namespace App\Filament\Resources\SetResource\Pages;

use Filament\Actions;
use Filament\Actions\Action;
use App\Filament\Resources\SetResource;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditSet extends EditRecord
{
    protected static string $resource = SetResource::class;

    protected static ?string $breadcrumb = 'Ubah Semester';
    protected static ?string $title = 'Ubah Semester';

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
            ->body('Data Semester Berhasil Diubah');
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
