<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

use Illuminate\Support\Facades\Log;
use App\Console\Commands\RapelleCron;

class KernelRapelle extends ConsoleKernel
{
    protected $commands = [
        Commands\RapelleCron::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('rapelle:do --force')->dailyAt('23:00');
        // OVH独特のCron仕様（分がランダム取得されちゃう）をハックするコマンド
        $this->scheduleRunsHourly($schedule);
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }

    //Fumi 追加
    protected function scheduleRunsHourly(Schedule $schedule)
    {
        foreach ($schedule->events() as $event) {
            $event->expression = substr_replace($event->expression, '*', 0, 1);
        }
    }

    /**
     * スケジュールされたイベントで使用するデフォルトのタイムゾーン取得
     *
     * @return \DateTimeZone|string|null
     */
    protected function scheduleTimezone()
    {
        return 'Africa/Tunis';
    }
}
