<?php

namespace App\Jobs;

use App\Exports\TrainingParticipantsExport;
use App\Exports\TrainingsExport;
use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class ExportTrainingParticipantsJob implements ShouldQueue
{
    use Batchable, Queueable;

    public $filters;
    public $order;

    /**
     * Create a new job instance.
     */
    public function __construct($orderBy, $filterData)
    {
        $this->order = $orderBy;
        $this->filters = $filterData;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Storage::disk('public')->makeDirectory('relatorios');

        Excel::store(new TrainingParticipantsExport($this->order, $this->filters), 'relatorios/relatorio_treinamento_participantes.xlsx', 'public');
    }
}
