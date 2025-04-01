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
        // TODO: Add Icons
        return match ($this) {
            self::INFORMATION_TECHNOLOGY => '',
            self::MECHANICAL_ELECTROTECHNICIAN => '',
            self::TECHNICAL_LYCEUM => '',
            self::ELECTRICIAN => '',
            self::ELECTROTECHNICS => '',
            self::ELECTROMECHANIC_FOR_DEVICES_AND_INSTRUMENTS => '',
            self::SOCIAL_ADMINISTRATION => '',
            self::ECONOMICS_AND_BUSINESS => '',
        };
    }

    public function getColor(): string
    {
        // TODO: Add Colors
        return match ($this) {
            self::INFORMATION_TECHNOLOGY => '',
            self::MECHANICAL_ELECTROTECHNICIAN => '',
            self::TECHNICAL_LYCEUM => '',
            self::ELECTRICIAN => '',
            self::ELECTROTECHNICS => '',
            self::ELECTROMECHANIC_FOR_DEVICES_AND_INSTRUMENTS => '',
            self::SOCIAL_ADMINISTRATION => '',
            self::ECONOMICS_AND_BUSINESS => '',
        };
    }
}
