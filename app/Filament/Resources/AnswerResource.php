<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Enums\StudySpecializationEnum;
use App\Filament\Exports\AnswerExporter;
use App\Filament\Resources\AnswerResource\Pages;
use App\Livewire\QrCodePage;
use App\Models\Answer;
use Filament\Actions\Exports\Enums\ExportFormat;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Grouping\Group;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Forms\Components\{ToggleButtons, Select};
use Filament\Tables\Actions\{Action, DeleteBulkAction, EditAction, DeleteAction, ActionGroup, ExportAction};
use Filament\Tables\Filters\SelectFilter;
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

    public static function form(Form $form): Form
    {
        return $form
            ->columns(1)
            ->schema([
                Select::make('school_id')
                    ->label(__('answers.attributes.school-name'))
                    ->relationship('school', 'name')
                    ->hidden(self::isOnQrCodePage(...))
                    ->searchable(),
                ToggleButtons::make('specialization')
                    ->label(__('answers.attributes.specialization.name'))
                    ->options(StudySpecializationEnum::class)
                    ->required()
                    ->columns(4)
                    ->gridDirection('row')
                    ->hidden(self::isOnQrCodePage(...))
                    ->validationMessages([
                        'required' => __('answers.resource.form.components.specialization.required-validation-message')
                    ]),
                FormRatingStart::make('overall_rating')
                    ->label(__('answers.attributes.overall_rating'))
                    ->hiddenOn('create')
                    ->disabled(self::isFormRatingStarDisabled(...)),
                FormRatingStart::make('teacher_approach_rating')
                    ->label(__('answers.attributes.teacher_approach_rating'))
                    ->hiddenOn('create')
                    ->disabled(self::isFormRatingStarDisabled(...)),
                FormRatingStart::make('expectation_fulfillment_rating')
                    ->label(__('answers.attributes.expectation_fulfillment_rating'))
                    ->hiddenOn('create')
                    ->disabled(self::isFormRatingStarDisabled(...)),
            ]);
    }

    private static function isOnQrCodePage(HasForms $livewire): bool
    {
        return $livewire instanceof QrCodePage;
    }

    /**
     * @param  HasForms $livewire
     * @param  Answer $record
     *
     * @return bool
     */
    private static function isFormRatingStarDisabled(HasForms $livewire, Answer $record): bool
    {
        return $record->isAnswered() || ! self::isOnQrCodePage($livewire);
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
                    ->icon(fn (Answer $record): string => $record->specialization->getIcon())
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
                    ->multiple()
            ])
            ->actions([
                ActionGroup::make([
                    self::configureOpenQrCodeWindow(Action::make('openQrCodeWindow')),
                    EditAction::make()
                         ->modalHeading(__('answers.resource.table.actions.edit.modal-heading'))
                         ->modalDescription(fn (Answer $record): string => __('answers.resource.table.actions.edit.modal-description', [
                            'date' => $record->created_at->format('d. m. Y - H:i:s')
                         ]))
                        ->extraModalFooterActions([
                            self::configureOpenQrCodeWindow(Action::make('openQrCodeWindow')),
                        ])
                        ->color('primary')
                        ->modalWidth(MaxWidth::FourExtraLarge),
                    DeleteAction::make()
                        ->modalHeading(__('answers.resource.table.actions.delete.modal-heading'))
                        ->modalDescription(__('answers.resource.table.actions.delete.modal-description')),
                ])
            ])
            ->bulkActions([
                DeleteBulkAction::make()
                    ->modalHeading(__('answers.resource.table.bulk-actions.delete.modal-heading'))
                    ->modalDescription(__('answers.resource.table.bulk-actions.delete.modal-description'))
            ])
            ->headerActions([
                ExportAction::make()
                    ->label(__('answers.resource.table.header-actions.export.label'))
                    ->modalDescription(__('answers.resource.table.header-actions.export.modal-description'))
                    ->color('success')
                    ->icon('heroicon-o-arrow-up-tray')
                    ->formats([
                        ExportFormat::Csv
                        // Only Csv is present here because Xlsx had encoding problems when downloading
                    ])
                    ->exporter(AnswerExporter::class)
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAnswers::route('/'),
        ];
    }

    /**
     * @param  Action $action
     *
     * @return Action
     */
    private static function configureOpenQrCodeWindow(Action $action): Action
    {
        return $action
            ->label(__('answers.resource.actions.qr-code-window.label'))
            ->requiresConfirmation()
            ->modalHeading(__('answers.resource.actions.qr-code-window.modal-heading'))
            ->modalDescription(__('answers.resource.actions.qr-code-window.modal-description'))
            ->color('success')
            ->icon('heroicon-o-qr-code')
            ->action(self::openQrCodeWindow(...));
    }

    /**
     * @param  HasTable | HasForms $livewire
     * @param  Answer $record
     *
     * @return void
     */
    public static function openQrCodeWindow(HasTable | HasForms $livewire, Answer $record): void
    {
        $livewire->dispatch('open-qr-code-window',
            recordKey: $record->getKey()
        );
    }
}
