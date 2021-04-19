<?php

namespace App\Schedule;

use Zenstruck\ScheduleBundle\Schedule;
use Zenstruck\ScheduleBundle\Schedule\ScheduleBuilder;

class PartnerReviewSchedule implements ScheduleBuilder
{
    public function buildSchedule(Schedule $schedule): void
    {
        $schedule
            ->timezone('UTC')
            ->environments('prod', 'stage')
        ;

        $schedule->addCommand('app:partner-review:run --force')
            ->description('Run partner review job.')
            ->daily()
            ->at("06:00")
        ;
    }
}
