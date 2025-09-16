<?php

namespace App\Exports;

use App\Models\ScheduleCompany;
use App\Models\ScheduleCompanyParticipants;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ScheduleCompaniesParticipantsExport implements FromQuery, WithMapping, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    protected $filters;
    protected $order;


    public function __construct($order, $filters)
    {
        $this->filters = $filters;
        $this->order = $order;
    }

    public function map($item): array
    {
        return [
            formatDate($item->schedule_company->schedule->date_event),
            $item->schedule_company->schedule->training->name,
            formatNumber($item->quantity),
            formatMoney($item->value),
            formatMoney($item->total_value),
            $item->participant->name,

        ];
    }

    public function headings():array
    {
        return [
            'DATAS',
            'SERVIÇOS',
            'QTD',
            'VALOR',
            'VALOR TOTAL',
            'PARTICIPANTE',
        ];
    }


    /**
     * @return \Illuminate\Support\Collection
     */
    public function query()
    {
        $scheduleCompanyParticipantsDB = ScheduleCompanyParticipants::query()->with([
            'schedule_company'  => fn ($query) => $query->withoutGlobalScopes(),
            'schedule_company.schedule'  => fn ($query) => $query->withoutGlobalScopes(),
            'schedule_company.schedule.training'  => fn ($query) => $query->withoutGlobalScopes(),
            'participant'=> fn ($query) => $query->withoutGlobalScopes()
        ])->where('presence', 1);

        $scheduleCompanyParticipantsDB->withoutGlobalScopes();

        $scheduleCompanyParticipantsDB->whereHas('schedule_company', function ($query) {
            $query->withoutGlobalScopes()->whereHas('schedule', function ($q){
                $q->whereStatus('Concluído');
            });
        });

        if($this->order) {
            $scheduleCompanyParticipantsDB->orderBy($this->order['column'], $this->order['order']);
        }

        if(isset($this->filters['company_id']) && $this->filters['company_id'] != null) {
            $scheduleCompanyParticipantsDB->whereHas('schedule_company', function($query) {
                $query->withoutGlobalScopes()->where('company_id', $this->filters['company_id']);
            });
        }

        if(isset($this->filters['schedule_prevat_id']) && $this->filters['schedule_prevat_id'] != null) {
            $scheduleCompanyParticipantsDB->whereHas('schedule_company', function($query) {
                $query->withoutGlobalScopes()->where('schedule_prevat_id', $this->filters['schedule_prevat_id']);
            });
        }

        if(isset($this->filters['dates']) && $this->filters['dates'] != null) {
            $scheduleCompanyParticipantsDB->whereHas('schedule_company.schedule', function($query) {
                $dates = explode(' to ', $this->filters['dates']);
                if(isset($dates[1])) {
                    $query->withoutGlobalScopes()->whereBetween('date_event', [$dates[0], $dates[1]]);
                } else {
                    $query->withoutGlobalScopes()->where('date_event', '=', $dates[0]);
                }
            });
        }

        return $scheduleCompanyParticipantsDB;

    }
}
