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
        //Log::debug('[OVHのCron] KernelDinnerStock->schedule関数呼ばれた');

        // dinnerの食材量をチェックしてアラートメールを送信
        // 30分毎に10回実行
        $schedule->command('rapelle:do --force')->everyThirtyMinutes()->times(10);
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
