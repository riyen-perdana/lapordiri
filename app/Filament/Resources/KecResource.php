<?php

namespace App\Filament\Resources;

use App\Models\Kec;
use Filament\Forms;
use App\Models\Kkot;
use App\Models\Prov;
use Filament\Tables;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Actions\StaticAction;
use function Laravel\Prompts\form;
use Illuminate\Support\Collection;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Actions;
use Filament\Notifications\Notification;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\KecResource\Pages;

use NunoMaduro\Collision\Adapters\Phpunit\State;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\KecResource\RelationManagers;

class KecResource extends Resource
{
    protected static ?string $model = Kec::class;
    protected static ?string $navigationIcon = 'heroicon-o-map';
    protected static ?string $navigationGroup = 'Area';
    protected static ?string $navigationLabel = 'Kecamatan';
    protected static ?string $pluralModelLabel = 'Kecamatan';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema(self::getCustomKecamatanForm());
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
                Tables\Columns\TextColumn::make('kec_kode')
                    ->label('Kode Kecamatan')
                    ->sortable()
                    ->searchable()
                    ->width('15%'),
                Tables\Columns\TextColumn::make('kec_nama')
                    ->label('Nama Kecamatan')
                    ->sortable()
                    ->searchable()
                    ->formatStateUsing(fn(string $state): string => ucwords($state)),
                Tables\Columns\TextColumn::make('kkot.kkot_nama')
                    ->label('Nama Kabupaten Kota')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('kkot.prov.prov_nama')
                    ->label('Nama Provinsi')
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                Filter::make('Area')
                    ->form([
                        Select::make('prov_id')
                            ->label('Provinsi')
                            ->placeholder('Pilih Provinsi')
                            ->options(Prov::orderBy('prov_kode')->pluck('prov_nama', 'id'))
                            ->searchable()
                            ->preload()
                            ->live()
                            ->afterStateUpdated(fn(Get $get, Set $set) => $set('kkot_id', null)),
                        Select::make('kkot_id')
                            ->options(fn(Get $get): Collection => Kkot::query()
                                ->where('kkot_prov_id', $get('prov_id'))
                                ->pluck('kkot_nama', 'id'))
                            ->label('Kabupaten Kota')
                            ->placeholder('Pilih Kabupaten Kota')
                            ->searchable()
                            ->preload()
                    ])
                    ->query(function (Builder $query, array $data) {
                        return $query->when($data['kkot_id'], function ($query) use ($data) {
                            return  $query->where('kec_kkot_id', $data['kkot_id']);
                        });
                    }),
                    // ->indicateUsing(function (array $data): ?string {
                    //     if ($data['kkot_id']) {
                    //         return 'Semua Kabupaten Kota';
                    //     }
                    // }),
                // SelectFilter::make('prov_id')
                //     ->relationship('kkot.prov', 'prov_nama')
                //     ->label('Provinsi')
                //     ->placeholder('Pilih Provinsi')
                //     ->searchable()
                //     ->preload()
                // SelectFilter::make('kot_id')
                //     ->relationship('kkot', 'kkot_nama')
                //     ->label('Kabupaten Kota')
                //     ->placeholder('Pilih Kabupaten Kota')
                //     ->searchable()
                //     ->preload(),
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
                            ->body('Data Kecamatan Berhasil Dihapus')
                    )
                    ->modalHeading(fn(Kec $record) => 'Hapus Data ' . $record->kec_nama . '')
                    ->modalDescription('Apakah Anda Yakin Menghapus Data Ini?')
                    ->modalCancelActionLabel('Tidak')
                    ->modalSubmitActionLabel('Ya, Hapus Data'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('kec_kode');
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
            'index' => Pages\ListKecs::route('/'),
            'create' => Pages\CreateKec::route('/create'),
            'edit' => Pages\EditKec::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getCustomKecamatanForm(): array
    {
        return [
            Forms\Components\Select::make('prov')
                ->preload()
                ->placeholder('Pilih Provinsi')
                ->searchable()
                ->required()
                ->options(Prov::orderBy('prov_kode')->pluck('prov_nama', 'id'))
                ->live()
                ->label('Provinsi')
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
                )
                ->afterStateUpdated(fn(Get $get, Set $set) => $set('kec_kkot_id', null))
                ->dehydrated(true),
            Forms\Components\Select::make('kec_kkot_id')
                ->preload()
                ->placeholder('Pilih Kabupaten-Kota')
                ->searchable()
                ->required()
                ->options(fn(Get $get): Collection => Kkot::query()
                    ->where('kkot_prov_id', $get('prov'))
                    ->pluck('kkot_nama', 'id'))
                ->label('Kabupaten-Kota')
                ->createOptionForm(KkotResource::getCustomKabupatenKotaForm())
                ->createOptionAction(
                    fn(Actions\Action $action) =>
                    $action
                        ->modalHeading('Tambah Kabupaten-Kota')
                        ->modalFooterActionsAlignment('end')
                        ->modalSubmitAction(fn(StaticAction $action) => $action->label('Tambah')->icon('heroicon-o-plus')->color('success'))
                        ->modalCancelAction(fn(StaticAction $action) => $action->label('Batal')->icon('heroicon-o-x-mark')->color('danger'))
                        ->closeModalByClickingAway(false)
                        ->modalAutofocus(true)
                ),
            Forms\Components\TextInput::make('kec_kode')
                ->label('Kode Kecamatan')
                ->required()
                ->unique(ignoreRecord: true)
                ->numeric()
                ->validationMessages([
                    'unique' => 'Kode Kecamatan Sudah Terdaftar, Isikan Yang Lain',
                    'required' => 'Kode Kecamatan Harus Diisi',
                    'numeric' => 'Kode Kecamatan Harus Berupa Angka',
                ]),
            Forms\Components\TextInput::make('kec_nama')
                ->label('Nama Kecamatan')
                ->required()
                ->unique(ignoreRecord: true)
                ->validationMessages([
                    'unique' => 'Nama Kecamatan Sudah Terdaftar, Isikan Yang Lain',
                    'required' => 'Nama Kecamatan Harus Diisi',
                ]),
        ];
    }
}
