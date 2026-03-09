<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use NotificationChannels\WebPush\WebPushChannel;
use NotificationChannels\WebPush\WebPushMessage;

class VaccinationReminder extends Notification
{
    use Queueable;

    protected $childName;
    protected $vaccineName;
    protected $scheduledDate;
    protected $daysUntil;

    public function __construct($childName, $vaccineName, $scheduledDate, $daysUntil)
    {
        $this->childName = $childName;
        $this->vaccineName = $vaccineName;
        $this->scheduledDate = $scheduledDate;
        $this->daysUntil = $daysUntil;
    }

    public function via($notifiable)
    {
        return [WebPushChannel::class];
    }

    public function toWebPush($notifiable, $notification)
    {
        if ($this->daysUntil === 0) {
            $body = "今日は{$this->childName}の{$this->vaccineName}の接種日です！";
        } else {
            $body = "{$this->childName}の{$this->vaccineName}の接種予定日まであと{$this->daysUntil}日です。";
        }

        return (new WebPushMessage)
            ->title('💉 予防接種リマインダー')
            ->body($body)
            ->action('スケジュールを確認する', 'check_schedule')
            ->data(['url' => url('/dashboard')]);
    }
}