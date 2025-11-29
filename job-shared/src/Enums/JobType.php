<?php

namespace App\Enums;

enum JobType: string
{
    case FULL_TIME = 'Full-Time';
    case PART_TIME = 'Part-Time';
    case REMOTE = 'Remote';
    case HYBRID = 'Hybrid';
    case CONTRACT = 'Contract';
    case INTERNSHIP = 'Internship';
    case FREELANCE = 'Freelance';

    public function label(): string
    {
        return match($this) {
            self::FULL_TIME => 'Full-Time',
            self::PART_TIME => 'Part-Time',
            self::REMOTE => 'Remote',
            self::HYBRID => 'Hybrid',
            self::CONTRACT => 'Contract',
            self::INTERNSHIP => 'Internship',
            self::FREELANCE => 'Freelance',
        };
    }
}
