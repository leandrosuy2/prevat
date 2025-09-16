<?php

namespace App\Trait;

trait WithSlide
{
    public function openSlide($blade = null, $params = null)
    {
        $this->dispatch('openSlide', blade:$blade, params:$params);
    }

    public function closeSlide()
    {
        $this->dispatch('closeSlide');
    }

    public function openModal($blade = null, $params = null)
    {
        $this->dispatch('openModal', blade:$blade, params:$params);
    }

    public function closeModal()
    {
        $this->dispatch('closeModal');
    }

    public function openSmallModal($blade = null, $params = null)
    {
        $this->dispatch('openSmallModal', blade:$blade, params:$params);
    }

    public function closeSmallModal()
    {
        $this->dispatch('closeSmallModal');
    }

    public function openConfirmDeleteModal($title, $pharse, $id, $action)
    {
        $this->dispatch('openConfirmDeleteModal', title:$title, pharse:$pharse, id:$id, action:$action);
    }
    public function closeConfirmDeleteModal()
    {
        $this->dispatch('closeConfirmDeleteModal');
    }

}
