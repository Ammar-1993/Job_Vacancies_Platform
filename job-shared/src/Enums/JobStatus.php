<?php

namespace App\Enums;

enum JobStatus: string
{
    case PENDING = 'pending';
    case ACCEPTED = 'accepted';
    case REJECTED = 'rejected';

    public function label(): string
    {
        return match($this) {
            self::PENDING => 'Pending',
            self::ACCEPTED => 'Accepted',
            self::REJECTED => 'Rejected',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::PENDING => 'text-purple-600',
            self::ACCEPTED => 'text-green-600',
            self::REJECTED => 'text-red-600',
        };
    }
}
