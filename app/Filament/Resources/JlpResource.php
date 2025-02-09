<?php

namespace App\Filament\Resources;

use App\Models\Jlp;
use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\JlpResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\JlpResource\RelationManagers;

class JlpResource extends Resource
{
    protected static ?string $model = Jlp::class;

    protected static ?string $navigationIcon = 'heroicon-o-list-bullet';
    protected static ?string $navigationGroup = 'Data Master';
    protected static ?string $navigationLabel = 'Jalur Penerimaan';
    protected static ?string $pluralModelLabel = 'Jalur Penerimaan';
    protected static ?int $navigationSort = 6;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('jlp_nama')
                    ->label('Jalur Penerimaan')
                    ->required()
                    ->maxLength(255)
                    ->validationMessages([
                        'required' => 'Kolom Jalur Penerimaan Tidak Boleh Kosong',
                        'maxLength' => 'Kolom Jalur Penerimaan Maksimal 255 Karakter',
                    ]),
                Forms\Components\Toggle::make('jlp_status')
                    ->label('Status Jalur Penerimaan')
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
                Tables\Columns\TextColumn::make('jlp_nama')
                    ->label('Jalur Penerimaan')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\ToggleColumn::make('jlp_status')
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
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->label('Hapus')
                    ->requiresConfirmation()
                    ->successNotification(
                        Notification::make()
                            ->success()
                            ->title('Sukses')
                            ->body('Data Jalur Penerimaan Berhasil Dihapus')
                    )
                    ->modalHeading(fn(Jlp $record) => 'Hapus Data ' . $record->jlp_nama . '')
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
            'index' => Pages\ListJlps::route('/'),
            'create' => Pages\CreateJlp::route('/create'),
            'edit' => Pages\EditJlp::route('/{record}/edit'),
        ];
    }
}
