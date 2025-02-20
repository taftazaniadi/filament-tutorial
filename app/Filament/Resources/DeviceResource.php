<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DeviceResource\Pages;
use App\Filament\Resources\YesResource\Widgets;
use App\Filament\Resources\DeviceResource\RelationManagers;
use App\Models\Device;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DeviceResource extends Resource
{
    protected static ?string $model = Device::class;

    protected static ?string $navigationGroup = 'IoT Managements';

    protected static ?string $navigationIcon = 'heroicon-o-cpu-chip';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                TextInput::make('name')
                                    ->columnSpan(2)
                                    ->label('Device Name')
                                    ->placeholder('Enter the device name')
                                    ->required(),
                                Toggle::make('is_active')
                                    ->label('Status')
                                    ->formatStateUsing(fn($record) => $record->is_active ? true : false)
                                    ->inline(false),
                            ]),
                        Grid::make(3)
                            ->schema([
                                TextInput::make('ip')
                                    ->label('IP Address')
                                    ->placeholder('Enter the IP address')
                                    ->required(),
                                TextInput::make('mac')
                                    ->label('MAC Address')
                                    ->placeholder('Enter the MAC address')
                                    ->required(),
                                TextInput::make('port')
                                    ->label('Port')
                                    ->placeholder('Enter the port')
                                    ->required(),
                            ]),
                        RichEditor::make('description')
                            ->label('Description')
                            ->placeholder('Enter the description'),
                    ]),
                Section::make('Image')
                    ->schema([
                        Forms\Components\FileUpload::make('image')
                            ->hiddenLabel()
                            ->image(),
                    ])
                    ->collapsible(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')->circular(),
                Tables\Columns\TextColumn::make('name')->searchable(),
                Tables\Columns\TextColumn::make('ip')->searchable(),
                Tables\Columns\TextColumn::make('mac')->searchable(),
                Tables\Columns\TextColumn::make('port')->searchable(),
                Tables\Columns\TextColumn::make('is_active')->badge()
                    ->label('Status')
                    ->color(fn($record) => $record->is_active ? 'success' : 'danger')
                    ->formatStateUsing(fn($record) => $record->is_active ? 'Active' : 'Inactive'),
                // ->formatStateUsing(fn(string $state): string => ("statuses.{$state}")),
            ])
            ->filters([
                // 
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->hiddenLabel()
                    ->button(),
                Tables\Actions\EditAction::make()
                    ->hiddenLabel()
                    ->button(),
                Tables\Actions\DeleteAction::make()
                    ->hiddenLabel()
                    ->button(),
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
            'index' => Pages\ListDevices::route('/'),
            'create' => Pages\CreateDevice::route('/create'),
            'edit' => Pages\EditDevice::route('/{record}/edit'),
        ];
    }

    public static function getWidgets(): array
    {
        return [
            Widgets\CountDeviceOverview::make(),
        ];
    }
}
