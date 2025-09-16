<?php

namespace App\Livewire\Movement\SchedulePrevat\Participants;

use App\Models\Participant;
use App\Models\ScheduleCompanyParticipants;
use App\Models\SchedulePrevat;
use App\Repositories\Movements\TrainingParticipantsRepository;
use App\Repositories\ParticipantRepository;
use App\Repositories\ScheduleCompanyParticipantsRepository;
use App\Repositories\SchedulePrevatRepository;
use App\Trait\Interactions;
use App\Trait\WithSlide;
use Barryvdh\DomPDF\Facade\Pdf;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;
use Neysi\DirectPrint\DirectPrint;

class Table extends Component
{
    use WithPagination, WithSlide, Interactions;

    public $schedulePrevat;

    public $order = [
        'column' => 'name',
        'direction' => 'ASC'
    ];

    public $presence = [];
    public $participant_id;

    public $filters;

    public $pageSize = 15;

    public function mount($id = null)
    {
        $schedulePrevatRepository = new SchedulePrevatRepository();
        $schedulePrevatReturnDB = $schedulePrevatRepository->show($id);

        if($schedulePrevatReturnDB) {
            $this->schedulePrevat = $schedulePrevatReturnDB['data'];
        }

    }

    #[On('filterTableParticipantsSchedulePrevat')]
    public function filterTableParticipantsSchedule($filterData = null)
    {
        $this->filters = $filterData;
    }

    public function updatedPresence($value, $key)
    {
        $scheduleCompanyRepository = new ScheduleCompanyParticipantsRepository();
        $scheduleCompanyRepository->validatePresence($this->participant_id[$key], $value);

        $this->validate([
            'presence.*' => 'sometimes',
        ]);
    }

    #[On('clearFilterParticipantsSchedulePrevat')]
    public function clearFilter($visible = null)
    {
        $this->filters = null;
    }


    #[On('getParticipantsBySchedulePrevat')]
    public function getParticipantsBySchedulePrevat()
    {
        $scheduleCompanyRepository = new ScheduleCompanyParticipantsRepository();
        $participants = $scheduleCompanyRepository->getParticipantsSchedulePrevat($this->schedulePrevat->id, $this->order, $this->filters, $this->pageSize)['data'];

        foreach ($participants as $key => $participant) {

            $this->participant_id[$key] = $participant['id'];
            $this->presence[$key] = $participant['presence'];
        }
        return $participants;
    }

    #[On('confirmDeleteParticipantInSchedule')]
    public function delete($id = null)
    {
        $scheduleCompanyRepository = new ScheduleCompanyParticipantsRepository();
        $trainingRoomReturnDB = $scheduleCompanyRepository->delete($id);

        if($trainingRoomReturnDB['status'] == 'success') {
            return redirect()->route('movement.schedule-prevat.participants', $this->schedulePrevat->id )->with($trainingRoomReturnDB['status'], $trainingRoomReturnDB['message']);
        } else if ($trainingRoomReturnDB['status'] == 'error') {
            return redirect()->route('movement.schedule-prevat.participants', $this->schedulePrevat->id)->with($trainingRoomReturnDB['status'], $trainingRoomReturnDB['message']);
        }
    }

    public function refreshPDF($schedule_prevat_id)
    {
        $participantRepository = new ParticipantRepository();
        $participantReturnDB = $participantRepository->refreshListPDF($schedule_prevat_id);

        if($participantReturnDB['status'] == 'success') {
            $this->sendNotificationSuccess('Sucesso', $participantReturnDB['message']);
        }
    }

    public function testes($shedule_company_id)
    {

        $schedulePrevatDB = SchedulePrevat::query()->with(['training'])->findOrFail($shedule_company_id);

        $scheduleCompanyParticpantsDB = ScheduleCompanyParticipants::query()->with([
            'participant' => fn ($query) => $query->withoutGlobalScopes(),
            'participant.company' => fn ($query) => $query->withoutGlobalScopes(),
            'participant.role' => fn ($query) => $query->withoutGlobalScopes()
        ]);
        $scheduleCompanyParticpantsDB->whereHas('schedule_company', function($query) use ($schedulePrevatDB){
            $query->withoutGlobalScopes()->where('schedule_prevat_id', $schedulePrevatDB['id']);
        });

        $scheduleCompanyParticpantsDB->orderBy(Participant::select('name')->whereColumn('participants.id', 'schedule_company_participants.participant_id'));

        $scheduleCompanyParticpantsDB = $scheduleCompanyParticpantsDB->get();

        $data = ['training' => $schedulePrevatDB, 'participants' => $scheduleCompanyParticpantsDB];

        $pdf = Pdf::loadView('pdf.testes', $data)->setPaper('a4', 'landscape');

        return response()->streamDownload(function() use($pdf){
            echo $pdf->stream();
        },'conteudo_programatico'.$schedulePrevatDB['training']['name'].'.pdf');

    }

    public function downloadPDF($schedule_prevat_id)
    {
        $schedulePrevatDB = SchedulePrevat::query()->findOrFail($schedule_prevat_id);

        $this->showToast('Sucesso', 'Documento Baixado com sucesso!');
        return response()->download(storage_path($schedulePrevatDB['file_presence']));
    }

    public function printPDF($schedule_prevat_id)
    {
        $printerName =  DirectPrint::getDefaultPrinter() ;
        if($printerName) {
            $schedulePrevatDB = SchedulePrevat::query()->findOrFail($schedule_prevat_id);
            $this->showToast('Sucesso', 'Documento enviado para a Impressora'.$printerName);
            return DirectPrint::printFile(storage_path($schedulePrevatDB['file_presence']));
        } else {
            $this->showToast('Erro !', 'Você nao tem uma impressora padrão definda, defina uma impressora padrão.');
        }
    }


    public function render()
    {
        $response = new \stdClass();
        $response->participants = $this->getParticipantsBySchedulePrevat();

        return view('livewire.movement.schedule-prevat.participants.table', ['response' => $response]);
    }
}
