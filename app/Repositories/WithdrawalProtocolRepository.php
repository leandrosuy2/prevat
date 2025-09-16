<?php

namespace App\Repositories;

use App\Models\WithTrawalProtocol;
use App\Requests\WithdrawalProtocolRequest;
use App\Services\ReferenceService;
use Illuminate\Support\Facades\DB;
use PHPUnit\Exception;

class WithdrawalProtocolRepository
{
    public function index($orderBy, $filterData = null, $pageSize = null)
    {
        try {
            $withdrawalProtocolDB = WithTrawalProtocol::query()->with(['training_participation.schedule_prevat', 'company', 'contract']);

            $withdrawalProtocolDB->orderBy($orderBy['column'], $orderBy['order']);

            if(isset($filterData['search']) && $filterData['search'] != null) {
                $withdrawalProtocolDB->whereHas('training_participation.schedule_prevat.training', function($query) use ($filterData){
                    $query->where('name', 'LIKE', '%'.$filterData['search'].'%');
                    $query->orWhere('acronym', 'LIKE', '%'.$filterData['search'].'%');
                });
                $withdrawalProtocolDB->orWhereHas('company', function($query) use ($filterData){
                    $query->where('name', 'LIKE', '%'.$filterData['search'].'%');
                    $query->orWhere('fantasy_name', 'LIKE', '%'.$filterData['search'].'%');
                    $query->orWhere('employer_number', 'LIKE', '%'.$filterData['search'].'%');
                });
            }

            if(isset($filterData['date_start']) && $filterData['date_start'] != null) {
                $withdrawalProtocolDB->whereDate('created_at', '>=', $filterData['date_start']);
            }

            if(isset($filterData['date_end']) && $filterData['date_end'] != null) {
                $withdrawalProtocolDB->whereDate( 'created_at', '<=', $filterData['date_end']);
            }

            if($pageSize) {
                $withdrawalProtocolDB = $withdrawalProtocolDB->paginate($pageSize);
            } else {
                $withdrawalProtocolDB = $withdrawalProtocolDB->get();
            }

            return [
                'status' => 'success',
                'data' => $withdrawalProtocolDB,
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

    public function create($request)
    {
        $withdrawalProtocolRequest = new WithdrawalProtocolRequest();
        $requestValidated = $withdrawalProtocolRequest->validate($request);

        try {
            DB::beginTransaction();

            $referenceService = new ReferenceService();
            $reference = $referenceService->getReference();
            $requestValidated['reference'] = $reference;

            $withdrawalProtocolDB = WithTrawalProtocol::query()->create($requestValidated);

            DB::commit();
            return [
                'status' => 'success',
                'data' => $withdrawalProtocolDB,
                'code' => 200,
                'message' => 'Protocolo de Retirada cadastrado com sucesso !'
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

    public function update($request, $id,)
    {
        $withdrawalProtocolRequest = new WithdrawalProtocolRequest();
        $requestValidated = $withdrawalProtocolRequest->validate($request, $id);

        try {
            DB::beginTransaction();

            $withdrawalProtocolDB = WithTrawalProtocol::query()->findOrFail($id);
            $withdrawalProtocolDB->update($requestValidated);

            DB::commit();
            return [
                'status' => 'success',
                'data' => $withdrawalProtocolDB,
                'code' => 200,
                'message' => 'Protocolo de Retidada atualizado com sucesso !'
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
            $withdrawalProtocolDB = WithTrawalProtocol::query()->find($id);

            return [
                'status' => 'success',
                'data' => $withdrawalProtocolDB,
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

            $withdrawalProtocolDB = WithTrawalProtocol::query()->findOrFail($id);
            $withdrawalProtocolDB->delete();

            DB::commit();
            return [
                'status' => 'success',
                'data' => $withdrawalProtocolDB,
                'code' => 200,
                'message' => 'Protocolo de retirada deletado com sucesso !'
            ];

        } catch (\Exception $exception) {
            return [
                'status' => 'error',
                'code' => 400,
                'message' => 'Erro ao deletar'
            ];
        }
    }

    public function getSelectWithTrawalProtocol()
    {
        $withdrawalProtocolDB = WithTrawalProtocol::query()->orderBy('id', 'ASC')->get();

        $return = [];
        $return[0]['label'] = 'Escolha';
        $return[0]['value'] = '';

        if($withdrawalProtocolDB->count() > 0) {
            foreach ($withdrawalProtocolDB as $key => $itemWithdrawal) {
                $return[$key +1]['label'] = $itemWithdrawal['name'];
                $return[$key +1]['value'] = $itemWithdrawal['id'];
            }
        } else {
            $return[0]['label'] = 'Sem Cadastro';
            $return[0]['value'] = '';
        }
        return $return;
    }


}
