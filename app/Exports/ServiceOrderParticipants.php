<?php

namespace App\Exports;

use App\Models\ScheduleCompanyParticipants;
use App\Models\ServiceOrdersItems;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ServiceOrderParticipants implements FromQuery, WithMapping, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    protected $service_order_id;



    public function __construct($service_order_id)
    {
        $this->service_order_id = $service_order_id;
    }

    public function map($item): array
    {
        return [
            $item->participant->name,
            $item->participant->taxpayer_registration,
            $item->schedule_company->schedule->training->name,
            formatDate($item->schedule_company->schedule->date_event),
            formatNumber($item->quantity),
            formatMoney($item->value),
            formatMoney($item->total_value),
        ];
    }

    public function headings():array
    {
        return [
            'NOME',
            'DOCUMENTO',
            'TREINAMENTO',
            'DATA',
            'QUANTIDADE',
            'VALOR',
            'VALOR TOTAL',
        ];
    }


    /**
     * @return \Illuminate\Support\Collection
     */
    public function query()
    {
        $serviceOrderItemsDB = ServiceOrdersItems::query()->where('service_order_id', $this->service_order_id)->withoutGlobalScopes()->pluck('schedule_company_id');

        $scheduleCompanyParticipantsDB = ScheduleCompanyParticipants::query()->with([
            'schedule_company' => fn ($query) => $query->withoutGlobalScopes(),
            'schedule_company.schedule.training'=> fn ($query) => $query->withoutGlobalScopes(),
            'participant' => fn ($query) => $query->withoutGlobalScopes(),
            'participant.contract' => fn ($query) => $query->withoutGlobalScopes(),
            'participant.role' => fn ($query) => $query->withoutGlobalScopes()
        ]);

        $scheduleCompanyParticipantsDB->whereIn('schedule_company_id', $serviceOrderItemsDB);
        $scheduleCompanyParticipantsDB->where('presence', 1);

        return $scheduleCompanyParticipantsDB;

    }
}
