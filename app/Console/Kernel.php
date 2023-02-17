<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\AuthHanabishi;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // TODO FUMI
        // Cron実行
        // ラドさんデータ読み込んでデータ入れる
        // 例
        $schedule->call(function () {
            // TODO windows環境でクーロン実行
            // 本番環境でログ出す方法
            Log::info("やぁ！Cron schedule呼ばれてる");
            $authHanabishi = AuthHanabishi::updateOrCreate(
                [
                    'id' => "2",
                    'user_name' => "kdfjl@gmail.com"
                ],
                [
                    'user_name' => "cron test",
                    'password' => "fjdalk8jbr",
                    'sub_1' => "cron test"
                ]
        );
        })->daily();
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
}
