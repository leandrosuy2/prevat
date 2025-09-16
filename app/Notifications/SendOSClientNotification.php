<?php

namespace App\Notifications;

use App\Models\ServiceOrder;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Attachment;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendOSClientNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct($service_order_id)
    {
        $this->order = ServiceOrder::query()->with(['contact','company'])->withoutGlobalScopes()->findOrFail($service_order_id);
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
                ->subject('Olá ! Você recebeu uma nova OS Prevat!')
                ->line('Para sua comodidade enviamos a Ordem de serviço referente aos treinamentos do mês !')
                ->action('Vizualizar', url('storage/'.strtr($this->order['os_path'], ['app/public/' => ''])))
                ->line('Agradecemos a preferencia !');
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

//    /**
//     * Get the attachments for the message.
//     *
//     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
//     */
//    public function attachments(): array
//    {
//        return [
//            Attachment::fromStorage('/path/to/file'),
//        ];
//    }
}
