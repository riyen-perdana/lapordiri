<?php

namespace App\Filament\Resources;

use App\Models\Bch;
use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\BchResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\BchResource\RelationManagers;

class BchResource extends Resource
{
    protected static ?string $model = Bch::class;
    protected static ?string $navigationIcon = 'heroicon-o-adjustments-horizontal';
    protected static ?string $navigationGroup = 'Setting';
    protected static ?string $navigationLabel = 'Kelompok';
    protected static ?string $pluralModelLabel = 'Kelompok';
    protected static ?int $navigationSort = 11;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('bch_sesi')
                    ->label('Kelompok')
                    ->required()
                    ->autofocus()
                    ->numeric()
                    ->validationMessages([
                        'required' => 'Kolom Kelompok Harus Diisi',
                        'numeric' => 'Kolom Kelompok Harus Berupa Angka',
                    ]),
                Forms\Components\DatePicker::make('bch_tgl_awl')
                    ->label('Tanggal Awal Sesi')
                    ->required()
                    ->validationMessages([
                        'required' => 'Kolom Tanggal Awal Harus Diisi',
                    ]),
                Forms\Components\DatePicker::make('bch_tgl_akhir')
                    ->label('Tanggal Akhir Sesi')
                    ->required()
                    ->validationMessages([
                        'required' => 'Kolom Tanggal Akhir Harus Diisi',
                    ]),
                Forms\Components\Toggle::make('bch_sts')
                    ->label('Status Kelompok')
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
                Tables\Columns\TextColumn::make('bch_sesi')
                    ->label('Kelompok/Batch')
                    ->sortable()
                    ->searchable()
                    ->width('20%')
                    ->formatStateUsing(fn (string $state): string => "Batch $state"),
                Tables\Columns\TextColumn::make('bch_tgl_awl')
                    ->label('Awal Sesi')
                    ->dateTime('d-m-Y')
                    ->sortable()
                    ->searchable()
                    ->width('20%'),
                Tables\Columns\TextColumn::make('bch_tgl_akhir')
                    ->label('Akhir Sesi')
                    ->dateTime('d-m-Y')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\ToggleColumn::make('bch_sts')
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
                            ->body('Data Semester Berhasil Dihapus')
                    )
                    ->modalHeading(fn(Bch $record) => 'Hapus Data Batch ' . $record->bch_sesi . '')
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
            'index' => Pages\ListBches::route('/'),
            'create' => Pages\CreateBch::route('/create'),
            'edit' => Pages\EditBch::route('/{record}/edit'),
        ];
    }
}
