<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Prdp;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Notifications\Notification;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\PrdpResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PrdpResource\RelationManagers;

class PrdpResource extends Resource
{
    protected static ?string $model = Prdp::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office';
    protected static ?string $navigationGroup = 'Data Pendidikan';
    protected static ?string $navigationLabel = 'Program Studi';
    protected static ?string $pluralModelLabel = 'Program Studi';
    protected static ?int $navigationSort = 9;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('prdp_unv_id')
                    ->label('Nama Universitas')
                    ->placeholder('Pilih Universitas')
                    ->preload()
                    ->searchable()
                    ->relationship('unv', 'unv_nama')
                    ->required()
                    ->validationMessages([
                        'required' => 'Kolom Universitas Wajib Diisi',
                    ])
                    ->autofocus(),
                Forms\Components\TextInput::make('id')
                    ->label('UUID Program Studi')
                    ->required()
                    ->maxLength(255)
                    ->validationMessages([
                        'required' => 'Kolom Kode Program Studi Tidak Boleh Kosong',
                        'maxLength' => 'Kolom Kode Program Studi Maksimal 255 Karakter',
                    ]),
                Forms\Components\TextInput::make('prdp_kode')
                    ->label('Kode Program Studi')
                    ->required()
                    ->maxLength(255)
                    ->validationMessages([
                        'required' => 'Kolom Kode Program Studi Tidak Boleh Kosong',
                        'maxLength' => 'Kolom Kode Program Studi Maksimal 255 Karakter',
                    ]),
                Forms\Components\TextInput::make('prdp_nama')
                    ->label('Nama Program Studi')
                    ->required()
                    ->maxLength(255)
                    ->validationMessages([
                        'required' => 'Kolom Nama Program Studi Tidak Boleh Kosong',
                        'maxLength' => 'Kolom Nama Program Studi Maksimal 255 Karakter',
                    ]),
            ]);
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
                    ->label('ID Program Studi')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('prdp_kode')
                    ->label('Kode Program Studi')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('prdp_nama')
                    ->label('Nama Program Studi')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('unv.unv_nama')
                    ->label('Nama Universitas')
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                SelectFilter::make('prdp_unv_id')
                    ->relationship('unv', 'unv_nama')
                    ->label('Universitas')
                    ->placeholder('Pilih Universitas')
                    ->preload()
                    ->searchable(),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label('Ubah'),
                    Tables\Actions\DeleteAction::make()
                    ->label('Hapus')
                    ->requiresConfirmation()
                    ->successNotification(
                        Notification::make()
                            ->success()
                            ->title('Sukses')
                            ->body('Data Program Studi Berhasil Dihapus')
                    )
                    ->modalHeading(fn(Prdp $record) => 'Hapus Data ' . $record->prdp_nama . '')
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
            'index' => Pages\ListPrdps::route('/'),
            'create' => Pages\CreatePrdp::route('/create'),
            'edit' => Pages\EditPrdp::route('/{record}/edit'),
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
}
