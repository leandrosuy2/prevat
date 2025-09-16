<?php

namespace App\Exports;

use App\Models\TrainingParticipants;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TrainingParticipantsExport implements FromQuery, WithMapping, WithHeadings
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
            $training->participant_name,
            $training->taxpayer_registration,
            $training->training_name,
            formatDate($training->date_event),
            $training->company_name,
            $training->contract ?? '',
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
        $query = TrainingParticipants::query()
            ->select([
                'training_participants.*',
                'participants.name as participant_name',
                'participants.taxpayer_registration',
                'trainings.name as training_name',
                'schedule_prevats.date_event',
                'companies.name as company_name',
                'companies_contracts.contract'
            ])
            ->join('training_participations', 'training_participants.training_participation_id', '=', 'training_participations.id')
            ->join('schedule_prevats', 'training_participations.schedule_prevat_id', '=', 'schedule_prevats.id')
            ->join('trainings', 'schedule_prevats.training_id', '=', 'trainings.id')
            ->join('participants', 'training_participants.participant_id', '=', 'participants.id')
            ->join('companies', 'training_participants.company_id', '=', 'companies.id')
            ->leftJoin('companies_contracts', 'training_participants.contract_id', '=', 'companies_contracts.id');

        if($this->order) {
            $query->orderBy($this->order['column'], $this->order['order']);
        }

        if(isset($this->filters['company']) && $this->filters['company'] != null) {
            $query->where(function($q) {
                $q->where('companies.name', 'LIKE', '%'.$this->filters['company'].'%')
                    ->orWhere('companies.fantasy_name', 'LIKE', '%'.$this->filters['company'].'%');
            });
        }

        if(Auth::user()->company->type == 'contractor') {
            $query->where('companies_contracts.contractor_id', Auth::user()->company->id);
        }

        if(isset($this->filters['presence']) && $this->filters['presence'] != null) {
            $query->where('training_participants.presence', $this->filters['presence']);
        }

        if(isset($this->filters['dates']) && $this->filters['dates'] != null) {
            $dates = explode(' to ', $this->filters['dates']);
            if(isset($dates[1])) {
                $query->whereBetween('schedule_prevats.date_event', [$dates[0], $dates[1]]);
            } else {
                $query->where('schedule_prevats.date_event', '=', $dates[0]);
            }
        }

        if(isset($this->filters['search']) && $this->filters['search'] != null) {
            $search = $this->filters['search'];
            $query->where(function($q) use ($search) {
                $q->where('trainings.name', 'LIKE', '%'.$search.'%')
                    ->orWhere('participants.name', 'LIKE', '%'.$search.'%')
                    ->orWhere('participants.taxpayer_registration', 'LIKE', '%'.$search.'%');
            });
        }

        if(Auth::user()->company->type == 'client') {
            $query->where('training_participants.company_id', Auth::user()->company_id)
                ->where('training_participants.contract_id', Auth::user()->contract_id);
        }

        return $query;
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}
