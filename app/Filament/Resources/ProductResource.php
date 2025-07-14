<?php

namespace App\Filament\Resources;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Category;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Illuminate\Support\Str;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Columns\ImageColumn;

class ProductResource extends Resource
{
  protected static ?string $model = Product::class;

  protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

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
        TextInput::make('price')->required()->numeric(),
        TextInput::make('content'),
        
       FileUpload::make('image'),
        // ->directory('image')           // Save files to storage/app/resumes
        // ->preserveFilenames()
        // ->maxSize(2048)                  // Max 2MB
        // ->required(),


      Select::make('category_id')
        ->label('Select Category')
        ->options(Category::all()->pluck('name', 'id'))
        ->searchable(),

      Textarea::make('content')




    ]);
  }

  public static function table(Table $table): Table
  {
    return $table
      ->columns([
        TextColumn::make('id')->sortable(),
        TextColumn::make('name')->sortable()->searchable(),
        TextColumn::make('slug'),
        TextColumn::make('price')->numeric()->sortable()->searchable(),
        TextColumn::make('content')->sortable()->searchable(),
      ImageColumn::make('image')
        ->circular()
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
      'index' => Pages\ListProducts::route('/'),
      'create' => Pages\CreateProduct::route('/create'),
      'edit' => Pages\EditProduct::route('/{record}/edit'),
    ];
  }
}
