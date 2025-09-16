<?php

namespace App\Exports;

use App\Models\TrainingParticipants;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TrainingParticipantsClientExport implements FromQuery, WithMapping, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */

//    use Exportable;

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
            $training->participant->name,
            $training->participant->taxpayer_registration,
            $training->training_participation->schedule_prevat->training->name,
            formatDate($training->training_participation->schedule_prevat->date_event),
            $training->participant->company->name,
            $training->participant->contract->contract ?? 'S/C',
            $training->presence ? 'Presente' : 'Ausente',
            $training->note ?? 'S/N',
        ];
    }

    public function headings():array
    {
        return [
            'Participante',
            'Documento',
            'Treinamento',
            'Data',
            'Empresa',
            'Cto',
            'Presença',
            'Nota',
        ];
    }

    public function query()
    {

        $trainingParticipantsDB = TrainingParticipants::query()->with([
            'training_participation.schedule_prevat.training' ,
            'participant' => fn($query) => $query->withoutGlobalScopes(),
            'participant.contract',
            'participant.role',
            'contract',
        ]);

        $trainingParticipantsDB->where('company_id', Auth::user()->company_id);
        $trainingParticipantsDB->where('contract_id', Auth::user()->contract_id);

        if(isset($this->filters['presence']) && $this->filters['presence'] != null) {
            $trainingParticipantsDB->where('presence', $this->filters['presence']);
        }

        if(isset($filterData['dates']) && $filterData['dates'] != null) {
            $trainingParticipantsDB->whereHas('training_participation.schedule_prevat', function($query) {
                $dates = explode(' to ', $this->filters['dates']);
                if(isset($dates[1])) {
                    $query->whereBetween('date_event', [$dates[0], $dates[1]]);
                } else {
                    $query->where('date_event', '=', $dates[0]);
                }
            });
        }

        if(isset($this->filters['search']) && $this->filters['search'] != null) {
            $trainingParticipantsDB->whereHas('participant', function($query) {
                $query->withoutGlobalScopes()->where('name', 'LIKE', '%'.$this->filters['search'].'%');
                $query->orWhere('taxpayer_registration', 'LIKE', '%'.$this->filters['search'].'%');
            });

            $trainingParticipantsDB->orWhereHas('training_participation.schedule_prevat.training', function ($query) {
                $query->where('name', 'LIKE', '%'.$this->filters['search'].'%');
            }) ;
        }

        $trainingParticipantsDB->where('company_id', Auth::user()->company_id);
        $trainingParticipantsDB->where('contract_id', Auth::user()->contract_id);

        if($this->order) {
            $trainingParticipantsDB->orderBy($this->order['column'], $this->order['order']);
        }

        return $trainingParticipantsDB;
    }
}
