<?php

namespace App\Exports;

use App\Models\Company;
use App\Models\ScheduleCompany;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ScheduleCompaniesExport implements FromQuery, WithMapping, WithHeadings
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

    public function map($schedule): array
    {
        return [
            $schedule->company->name,
            $schedule->schedule->training->name,
            formatDate($schedule->schedule->date_event),
            $schedule->participants->count(),
            formatMoney($schedule->price_total),
            $schedule->schedule->status,

        ];
    }

    public function headings():array
    {
        return [
            'EMPRESA',
            'TREINAMENTO',
            'DATA',
            'PARTICIPANTES',
            'VALOR',
            'STATUS',
        ];
    }


    /**
     * @return \Illuminate\Support\Collection
     */
    public function query()
    {
        $scheduleCompanyDB = ScheduleCompany::query()->with(['schedule.training', 'schedule.location', 'schedule.room', 'schedule.first_time', 'schedule.second_time', 'company', 'participants']);

        $scheduleCompanyDB->withoutGlobalScopes();

        $scheduleCompanyDB->whereHas('schedule', function ($query) {
            $query->whereStatus('Concluído');
        });

        if($this->order) {
            $scheduleCompanyDB->orderBy($this->order['column'], $this->order['order']);
        }

        if(isset($this->filters['search']) && $this->filters['search'] != null) {
            $scheduleCompanyDB->whereHas('schedule.training', function($query) {
                $query->where('name', 'LIKE', '%'.$this->filters['search'].'%');
                $query->orWhere('acronym', 'LIKE', '%'.$this->filters['search'].'%');
            });
        }

        if(isset($this->filters['dates']) && $this->filters['dates'] != null) {
            $scheduleCompanyDB->whereHas('schedule', function($query) {
                $dates = explode(' to ', $this->filters['dates']);
                if(isset($dates[1])) {
                    $query->whereBetween('date_event', [$dates[0], $dates[1]]);
                } else {
                    $query->where('date_event', '=', $dates[0]);
                }
            });
        }

        return $scheduleCompanyDB;

    }
}
