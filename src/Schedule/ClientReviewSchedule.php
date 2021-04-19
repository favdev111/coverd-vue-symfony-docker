<?php

namespace App\Schedule;

use Zenstruck\ScheduleBundle\Schedule;
use Zenstruck\ScheduleBundle\Schedule\ScheduleBuilder;

class ClientReviewSchedule implements ScheduleBuilder
{
    public function buildSchedule(Schedule $schedule): void
    {
        $schedule
            ->timezone('UTC')
            ->environments('prod', 'stage')
        ;

        $schedule->addCommand('app:client-review:run --force')
            ->description('Run client review job.')
            ->daily()
            ->at("06:00")
        ;
    }
}
