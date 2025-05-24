<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Filament\Resources\AnswerResource;
use App\Models\Answer;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Pages\Concerns\HasUnsavedDataChangesAlert;
use Filament\Pages\Concerns\InteractsWithFormActions;
use Filament\Pages\Page;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Locked;

#[Layout('qr-code-page-layout')]
final class QrCodePage extends Page implements HasForms, HasActions
{
    use HasUnsavedDataChangesAlert,
        InteractsWithFormActions;

    public static string $view = 'livewire.qr-code-page';

    /**
     * @var null|array
     */
    public ?array $data = [];

    /**
     * @var null|Answer
     */
    #[Locked]
    public ?Answer $incompleteAnswer = null;

    /**
     * @param  string $recordKey
     *
     * @return void
     */
    public function mount(string $recordKey): void
    {
        /* @var null|Answer $incompleteAnswer */
        $incompleteAnswer = Answer::query()->find($recordKey);

        if (! $incompleteAnswer) {
            abort(404);
        }

        if (! $incompleteAnswer->isTokenValid()) {
            abort(403, __('answers.qr-code-page.errors.expired-token'));
        }

        if (! $incompleteAnswer->isAnswered()) {
            abort(403, __('answers.qr-code-page.errors.answered'));
        }

        $this->incompleteAnswer = $incompleteAnswer;

        $this->form->fill();
    }

    /**
     * @return Answer
     */
    public function getRecord(): Answer
    {
        return $this->incompleteAnswer;
    }

    /**
     * @return array|string[]
     */
    public function getBreadcrumbs(): array
    {
        return [];
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return __('answers.qr-code-page.title');
    }

    /**
     * @param  Form $form
     *
     * @return Form
     */
    public function form(Form $form): Form
    {
        return AnswerResource::form($form)
            ->statePath('data')
            ->operation('edit')
            ->model($this->getRecord());
    }

    /**
     * @return void
     */
    public function save(): void
    {
        /* @var array<string, mixed> $state */
        $state = $this->form->getState();

        $this->incompleteAnswer->update(
            [
                'answered_at' => now(),
            ],
            ...$state
        );

        // TODO: Some success redirect
    }
}
