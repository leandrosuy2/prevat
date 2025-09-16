<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewRegisterNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct($user_id)
    {
        $this->user = User::query()->with('company')->findOrFail($user_id);
//        $this->token = $token;
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
            ->subject('Olá ! Seja bem vindo a Prevat')
            ->line('Olá, '.$this->user['name'].'! Seu cadastro foi efetuado com sucesso e está em análise por nossa equipe para ativação, assim que ativado você receberá um email!')
//            ->action('Desbloquear', route('user.verify', $this->token))
            ->line('Obrigado por escolher nossa plataforma !');
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
