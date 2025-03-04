<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Enums\StudySpecializationEnum;
use App\Filament\Resources\AnswerResource\Pages;
use App\Models\Answer;
use Filament\Tables\Grouping\Group;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Forms\Components\{ToggleButtons, Select};
use Filament\Tables\Actions\{DeleteBulkAction, EditAction, DeleteAction, ActionGroup, RestoreAction, RestoreBulkAction};
use Filament\Tables\Filters\{TrashedFilter, SelectFilter};
use Filament\Support\Enums\MaxWidth;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use App\Filament\Components\RatingStar as FormRatingStart;
use IbrahimBougaoua\FilamentRatingStar\Columns\Components\RatingStar;

final class AnswerResource extends Resource
{
    protected static ?string $model = Answer::class;
    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';

    public static function getSlug(): string
    {
        return __('answers.resource.slug');
    }

    public static function getModelLabel(): string
    {
        return __('answers.resource.model-label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('answers.resource.plural-model-label');
    }

    public static function getNavigationLabel(): string
    {
        return __('answers.resource.navigation-label');
    }

    // TODO: Disable fields below on specific livewire component when implemented

    public static function form(Form $form): Form
    {
        return $form
            ->columns(1)
            ->schema([
                Select::make('school_id')
                    ->label(__('answers.attributes.school-name'))
                    ->relationship('school', 'name')
                    ->searchable(),
                ToggleButtons::make('specialization')
                    ->label(__('answers.attributes.specialization.name'))
                    ->options(StudySpecializationEnum::class)
                    ->required()
                    ->columns(4)
                    ->gridDirection('row')
                    ->validationMessages([
                        'required' => __('answers.resource.form.components.specialization.required-validation-message')
                    ]),
                FormRatingStart::make('overall_rating')
                    ->label(__('answers.attributes.overall_rating'))
                    ->hiddenOn('create')
                    ->disabled(fn (Answer $record) => $record->isAnswered()),
                FormRatingStart::make('teacher_approach_rating')
                    ->label(__('answers.attributes.teacher_approach_rating'))
                    ->hiddenOn('create')
                    ->disabled(fn (Answer $record) => $record->isAnswered()),
                FormRatingStart::make('expectation_fulfillment_rating')
                    ->label(__('answers.attributes.expectation_fulfillment_rating'))
                    ->hiddenOn('create')
                    ->disabled(fn (Answer $record) => $record->isAnswered()),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->heading(__('answers.resource.table.heading'))
            ->groups([
                Group::make('school.name')
                    ->label(__('answers.attributes.school-name'))
                    ->collapsible(),
                Group::make('specialization')
                    ->label(__('answers.attributes.specialization.name'))
                    ->collapsible(),
            ])
            ->columns([
                TextColumn::make('school.name')
                    ->label(__('answers.attributes.school-name'))
                    ->placeholder(__('answers.resource.table.columns.school-name-placeholder'))
                    ->searchable()
                    ->tooltip(function (TextColumn $column) {
                        $state = $column->getState();

                        return $state && strlen($state) > $column->getCharacterLimit() ? $state : null;
                    })
                    ->limit(30)
                    ->sortable(),
                TextColumn::make('specialization')
                    ->label(__('answers.attributes.specialization.name'))
                    ->badge()
                    ->getStateUsing(fn (Answer $record): string => $record->specialization->getLabel())
                    ->color(fn (Answer $record): string => $record->specialization->getColor())
                    ->searchable(),
                RatingStar::make('overall_rating')
                    ->label(__('answers.attributes.overall_rating'))
                    ->sortable(),
                RatingStar::make('teacher_approach_rating')
                    ->label(__('answers.attributes.teacher_approach_rating'))
                    ->sortable(),
                RatingStar::make('expectation_fulfillment_rating')
                    ->label(__('answers.attributes.expectation_fulfillment_rating'))
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label(__('answers.attributes.created_at'))
                    ->dateTime('d. m. Y H:i:s')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('answered_at')
                    ->label(__('answers.attributes.answered_at'))
                    ->placeholder(__('answers.resource.table.columns.answered-at-placeholder'))
                    ->dateTime('d. m. Y H:i:s')
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                SelectFilter::make('school_id')
                    ->label(__('answers.attributes.school-name'))
                    ->relationship('school', 'name')
                    ->searchable()
                    ->multiple(),
                SelectFilter::make('specialization')
                    ->label(__('answers.attributes.specialization.name'))
                    ->options(StudySpecializationEnum::class)
                    ->searchable()
                    ->multiple(),
                TrashedFilter::make()
            ])
            ->actions([
                ActionGroup::make([
                    EditAction::make()
                        ->modalHeading(__('answers.resource.table.actions.edit.modal-heading'))
                        ->modalDescription(fn (Answer $record): string => __('answers.resource.table.actions.edit.modal-description', [
                            'date' => $record->created_at->format('d. m. Y - H:i:s')
                        ]))
                        ->color('primary')
                        ->modalWidth(MaxWidth::FourExtraLarge),
                    RestoreAction::make()
                        ->modalHeading(__('answers.resource.table.actions.restore.modal-heading'))
                        ->modalDescription(__('answers.resource.table.actions.restore.modal-description'))
                        ->color('success'),
                    DeleteAction::make()
                        ->modalHeading(__('answers.resource.table.actions.delete.modal-heading'))
                        ->modalDescription(__('answers.resource.table.actions.delete.modal-description')),
                ])
            ])
            ->bulkActions([
                RestoreBulkAction::make()
                    ->modalHeading(__('answers.resource.table.bulk-actions.restore.modal-heading'))
                    ->modalDescription(__('answers.resource.table.bulk-actions.restore.modal-description'))
                    ->color('success'),
                DeleteBulkAction::make()
                    ->modalHeading(__('answers.resource.table.bulk-actions.delete.modal-heading'))
                    ->modalDescription(__('answers.resource.table.bulk-actions.delete.modal-description'))
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAnswers::route('/'),
        ];
    }
}
