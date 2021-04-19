<?php

namespace App\Schedule;

use Zenstruck\ScheduleBundle\Schedule;
use Zenstruck\ScheduleBundle\Schedule\ScheduleBuilder;

class ClientExpirationSchedule implements ScheduleBuilder
{
    public function buildSchedule(Schedule $schedule): void
    {
        $schedule
            ->timezone('UTC')
            ->environments('prod', 'stage')
        ;

        $schedule->addCommand('app:client-expiration --force')
            ->description('Run client expiration job.')
            ->daily()
            ->at("06:00")
        ;
    }
}
