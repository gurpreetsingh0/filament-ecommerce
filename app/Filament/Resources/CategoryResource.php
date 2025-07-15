<?php

namespace App\Filament\Resources;

use Filament\Tables\Actions\Action;
use Filament\Forms\Components\Select;

use App\Filament\Resources\CategoryResource\Pages;
use App\Filament\Resources\CategoryResource\RelationManagers;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Illuminate\Support\Str;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;



use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
       TextInput::make('name')
        ->live(onBlur: true)
        ->afterStateUpdated(function (Get $get, Set $set, ?string $old, ?string $state) {
          if (($get('slug') ?? '') !== Str::slug($old)) {
            return;
          }

          $set('slug', Str::slug($state));
        }),

      TextInput::make('slug'),

      Select::make('status')
        ->label('Select Status')
        ->options([
          'active'=>'Active',
          'deactive'=>'Deactive'
        ]),
     ]);



    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
            TextColumn::make('id')->sortable(),
            TextColumn::make('name')->sortable()->searchable(),
            TextColumn::make('slug'),
            TextColumn::make('status'),

     
            
            
    ])
    
    // ->headerActions([
    //   Action::make('createCategory')
    //     ->label('Create Category')
    //     ->modalHeading('New Category')
    //     ->form([
    //      TextInput::make('name')
    //     ->live(onBlur: true)
    //     ->afterStateUpdated(function (Get $get, Set $set, ?string $old, ?string $state) {
    //       if (($get('slug') ?? '') !== Str::slug($old)) {
    //         return;
    //       }

    //       $set('slug', Str::slug($state));
    //     }),

    //   TextInput::make('slug')
    //     ])
    //     ->action(function (array $data) {
    //       \App\Models\Category::create($data);
    //     })
    //     ->successNotificationTitle('Category created successfully')
    //     ->icon('heroicon-o-plus'),
    // ])
            ->filters([
                //
            ])
            ->actions([
                    ActionGroup::make([
                      ViewAction::make(),
                      EditAction::make(),
                      DeleteAction::make(),
                    ]),
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
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}
