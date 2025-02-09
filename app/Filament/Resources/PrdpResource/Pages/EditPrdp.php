<?php

namespace App\Filament\Resources\PrdpResource\Pages;

use Filament\Actions;
use Filament\Actions\Action;
use App\Filament\Resources\PrdpResource;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditPrdp extends EditRecord
{
    protected static string $resource = PrdpResource::class;
    protected static ?string $breadcrumb = 'Ubah Program Studi';
    protected static ?string $title = 'Ubah Program Studi';

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
            ->body('Data Program Studi Berhasil Diubah');
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
