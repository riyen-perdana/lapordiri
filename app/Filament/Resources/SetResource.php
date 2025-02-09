<?php

namespace App\Filament\Resources;

use App\Models\Set;
use Filament\Forms;
use Filament\Tables;
use App\Enums\Semester;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\SetResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\SetResource\RelationManagers;
use Filament\Forms\Components\Tabs\Tab;

class SetResource extends Resource
{
    protected static ?string $model = Set::class;
    protected static ?string $navigationIcon = 'heroicon-o-cog-8-tooth';
    protected static ?string $navigationGroup = 'Setting';
    protected static ?string $navigationLabel = 'Semester';
    protected static ?string $pluralModelLabel = 'Semester';
    protected static ?int $navigationSort = 10;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('set_thn')
                    ->label('Tahun Semester')
                    ->autofocus()
                    ->required()
                    ->numeric()
                    ->validationMessages([
                        'required' => 'Kolom Tahun Tidak Boleh Kosong',
                        'numeric' => 'Kolom Tahun Harus Berupa Angka',
                    ]),
                Forms\Components\Select::make('set_smt')
                    ->preload()
                    ->searchable()
                    ->label('Semester')
                    ->required()
                    ->options(Semester::class)
                    ->placeholder('Pilih Semester'),
                Forms\Components\Toggle::make('set_sts')
                    ->label('Status Semester')
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
                Tables\Columns\TextColumn::make('set_thn')
                    ->label('Tahun Semester')
                    ->sortable()
                    ->searchable()
                    ->width('15%'),
                Tables\Columns\TextColumn::make('set_smt')
                    ->label('Semester')
                    ->sortable()
                    ->searchable()
                    ->badge()
                    ->color(fn (Set $set): string => $set->set_smt->getColor())
                    ->width('15%'),
                Tables\Columns\ToggleColumn::make('set_sts')
                    ->label('Status')
                    ->sortable()
                    ->onIcon('heroicon-m-check-circle')
                    ->offIcon('heroicon-m-x-circle')
                    ->onColor('success')
                    ->verticalAlignment('end'),
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
                    ->modalHeading(fn(Set $record) => 'Hapus Data ' . $record->set_thn . ' ' .$record->set_smt->getLabel() . '')
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
            'index' => Pages\ListSets::route('/'),
            'create' => Pages\CreateSet::route('/create'),
            'edit' => Pages\EditSet::route('/{record}/edit'),
        ];
    }
}
