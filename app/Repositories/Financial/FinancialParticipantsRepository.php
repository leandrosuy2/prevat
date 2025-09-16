<?php

namespace App\Repositories\Financial;

use App\Models\ScheduleCompany;
use App\Models\ScheduleCompanyParticipants;
use Illuminate\Support\Facades\DB;

class FinancialParticipantsRepository
{
    public function index($company_id = null, $orderBy = null, $filterData = null, $pageSize = null)
    {
        try {
            DB::beginTransaction();

            $scheduleCompanyParticpantsDB = ScheduleCompanyParticipants::query()->with([
                'schedule_company',
                'participant' => fn ($query) => $query->withoutGlobalScopes(),
                'participant.contract' => fn ($query) => $query->withoutGlobalScopes(),
                'participant.role' => fn ($query) => $query->withoutGlobalScopes()
            ])->where('presence', 1);

            if(isset($filterData['search']) && $filterData['search'] != null){
                $scheduleCompanyParticpantsDB->whereHas('participant', function($query) use ($filterData){
                    $query->withoutGlobalScopes()->where('name', 'LIKE', '%'.$filterData['search'].'%');
                    $query->withoutGlobalScopes()->orWhere('taxpayer_registration', 'LIKE', '%'.$filterData['search'].'%');
                });
            }

            if($orderBy) {
                $scheduleCompanyParticpantsDB->whereHas('participant', function($query) use ($orderBy){
                    $query->withoutGlobalScopes()->orderBy($orderBy['column'], $orderBy['order']);
                });
            }

            if($company_id) {
                $scheduleCompanyParticpantsDB->where('schedule_company_id', $company_id);
            }

            if($pageSize) {
                $scheduleCompanyParticpantsDB = $scheduleCompanyParticpantsDB->paginate($pageSize);
            } else {
                $scheduleCompanyParticpantsDB = $scheduleCompanyParticpantsDB->get();
            }


            DB::commit();
            return [
                'status' => 'success',
                'data' => $scheduleCompanyParticpantsDB,
                'code' => 200,
            ];

        } catch (\Exception $exception) {
            return [
                'status' => 'error',
                'code' => 400,
                'message' => 'Erro na requisição'
            ];
        }
    }

    public function calculateTotalValueByQuanity($id, $quantity, $service_order_id = null)
    {
        $scheduleCompanyParticipantsDB = ScheduleCompanyParticipants::query()->with('schedule_company')->find($id);

        $scheduleCompanyParticipantsDB->update([
            'quantity' => $quantity,
            'total_value' => $quantity * $scheduleCompanyParticipantsDB['value'],
        ]);

        $scheduleCompanyDB = ScheduleCompany::query()->with(['participants'])->withoutGlobalScopes()->findOrFail($scheduleCompanyParticipantsDB['schedule_company_id']);
        $scheduleCompanyDB->update([
            'price_total' => $scheduleCompanyDB['participants']->sum('total_value')
        ]);

        if($service_order_id) {
            $serviceOrderRepository = new ServiceOrderRepository();
            $serviceOrderRepository->calculatePrices($service_order_id);
            $serviceOrderRepository->generatePDF($service_order_id);
            $serviceOrderRepository->generateExcel($service_order_id);
        }
    }

    public function calculateTotalValueByValue($id, $value)
    {
        $scheduleCompanyParticipantsDB = ScheduleCompanyParticipants::query()->with('schedule_company')->find($id);

        $scheduleCompanyParticipantsDB->update([
            'value' => formatDecimal($value),
            'total_value' => $scheduleCompanyParticipantsDB['quanity'] * formatDecimal($value),
        ]);

        $scheduleCompanyDB = ScheduleCompany::query()->with(['participants'])->withoutGlobalScopes()->findOrFail($scheduleCompanyParticipantsDB['schedule_company_id']);
        $scheduleCompanyDB->update([
            'price_total' => $scheduleCompanyDB['participants']->sum('total_value')
        ]);
    }

}
