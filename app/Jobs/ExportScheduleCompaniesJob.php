<?php

namespace App\Jobs;

use App\Exports\CompaniesExport;
use App\Exports\ScheduleCompaniesExport;
use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class ExportScheduleCompaniesJob implements ShouldQueue
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
        Excel::store(new ScheduleCompaniesExport($this->order, $this->filters), 'relatorios/financeiro.xlsx', 'public');
    }
}
