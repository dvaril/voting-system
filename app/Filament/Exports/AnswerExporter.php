<?php

namespace App\Filament\Exports;

use App\Enums\StudySpecializationEnum;
use App\Models\Answer;
use Carbon\Carbon;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

final class AnswerExporter extends Exporter
{
    protected static ?string $model = Answer::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('school.name')
                ->label(__('answers.attributes.school-name')),
            ExportColumn::make('specialization')
                ->label(__('answers.attributes.specialization.name'))
                ->formatStateUsing(fn (StudySpecializationEnum $state) => $state->getLabel()),
            ExportColumn::make('overall_rating')
                ->label(__('answers.attributes.overall_rating')),
            ExportColumn::make('teacher_approach_rating')
                ->label(__('answers.attributes.teacher_approach_rating')),
            ExportColumn::make('expectation_fulfillment_rating')
                ->label(__('answers.attributes.expectation_fulfillment_rating')),
            ExportColumn::make('answered_at')
                ->label(__('answers.attributes.answered_at'))
                ->formatStateUsing(fn (?Carbon $state) => $state?->format('d. m. Y H:i:s')),
            ExportColumn::make('created_at')
                ->label(__('answers.attributes.created_at'))
                ->formatStateUsing(fn (?Carbon $state) => $state?->format('d. m. Y H:i:s'))
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $successSuffixTranslation = match ($export->successful_rows) {
            1 => 'answers.resource.table.header-actions.export.exported-notification.successful-rows.single',
            2, 3, 4 => 'answers.resource.table.header-actions.export.exported-notification.successful-rows.two-three-four',
            default => 'answers.resource.table.header-actions.export.exported-notification.successful-rows.five-above'
        };

        $body = __('answers.resource.table.header-actions.export.exported-notification.successful-rows.body') . ' '
            . __($successSuffixTranslation, ['count' => number_format($export->successful_rows)]);

        if ($failedRowsCount = $export->getFailedRowsCount()) {

            $failedSuffixTranslation = match ($failedRowsCount) {
                1 => 'answers.resource.table.header-actions.export.exported-notification.failed-rows.single',
                2, 3, 4, 5 => 'answers.resource.table.header-actions.export.exported-notification.failed-rows.two-three-five',
                default => 'answers.resource.table.header-actions.export.exported-notification.failed-rows.six-above',
            };

            $body .= ' ' . __('answers.resource.table.header-actions.export.exported-notification.failed-rows.body') . ' ' .
                __($failedSuffixTranslation, ['count' => number_format($failedRowsCount)]);
        }

        return $body;
    }
}
