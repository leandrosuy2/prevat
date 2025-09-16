<?php

namespace App\Notifications;

use App\Models\ScheduleCompany;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendNewScheduleCompanyNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct($scheduleCompanyID)
    {
        $this->schedule = ScheduleCompany::query()->with(['company', 'schedule.training'])->withoutGlobalScopes()->find($scheduleCompanyID);
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Olá ! Um novo agendamento foi efetuado .')
            ->line('Olá, a Empresa '.$this->schedule['company']['name'].', fez um novo agendamento para o treinamento '.$this->schedule['schedule']['training']['name']. ' na data ' .formatDate($this->schedule['schedule']['date_event']))
            ->action('Vizualizar', route('movement.schedule-company.edit', $this->schedule['id']))
            ->line('Obrigado !');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
