<?php

namespace App\Trait;

trait Interactions
{
    public function showToast($title, $phrase)
    {
        $this->dispatch('showToast', title:$title, phrase:$phrase);
    }

    public function sendNotificationSuccess($title, $phrase)
    {
        $this->dispatch('notificationSuccess', title:$title, phrase:$phrase);
    }

    public function sendNotificationDanger($title, $phrase)
    {
        $this->dispatch('notificationError', title:$title, phrase:$phrase);
    }
}

