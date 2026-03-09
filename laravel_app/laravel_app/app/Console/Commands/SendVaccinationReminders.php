<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\VaccinationSchedule;
use App\Notifications\VaccinationReminder;
use Carbon\Carbon;

class SendVaccinationReminders extends Command
{
    protected $signature = 'reminders:send';
    protected $description = '接種予定日のリマインダーを送信する';

    public function handle()
    {
        $today = Carbon::today();
        $targetDays = [30, 14, 7, 1, 0];

        foreach ($targetDays as $days) {
            $targetDate = $today->copy()->addDays($days);

            $schedules = VaccinationSchedule::with(['child.user', 'vaccine'])
                ->where('status', 'pending')
                ->whereDate('scheduled_date', $targetDate)
                ->get();

            foreach ($schedules as $schedule) {
                $user = $schedule->child->user;

                if ($user && $user->pushSubscriptions->isNotEmpty()) {
                    $user->notify(new VaccinationReminder(
                        $schedule->child->nickname,
                        $schedule->vaccine->name,
                        $schedule->scheduled_date->format('Y年m月d日'),
                        $days
                    ));

                    $this->info("通知送信: {$user->name} → {$schedule->child->nickname} の {$schedule->vaccine->name}（あと{$days}日）");
                }
            }
        }

        $this->info('リマインダーの送信が完了しました！');
    }
}