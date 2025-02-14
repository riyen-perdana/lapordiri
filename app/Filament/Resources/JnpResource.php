<?php

namespace App\Filament\Resources;

use App\Models\Jnp;
use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\JnpResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\JnpResource\RelationManagers;
use Filament\Support\RawJs;

class JnpResource extends Resource
{
    protected static ?string $model = Jnp::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';
    protected static ?string $navigationGroup = 'Data Master';
    protected static ?string $navigationLabel = 'Jenis Penerimaan';
    protected static ?string $pluralModelLabel = 'Jenis Penerimaan';
    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('jnp_nama')
                    ->required()
                    ->maxLength(255)
                    ->validationMessages([
                        'required' => 'Kolom Jenis Penerimaan Harus Diisi',
                        'maxLength' => 'Kolom Jenis Penerimaan Maksimal 255 Karakter',
                    ])
                    ->label('Jenis Penerimaan'),
                Forms\Components\TextInput::make('jnp_mb')
                    ->required()
                    ->mask(RawJs::make('$money($input)'))
                    ->stripCharacters(',')
                    ->numeric()
                    ->validationMessages([
                        'required' => 'Kolom Biaya Masuk Harus Diisi',
                        'numeric' => 'Kolom Biaya Masuk Harus Angka',
                    ])
                    ->label('Biaya Masuk')
                    ->prefix('Rp. ')
                    ->default(0),
                Forms\Components\Toggle::make('jnp_status')
                    ->label('Status Jenis Penerimaan')
                    ->default(false)
                    ->inline(false)
                    ->onColor('success')
                    ->onIcon('heroicon-m-check-circle')
                    ->offIcon('heroicon-m-x-circle'),
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
                Tables\Columns\TextColumn::make('jnp_nama')
                    ->label('Jenis Penerimaan')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('jnp_mb')
                    ->label('Biaya Masuk')
                    ->sortable()
                    ->searchable()
                    ->formatStateUsing(fn (string $state): string => 'Rp. ' . number_format($state, 0, ',', '.')),
                Tables\Columns\ToggleColumn::make('jnp_status')
                    ->label('Status')
                    ->sortable()
                    ->onIcon('heroicon-m-check-circle')
                    ->offIcon('heroicon-m-x-circle')
                    ->onColor('success'),
            ])
            ->filters([
                //
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
                                ->body('Data Jenis Pendaftaran Berhasil Dihapus')
                        )
                        ->modalHeading(fn(Jnp $record) => 'Hapus Data ' . $record->jnp_nama . '')
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
            'index' => Pages\ListJnps::route('/'),
            'create' => Pages\CreateJnp::route('/create'),
            'edit' => Pages\EditJnp::route('/{record}/edit'),
        ];
    }
}
