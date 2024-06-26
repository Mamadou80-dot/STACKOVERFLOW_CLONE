<?php
namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class UserRegistered extends Notification
{
public function __construct()
{
//
}

public function via($notifiable)
{
return ['mail'];
}

public function toMail($notifiable)
{
return (new MailMessage)
->line('Welcome to our application!')
->action('Login', url('/userlogin'))
->line('Thank you for registering!');
}
}
