<?php

namespace App\Filament\Resources;

use Actions\Action;
use Filament\Forms;
use App\Models\Kkot;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Actions\StaticAction;
use Filament\Forms\Components\Actions;
use Illuminate\Database\Eloquent\Model;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\KkotResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\KkotResource\RelationManagers;
use Filament\Tables\Filters\SelectFilter;

class KkotResource extends Resource
{
    protected static ?string $model = Kkot::class;
    protected static ?string $navigationIcon = 'heroicon-o-map';
    protected static ?string $navigationGroup = 'Area';
    protected static ?string $navigationLabel = 'Kabupaten-Kota';
    protected static ?string $pluralModelLabel = 'Kabupaten-Kota';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema(self::getCustomKabupatenKotaForm());
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
                Tables\Columns\TextColumn::make('kkot_kode')
                    ->label('Kode Kabupaten Kota')
                    ->sortable()
                    ->searchable()
                    ->width('15%'),
                Tables\Columns\TextColumn::make('kkot_nama')
                    ->label('Nama Kabupaten Kota')
                    ->sortable()
                    ->searchable()
                    ->formatStateUsing(fn (string $state): string => ucwords($state))
                    ->width('30%'),
                Tables\Columns\TextColumn::make('prov.prov_nama')
                    ->label('Nama Provinsi')
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                SelectFilter::make('prov_id')
                    ->relationship('prov', 'prov_nama')
                    ->label('Provinsi')
                    ->placeholder('Pilih Provinsi'),
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
                            ->body('Data Kabupaten-Kota Berhasil Dihapus')
                    )
                    ->modalHeading(fn(Kkot $record) => 'Hapus Data ' . $record->kkot_nama . '')
                    ->modalDescription('Apakah Anda Yakin Menghapus Data Ini?')
                    ->modalCancelActionLabel('Tidak')
                    ->modalSubmitActionLabel('Ya, Hapus Data'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('kkot_kode', 'asc');
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
            'index' => Pages\ListKkots::route('/'),
            'create' => Pages\CreateKkot::route('/create'),
            'edit' => Pages\EditKkot::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getCustomKabupatenKotaForm(): array
    {
        return [
            Forms\Components\Select::make('kkot_prov_id')
                ->preload()
                ->placeholder('Pilih Provinsi')
                ->searchable()
                ->required()
                ->relationship('prov', 'id')
                ->label('Provinsi')
                ->getOptionLabelFromRecordUsing(fn(Model $record) => "$record->prov_nama")
                ->validationMessages([
                    'required' => 'Kolom Identitas Konsumen Harus Diisi',
                ])
                ->createOptionForm(ProvResource::getCustomProvinsiForm())
                ->createOptionAction(
                    fn(Actions\Action $action) =>
                    $action
                        ->modalHeading('Tambah Provinsi')
                        ->modalFooterActionsAlignment('end')
                        ->modalSubmitAction(fn(StaticAction $action) => $action->label('Tambah')->icon('heroicon-o-plus')->color('success'))
                        ->modalCancelAction(fn(StaticAction $action) => $action->label('Batal')->icon('heroicon-o-x-mark')->color('danger'))
                        ->closeModalByClickingAway(false)
                        ->modalAutofocus(true)
                ),
            Forms\Components\TextInput::make('kkot_kode')
                ->label('Kode Kabupaten-Kota')
                ->unique(ignoreRecord: true)
                ->required()
                ->validationMessages([
                    'required' => 'Kode Kabupaten-Kota Harus Diisi',
                    'unique' => 'Kode Kabupaten-Kota Sudah Terdaftar, Isikan Yang Lain',
                ]),
            Forms\Components\TextInput::make('kkot_nama')
                ->label('Nama Kabupaten-Kota')
                ->required()
                ->validationMessages([
                    'required' => 'Nama Kabupaten-Kota Harus Diisi',
                ]),
        ];
    }
}
