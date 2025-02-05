<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Prov;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\ProvResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ProvResource\RelationManagers;

class ProvResource extends Resource
{
    protected static ?string $model = Prov::class;
    protected static ?string $navigationIcon = 'heroicon-o-map';
    protected static ?string $navigationGroup = 'Area';
    protected static ?string $navigationLabel = 'Provinsi';
    protected static ?string $pluralModelLabel = 'Provinsi';


    public static function form(Form $form): Form
    {
        return $form
            ->schema(self::getCustomProvinsiForm());
    }

    public static function table(Table $table): Table
    {
        return $table
            ->emptyStateIcon('heroicon-o-bookmark')
            ->emptyStateHeading('Data Tidak Ditemukan')
            ->emptyStateDescription('Kami Sudah Mencari Keseluruh Sumber Data, Namun Data Tidak Ditemukan')
            ->columns([
                Tables\Columns\TextColumn::make('index')
                    ->rowIndex()
                    ->label('No.')
                    ->width('3%'),
                Tables\Columns\TextColumn::make('prov_kode')
                    ->label('Kode Provinsi')
                    ->sortable()
                    ->searchable()
                    ->width('15%'),
                Tables\Columns\TextColumn::make('prov_nama')
                    ->label('Nama Provinsi')
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label('Ubah'),
                Tables\Actions\DeleteAction::make()
                ->label('Hapus')
                    ->requiresConfirmation()
                    ->successNotification(
                        Notification::make()
                            ->success()
                            ->title('Sukses')
                            ->body('Data Provinsi Berhasil Dihapus')
                    )
                    ->modalHeading(fn(Prov $record) => 'Hapus Data ' . $record->prov_nama . '')
                    ->modalDescription('Apakah Anda Yakin Menghapus Data Ini?')
                    ->modalCancelActionLabel('Tidak')
                    ->modalSubmitActionLabel('Ya, Hapus Data'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->modalHeading('Hapus Data Provinsi Yang Ditandai')
                        ->modalDescription('Apakah Anda Yakin Menghapus Data Ini?')
                        ->modalCancelActionLabel('Tidak')
                        ->modalSubmitActionLabel('Ya, Hapus Data'),
                ]),
            ])
            ->defaultSort('prov_kode','asc');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProvs::route('/'),
            'create' => Pages\CreateProv::route('/create'),
            'edit' => Pages\EditProv::route('/{record}/edit'),
        ];
    }

    /**
     * TODO : Custom Form Provinsi So It's Can Use Anywhere
     */
    public static function getCustomProvinsiForm()
    {
        return [
            Forms\Components\TextInput::make('prov_kode')
                ->autofocus()
                ->label('Kode Provinsi')
                ->unique(ignoreRecord: true)
                ->required()
                ->validationMessages([
                    'required' => 'Kode Provinsi Harus Diisi',
                    'unique' => 'Kode Provinsi Sudah Terdaftar, Isikan Yang Lain',
                ]),
            Forms\Components\TextInput::make('prov_nama')
                ->label('Nama Provinsi')
                ->required()
                ->validationMessages([
                    'required' => 'Nama Provinsi Harus Diisi',
                ]),
        ];
    }
}
