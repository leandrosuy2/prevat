<?php

namespace App\Repositories\Financial;

use App\Models\PaymentMethod;
use App\Models\ServiceOrderStatus;

class ServiceOrderStatusRepository
{
    public function getSelectServiceOrderStatus()
    {
        $serviceOrderStatusDB = ServiceOrderStatus::query()->orderBy('id', 'ASC')->whereStatus('Ativo')->get();

        $return = [];

        foreach ($serviceOrderStatusDB as $key => $itemStatus) {
            $return[0]['label'] = 'Escolha';
            $return[0]['value'] = '';
            $return[$key + 1]['label'] = $itemStatus['name'];
            $return[$key + 1]['value'] = $itemStatus['id'];
        }

        return $return;
    }
}
