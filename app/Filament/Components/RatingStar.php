<?php

declare(strict_types=1);

namespace App\Filament\Components;

use Filament\Forms\Components\Concerns\HasToggleColors;
use Filament\Forms\Components\Concerns\HasToggleIcons;
use IbrahimBougaoua\FilamentRatingStar\Forms\Components\RatingStar as BaseRatingStar;

/**
 * The view is taken from RatingStar entry component. It's dynamic component is slightly altered so it can be used
 * within a form. This is also done in this very class.
 * @see \IbrahimBougaoua\FilamentRatingStar\Entries\Components\RatingStar
 *
 * The reason for this is the need to circumvent the annoying base form RatingStar component's hover animations.
 */
class RatingStar extends BaseRatingStar
{
    use HasToggleColors;
    use HasToggleIcons;

    protected string $view = 'components.rating-stars';

    protected string $size = 'lg';

    public function size(string $size): static
    {
        $this->size = $size;

        return $this;
    }

    public function getSize(): string
    {
        return $this->size;
    }
}
