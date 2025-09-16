<?php

namespace App\Exports;

use App\Models\Company;
use App\Models\ScheduleCompany;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TrainingsExport implements FromQuery, WithMapping, WithHeadings
{

    protected $filters;
    protected $order;


    public function __construct($order, $filters)
    {
        $this->filters = $filters;
        $this->order = $order;
    }

    public function map($training): array
    {
        return [
            $training->company->name,
            $training->schedule->training->name,
            formatDate($training->schedule->date_event),
            $training->participants->count(),
            $training->schedule->status,
        ];
    }
    public function headings():array
    {
        return [
            'EMPRESA',
            'TREINAMENTO',
            'DATA',
            'PARTICIPANTES',
            'STATUS',
        ];
    }


    /**
     * @return \Illuminate\Support\Collection
     */
    public function query()
    {

        $scheduleCompanyDB = ScheduleCompany::query()->with(['company','schedule.training', 'participants'])->withoutGlobalScopes();

        if(isset($this->filters['company_id']) && $this->filters['company_id'] != null) {
            $scheduleCompanyDB->where('company_id', $this->filters['company_id']);
        }

        if(isset($this->filters['dates']) && $this->filters['dates'] != null) {
                $scheduleCompanyDB->whereHas('schedule', function($query){
                    $dates = explode(' to ', $this->filters['dates']);
                    if(isset($dates[1])) {
                        $query->whereBetween('date_event', [$dates[0], $dates[1]]);
                    } else {
                        $query->where('date_event', '=', $dates[0]);
                    }
                });
            }

        if($this->order) {
            $scheduleCompanyDB->orderBy($this->order['column'], $this->order['order']);
        }

        return $scheduleCompanyDB;

    }
}
