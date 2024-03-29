<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

use Illuminate\Support\Facades\Log;
use App\Console\Commands\BnRadoDataLoadCommand;
use App\Console\Commands\RapelleCron;

class Kernel extends ConsoleKernel
{

    protected $commands = [
        Commands\BnRadoDataLoadCommand::Class,
        Commands\RapelleCron::Class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        Log::debug('[OVHのCron] schedule関数呼ばれた');
        //Load Json datas from Rado server and insert to database
        $schedule->command('radodataload:info --force')->daily();
        $schedule->command('rapelle:do  --force')->daily();
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
    // protected function scheduleTimezone()
    // {
    //     return 'Africa/Tunis';
    // }
}
