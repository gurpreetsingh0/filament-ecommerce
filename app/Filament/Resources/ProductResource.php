<?php

namespace App\Filament\Resources;

use Filament\Tables\Actions\BulkAction;

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
use Filament\Tables\Filters\SelectFilter;

use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;

class ProductResource extends Resource
{
  protected static ?string $model = Product::class;

  protected static ?string $navigationIcon = 'heroicon-o-adjustments-horizontal';
  

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
         
       FileUpload::make('image'),
       FileUpload::make('gallery_images')
        ->multiple(),
        


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
        ImageColumn::make('image')->circular(),
        TextColumn::make('category.name')


    ])
      ->filters([
      SelectFilter::make('category')
        ->relationship('category', 'name')
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
      'index' => Pages\ListProducts::route('/'),
      'create' => Pages\CreateProduct::route('/create'),
      'edit' => Pages\EditProduct::route('/{record}/edit'),
    ];
  }
}
