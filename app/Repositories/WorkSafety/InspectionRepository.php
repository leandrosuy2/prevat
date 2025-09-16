<?php

namespace App\Repositories\WorkSafety;

use App\Models\SafetyCategories;
use App\Models\SafetyItems;
use App\Models\WorkSafety;
use App\Models\WorkSafetyItems;
use App\Requests\InspectionRequest;
use App\Services\ReferenceService;
use Illuminate\Support\Facades\DB;
use PHPUnit\Exception;

class InspectionRepository
{
    public function index($orderBy, $filterData, $pageSize)
    {
        try {
            $workSafetyDB = WorkSafety::query()->with(['company']);

            $workSafetyDB->orderBy($orderBy['column'], $orderBy['order']);

            if(isset($filterData['search']) && $filterData['search'] != null) {
                $workSafetyDB->whereHas('company', function($query) use ($filterData){
                    $query->where('name', 'LIKE', '%'.$filterData['search'].'%');
                    $query->orWhere('fantasy_name', 'LIKE', '%'.$filterData['search'].'%');
                });
            }

            if(isset($filterData['dates']) && $filterData['dates'] != null) {
                $dates = explode(' to ', $filterData['dates']);
                if(isset($dates[1])) {
                    $workSafetyDB->whereBetween('date', [$dates[0], $dates[1]]);
                } else {
                    $workSafetyDB->where('date', '=', $dates[0]);
                }
            }

            if($pageSize) {
                $workSafetyDB = $workSafetyDB->paginate($pageSize);
            } else {
                $workSafetyDB = $workSafetyDB->get();
            }

            return [
                'status' => 'success',
                'data' => $workSafetyDB,
                'code' => 200
            ];

        } catch (Exception $exception) {
            return [
                'status' => 'error',
                'code' => 400,
                'message' => 'Erro ao Indexar'
            ];
        }
    }

    public function create($request, $items)
    {
        $inspectionRequest = new InspectionRequest();
        $requestValidated = $inspectionRequest->validate($request);

        $referenceService = new ReferenceService();
        $requestValidated['reference'] = $referenceService->getReference();

        try {
            DB::beginTransaction();

            $workSafetyDB = WorkSafety::query()->create($requestValidated);

            foreach($items as $item) {
                WorkSafetyItems::query()->create([
                    'work_safety_id' => $workSafetyDB['id'],
                    'safety_item_id' => $item['id'],
                    'safety_category_id' => $item['category_id'],
                    'responsible_plan' => $item['responsible_plan'],
                    'action_plan' => $item['action_plan'],
                    'date_execution' => $item['date_execution'],
                    'yes' => $item['yes'],
                    'not' => $item['not'],
                    'na' => $item['na']
                ]);
            }

            session()->forget('items');

            DB::commit();
            return [
                'status' => 'success',
                'data' => $workSafetyDB,
                'code' => 200,
                'message' => 'Inspeção cadastrada com sucesso !'
            ];

        } catch (Exception $exception){
            DB::rollback();
            return [
                'status' => 'error',
                'data' => $exception,
                'code' => 400,
                'message' => 'Erro ao Cadastrar'
            ];
        }
    }

    public function update($request, $id)
    {
        $inspectionRequest = new InspectionRequest();
        $requestValidated = $inspectionRequest->validate($request);

        try {
            DB::beginTransaction();

            $countryDB = WorkSafety::query()->findOrFail($id);
            $countryDB->update($requestValidated);

            DB::commit();
            return [
                'status' => 'success',
                'data' => $countryDB,
                'code' => 200,
                'message' => 'Inspeção atualizada com sucesso !'
            ];

        }catch (\Exception $exception) {
            DB::rollback();
            return [
                'status' => 'error',
                'code' => 400,
                'message' => 'Erro ao Atualizar'
            ];
        }
    }

    public function show($id)
    {
        try {
            $workSafetyDB = WorkSafety::query()->find($id);

            return [
                'status' => 'success',
                'data' => $workSafetyDB,
                'code' => 200,

            ];
        }catch (Exception $exception){
            return [
                'status' => 'error',
                'code' => 400,
                'message' => 'Erro na requisição'
            ];
        }
    }

    public function delete($id = null)
    {
        try {
            DB::beginTransaction();

            $workSafetyDB = WorkSafety::query()->findOrFail($id);
            $workSafetyDB->delete();

            DB::commit();
            return [
                'status' => 'success',
                'data' => $workSafetyDB,
                'code' => 200,
                'message' => 'Inspeção deletada com sucesso !'
            ];

        } catch (\Exception $exception) {
            return [
                'status' => 'error',
                'code' => 400,
                'message' => 'Erro ao deletar'
            ];
        }
    }
    public function getItemsbyInspection($schedule_prevat_id = null)
    {
        $safetyItemsDB = SafetyItems::query()->with('category')->whereStatus('Ativo')->get();

        $return = [];

        foreach ($safetyItemsDB as $key => $item) {

            $return[$key] = [
                "id" => $item['id'],
                "category_id" => $item['category_id'],
                "name" => $item['name'],
                'responsible_plan' => $item['responsible_plan'],
                'action_plan' => $item['action_plan'],
                'date_execution' => $item['date_execution'],
                "yes" => 0,
                "not" => 0,
                "na" => 0
            ];

            session()->put('items', $return);
        }

        return $safetyItemsDB;
    }
    public function getItemsbyInspection2($schedule_prevat_id = null)
    {
        $safetyCategoriesDB = SafetyCategories::query()->with(['items'])->whereStatus('Ativo')->get();

        $return = [];

        foreach ($safetyCategoriesDB as $ssr => $itemCategory) {
            $return[$ssr]['label'] = $itemCategory['name'];
            $return[$ssr]['items'] = [];
            foreach ($itemCategory['items'] as $key => $item){
                $return[$ssr]['items'][$key]['id'] = $item['id'];
                $return[$ssr]['items'][$key]['name'] = $item['name'];
                $return[$ssr]['items'][$key]['yes'] =  $item['yes'];
                $return[$ssr]['items'][$key]['not'] =  $item['not'];
                $return[$ssr]['items'][$key]['na'] =  $item['na'];
            }

            session()->put('items', $return);
        }

        return $safetyCategoriesDB;
    }

    public function validateYes($key, $value)
    {
        if($value) {
            $yes = true;
        } else {
            $yes = false;
        }

        $items = session()->get('items');

        $items[$key]['yes'] = $yes;

        session()->put('items', $items);
    }

    public function validateNot($key, $value)
    {
        if($value) {
            $value = true;
        } else {
            $value = false;
        }

        $items = session()->get('items');

        $items[$key]['not'] = $value;

        session()->put('items', $items);
    }

    public function validateNA($key, $value)
    {
        if($value) {
            $value = true;
        } else {
            $value = false;
        }

        $items = session()->get('items');

        $items[$key]['na'] = $value;

        session()->put('items', $items);
    }

    public function createInfo($request, $key)
    {
        $inspectionRequest = new InspectionRequest();
        $requestValidated = $inspectionRequest->validateInfo($request);

        try {
            $items = session()->get('items');
            $items[$key]['responsible_plan'] = $requestValidated['responsible_plan'];
            $items[$key]['action_plan'] = $requestValidated['action_plan'];
            $items[$key]['date_execution'] = $requestValidated['date_execution'];

            session()->put('items', $items);
            return [
                'status' => 'success',
                'message' => 'informaçoes atualizada com sucesso',
                'data' => $items,
                'code' => 200,

            ];
        }catch (Exception $exception){
            return [
                'status' => 'error',
                'code' => 400,
                'message' => 'Erro na requisição'
            ];
        }



    }

    public function updateInfo($request, $id)
    {
        $inspectionRequest = new InspectionRequest();
        $requestValidated = $inspectionRequest->validateInfo($request);

        try {
            $workSafetyItemsDB = WorkSafetyItems::query()->find($id);

            $workSafetyItemsDB->update($requestValidated);

            return [
                'status' => 'success',
                'message' => 'informaçoes atualizada com sucesso',
                'data' => $workSafetyItemsDB,
                'code' => 200,

            ];
        }catch (Exception $exception){
            return [
                'status' => 'error',
                'code' => 400,
                'message' => 'Erro na requisição'
            ];
        }



    }

}
