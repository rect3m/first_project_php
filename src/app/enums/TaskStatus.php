<?php

declare(strict_types=1);

namespace App\Enums;

enum TaskStatus: string
{
    case PENDING = 'Pending';
    case IN_PROGRESS = 'In_Progress';
    case COMPLETED = 'Completed';
}
