<?php

namespace App\Filament\Resources\Alumnos\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AlumnosTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nie')
                    ->label('NIE')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('nombres')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('apellidos')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('edad')
                    ->sortable(),
                TextColumn::make('sexo')
                    ->searchable(),
                TextColumn::make('telefono')
                    ->searchable(),
                TextColumn::make('email')
                    ->searchable(),
                TextColumn::make('responsable')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
