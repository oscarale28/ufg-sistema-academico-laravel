<?php

namespace App\Filament\Resources\Alumnos\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class AlumnoForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nie')
                    ->required()
                    ->maxLength(255)
                    ->unique(table: 'alumnos', column: 'nie', ignoreRecord: true),
                TextInput::make('nombres')
                    ->required()
                    ->maxLength(255),
                TextInput::make('apellidos')
                    ->required()
                    ->maxLength(255),
                TextInput::make('edad')
                    ->numeric()
                    ->required()
                    ->minValue(1)
                    ->maxValue(120),
                Select::make('sexo')
                    ->options([
                        'Masculino' => 'Masculino',
                        'Femenino' => 'Femenino',
                    ])
                    ->required(),
                TextInput::make('direccion')
                    ->required()
                    ->maxLength(255),
                TextInput::make('telefono')
                    ->required()
                    ->maxLength(30),
                TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255)
                    ->unique(table: 'alumnos', column: 'email', ignoreRecord: true),
                TextInput::make('responsable')
                    ->required()
                    ->maxLength(255),
            ]);
    }
}
