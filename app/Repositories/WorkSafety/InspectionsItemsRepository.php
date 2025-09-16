<?php

namespace App\Repositories\WorkSafety;

use App\Models\WorkSafety;
use App\Models\WorkSafetyItems;
use PHPUnit\Exception;

class InspectionsItemsRepository
{
    public function index($work_safety_id)
    {
        try {
        $workSafetyItems = WorkSafetyItems::query()->with(['worksafety', 'category', 'item']);
        $workSafetyItems->where('work_safety_id',$work_safety_id);
        $workSafetyItems = $workSafetyItems->get();

        return [
            'status' => 'success',
            'data' => $workSafetyItems,
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

    public function validateYes($item_id, $value)
    {
        $workSafetyItems = WorkSafetyItems::query()->find($item_id);
        $workSafetyItems->update([
            'yes' => $value
        ]);
    }

    public function validateNot($item_id, $value)
    {
        $workSafetyItems = WorkSafetyItems::query()->find($item_id);
        $workSafetyItems->update([
            'not' => $value
        ]);
    }
    public function validateNA($item_id, $value)
    {
        $workSafetyItems = WorkSafetyItems::query()->find($item_id);
        $workSafetyItems->update([
            'na' => $value
        ]);
    }

}
