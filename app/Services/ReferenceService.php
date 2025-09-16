<?php

namespace App\Services;
use DateTime;
class ReferenceService
{
    public function getReference()
    {
        $agora = new DateTime();
        $reference = $random = time() . rand(10*45, 100*98);

        return $reference;
    }

}
