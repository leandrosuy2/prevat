<?php

namespace App\Exports;

use App\Models\Company;
use App\Models\TrainingParticipants;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class CompaniesExport implements FromQuery, WithMapping, WithHeadings
{
    protected $filters;
    protected $order;


    public function __construct($order, $filters)
    {
        $this->filters = $filters;
        $this->order = $order;
    }

    public function map($company): array
    {
        return [
            $company->name,
            $company->phone,
            $company->email,
            $company->employer_number,
            $company->zip_code,
            $company->address,
            $company->number,
            $company->complement,
            $company->neighborhood,
            $company->city,
            $company->uf,
            $company->status,
        ];
    }

    public function headings():array
    {
        return [
            'RAZÃO SOCIAL',
            'TELEFONE',
            'EMAIL',
            'CNPJ',
            'CEP',
            'ENDEREÇO',
            'NUMERO',
            'COMPLEMENTO',
            'BAIRRO',
            'CIDADE',
            'ESTADO',
            'STATUS',
        ];
    }


    /**
    * @return \Illuminate\Support\Collection
    */
    public function query()
    {

        $companyDB = Company::query();

        if($this->order) {
            $companyDB->orderBy($this->order['column'], $this->order['order']);
        }

        if(isset($this->filters['dates']) && $this->filters['dates'] != null) {
            $dates = explode(' to ', $this->filters['dates']);
            if(isset($dates[1])) {
                $companyDB->whereBetween('created_at', [$dates[0], $dates[1]]);
            } else {
                $companyDB->where('created_at', '=', $dates[0]);
            }
        }

        return $companyDB;

    }
}
