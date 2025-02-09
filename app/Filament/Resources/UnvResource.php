<?php

namespace App\Filament\Resources;

use App\Models\Unv;
use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use Filament\Notifications\Notification;
use App\Filament\Resources\UnvResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\UnvResource\RelationManagers;
use Filament\Forms\Components\Tabs\Tab;

class UnvResource extends Resource
{
    protected static ?string $model = Unv::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Data Pendidikan';
    protected static ?string $navigationLabel = 'Universitas';
    protected static ?string $pluralModelLabel = 'Universitas';
    protected static ?int $navigationSort = 8;

    public static function form(Form $form): Form
    {
        return $form
            ->schema(self::getCustomUniversitasForm());
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
                Tables\Columns\TextColumn::make('id')
                    ->label('ID Universitas')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('unv_nama')
                    ->label('Nama Universitas')
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->label('Hapus')
                    ->requiresConfirmation()
                    ->successNotification(
                        Notification::make()
                            ->success()
                            ->title('Sukses')
                            ->body('Data Universitas Berhasil Dihapus')
                    )
                    ->modalHeading(fn(Unv $record) => 'Hapus Data ' . $record->unv_nama . '')
                    ->modalDescription('Apakah Anda Yakin Menghapus Data Ini?')
                    ->modalCancelActionLabel('Tidak')
                    ->modalSubmitActionLabel('Ya, Hapus Data'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListUnvs::route('/'),
            'create' => Pages\CreateUnv::route('/create'),
            'edit' => Pages\EditUnv::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getNavigationBadgeColor(): string|array|null
    {
        return 'success';
    }

    public static function getCustomUniversitasForm()
    {
        return [
            Forms\Components\TextInput::make('id')
                ->label('ID Universitas')
                ->required()
                ->maxLength(255)
                ->validationMessages([
                    'required' => 'Kolom ID Universitas Tidak Boleh Kosong',
                    'maxLength' => 'Kolom ID Universitas Maksimal 255 Karakter',
                ])
                ->autofocus(),
            Forms\Components\TextInput::make('unv_kode')
                ->label('Kode Universitas')
                ->required()
                ->maxLength(255)
                ->validationMessages([
                    'required' => 'Kolom Kode Universitas Tidak Boleh Kosong',
                    'maxLength' => 'Kolom Kode Universitas Maksimal 255 Karakter',
                ]),
            Forms\Components\TextInput::make('unv_nama')
                ->label('Nama Universitas')
                ->required()
                ->maxLength(255)
                ->validationMessages([
                    'required' => 'Kolom Nama Universitas Tidak Boleh Kosong',
                    'maxLength' => 'Kolom Nama Universitas Maksimal 255 Karakter',
                ]),
        ];
    }
}
