<?php

namespace App\Enum;

enum SkillType: string
{
    case LANGUAGE = 'language';
    case FRAMEWORK = 'framework';
    case TOOL = 'tool';

    public static function values(): array
    {
        return [
            self::LANGUAGE->value,
            self::FRAMEWORK->value,
            self::TOOL->value,
        ];
    }
}
