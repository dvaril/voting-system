<?php

namespace App\Filament\Resources\AnswerResource\Pages;

use App\Filament\Resources\AnswerResource;
use App\Models\Answer;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Enums\MaxWidth;
use Illuminate\Contracts\Support\Htmlable;

class ListAnswers extends ListRecords
{
    protected static string $resource = AnswerResource::class;

    public function getTitle(): string|Htmlable
    {
        return __('answers.resource.title');
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label(__('answers.resource.actions.create.label'))
                ->modalHeading(__('answers.resource.actions.create.modal-heading'))
                ->modalDescription(__('answers.resource.actions.create.modal-description'))
                ->modalWidth(MaxWidth::FourExtraLarge)
                ->icon('heroicon-o-plus'),
        ];
    }
}
