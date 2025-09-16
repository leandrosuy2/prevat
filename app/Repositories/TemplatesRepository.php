<?php

namespace App\Repositories;

use App\Models\TemplateCertifications;

class TemplatesRepository
{
    public function getSelectTemplates()
    {
        $templateCertificationsDB = TemplateCertifications::query()->orderBy('name', 'ASC')->get();

        $return = [];

        foreach ($templateCertificationsDB as $key => $itemCertificate) {
            $return[0]['label'] = 'Escolha';
            $return[0]['value'] = '';
            $return[$key + 1]['label'] = $itemCertificate['name'];
            $return[$key + 1]['value'] = $itemCertificate['id'];
        }

        return $return;
    }
}
