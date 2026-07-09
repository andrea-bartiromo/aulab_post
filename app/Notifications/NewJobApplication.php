<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\JobApplication; // Importiamo il modello delle candidature
use App\Models\User; // Importiamo anche User per sicurezza

class NewJobApplication extends Notification
{
    use Queueable;

    public $application;

    public function __construct(JobApplication $application)
    {
        $this->application = $application;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Nuova candidatura ricevuta')
            ->greeting('Ciao Admin,')
            ->line('Hai ricevuto una nuova candidatura.')
            ->line('Candidato: ' . $this->application->user->name)
            ->line('Email: ' . $this->application->user->email)
            ->line('Messaggio: ' . $this->application->message)
            ->action('Vedi candidatura', url('/admin/job-applications'))
            ->line('Accedi al pannello admin per gestire la candidatura.');
    }
}
