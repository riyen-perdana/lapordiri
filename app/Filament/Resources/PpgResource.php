<?php

namespace App\Filament\Resources;

use App\Models\Ppg;
use Filament\Forms;
use Filament\Tables;
use Nette\Utils\Html;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Faker\Provider\ar_EG\Text;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Illuminate\Support\HtmlString;
use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\Tabs;
use Illuminate\Database\Eloquent\Model;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use App\Filament\Resources\PpgResource\Pages;
use Filament\Infolists\Components\ImageEntry;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PpgResource\RelationManagers;

class PpgResource extends Resource
{
    protected static ?string $model = Ppg::class;
    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';
    protected static ?string $navigationGroup = 'Data PPG';
    protected static ?string $navigationLabel = 'Peserta';
    protected static ?string $pluralModelLabel = 'Peserta';
    protected static ?int $navigationSort = 9;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
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
                Tables\Columns\ImageColumn::make('ppg_foto')
                    ->label('Pas Foto')
                    ->circular(),
                Tables\Columns\TextColumn::make('ppg_nama')
                    ->label('Nama Peserta')
                    ->sortable()
                    ->searchable()
                    ->description(function (Ppg $record) {
                        return (new HtmlString('NIK : ' . $record->ppg_nik . '<br>SIMPATIKA : ' . $record->ppg_simpatika));
                    })
                    ->width('20%'),
                Tables\Columns\TextColumn::make('ppg_nim')
                    ->label('NIM')
                    ->default('-')
                    ->sortable()
                    ->searchable()
                    ->width('10%'),
                Tables\Columns\TextColumn::make('ppg_no_wa')
                    ->label('No Whatsapp')
                    ->sortable()
                    ->searchable()
                    ->width('10%'),
                Tables\Columns\TextColumn::make('ppg_sklh')
                    ->label('Sekolah Asal')
                    ->sortable()
                    ->searchable()
                    ->width('10%')
                    ->description(function (Ppg $record) {
                        return (new HtmlString('No.Op Sekolah : ' . $record->ppg_no_ops));
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal Daftar')
                    ->dateTime(fn(Ppg $record): ?string => date_format($record->created_at, 'd-m-Y'))
                    ->sortable()
                    ->searchable()
            ])
            ->filters([
                //
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make()
                    ->label('Detail')
                    ->modalHeading(fn(Ppg $record) => 'Detail Data Peserta ' . $record->ppg_nama . ''),
                Tables\Actions\DeleteAction::make()
                    ->label('Hapus')
                    ->requiresConfirmation()
                    ->successNotification(
                        Notification::make()
                            ->success()
                            ->title('Sukses')
                            ->body('Data Peserta Berhasil Dihapus')
                    )
                    ->modalHeading(fn(Ppg $record) => 'Hapus Data Batch ' . $record->ppg_nama . '')
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
            'index' => Pages\ListPpgs::route('/'),
            'create' => Pages\CreatePpg::route('/create'),
            'edit' => Pages\EditPpg::route('/{record}/edit'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canEdit(Model $record): bool
    {
        return false;
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Grid::make()
                ->columns([
                    'sm' => 1,
                    'xl' => 1,
                    '2xl' => 1,
                ])

                ->schema([
                    Tabs::make()
                        ->tabs([
                            Tabs\Tab::make('Data Peserta')
                                ->schema([
                                    ImageEntry::make('ppg_foto')
                                        ->label('')
                                        ->circular(),
                                    schema([
                                        TextEntry::make('ppg_nama')
                                            ->label('Nama Peserta'),
                                        TextEntry::make('ppg_nama')
                                            ->label('Nama Peserta'),
                                    ])
                                    ->columns(2),
                                ])
                                ->columns(2)
                        ])
                ])
            ]);
    }
}
