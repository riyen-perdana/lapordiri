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
use Illuminate\Support\Collection;
use Filament\Forms\Components\Actions;
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
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
                ->afterStateUpdated(fn (Get $get, Set $set) => $set('kec_kkot_id', null)),
            Forms\Components\Select::make('kec_kkot_id')
                ->preload()
                ->placeholder('Pilih Kabupaten-Kota')
                ->searchable()
                ->required()
                ->options(fn (Get $get): Collection => Kkot::query()
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
        ];
    }
}
