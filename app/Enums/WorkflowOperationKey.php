<?php

namespace App\Enums;

enum WorkflowOperationKey: string
{
    case Filtering = 'filtering';
    case Selecting = 'selecting';
    case Limiting = 'limiting';

    /**
     * @return list<string>
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
