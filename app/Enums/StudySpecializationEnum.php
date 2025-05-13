<?php

declare(strict_types = 1);

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum StudySpecializationEnum: string implements HasLabel, HasIcon, HasColor
{
    case INFORMATION_TECHNOLOGY = "INFORMATION_TECHNOLOGY";

    case MECHANICAL_ELECTROTECHNICIAN = 'MECHANICAL_ELECTROTECHNICIAN';

    case TECHNICAL_LYCEUM = 'TECHNICAL_LYCEUM';

    case ELECTRICIAN = 'ELECTRICIAN';

    case ELECTROTECHNICS = 'ELECTROTECHNICS';

    case ELECTROMECHANIC_FOR_DEVICES_AND_INSTRUMENTS = 'ELECTROMECHANIC_FOR_DEVICES_AND_INSTRUMENTS';

    case SOCIAL_ADMINISTRATION = 'SOCIAL_ADMINISTRATION';

    case ECONOMICS_AND_BUSINESS = 'ECONOMICS_AND_BUSINESS';

    public function getLabel(): string
    {
        return match ($this) {
            self::INFORMATION_TECHNOLOGY => __('answers.attributes.specialization.enum-cases.information-technology'),
            self::MECHANICAL_ELECTROTECHNICIAN => __('answers.attributes.specialization.enum-cases.mechanical-electrotechnician'),
            self::TECHNICAL_LYCEUM => __('answers.attributes.specialization.enum-cases.technical-lyceum'),
            self::ELECTRICIAN => __('answers.attributes.specialization.enum-cases.electrician'),
            self::ELECTROTECHNICS => __('answers.attributes.specialization.enum-cases.electrotechnics'),
            self::ELECTROMECHANIC_FOR_DEVICES_AND_INSTRUMENTS => __('answers.attributes.specialization.enum-cases.electromechanic-for-devices-and-instruments'),
            self::SOCIAL_ADMINISTRATION => __('answers.attributes.specialization.enum-cases.social-administration'),
            self::ECONOMICS_AND_BUSINESS => __('answers.attributes.specialization.enum-cases.economics-and-business'),
        };
    }

    public function getIcon(): string
    {
        return match ($this) {
            self::INFORMATION_TECHNOLOGY => 'heroicon-o-computer-desktop',
            self::MECHANICAL_ELECTROTECHNICIAN => 'heroicon-o-wrench-screwdriver',
            self::TECHNICAL_LYCEUM => 'heroicon-o-academic-cap',
            self::ELECTRICIAN => 'heroicon-o-bolt',
            self::ELECTROTECHNICS => 'heroicon-o-cpu-chip',
            self::ELECTROMECHANIC_FOR_DEVICES_AND_INSTRUMENTS => 'heroicon-o-cog',
            self::SOCIAL_ADMINISTRATION => 'heroicon-o-user-group',
            self::ECONOMICS_AND_BUSINESS => 'heroicon-o-currency-dollar',
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::INFORMATION_TECHNOLOGY => 'blue',
            self::MECHANICAL_ELECTROTECHNICIAN => 'amber',
            self::TECHNICAL_LYCEUM => 'indigo',
            self::ELECTRICIAN => 'yellow',
            self::ELECTROTECHNICS => 'cyan',
            self::ELECTROMECHANIC_FOR_DEVICES_AND_INSTRUMENTS => 'orange',
            self::SOCIAL_ADMINISTRATION => 'green',
            self::ECONOMICS_AND_BUSINESS => 'emerald',
        };
    }
}
