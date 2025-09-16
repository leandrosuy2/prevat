<?php

namespace App\Repositories\Financial;

use App\Models\PaymentMethod;
use App\Requests\PaymentMethodRequest;
use Illuminate\Support\Facades\DB;
use PHPUnit\Exception;

class PaymentMethodRepository
{
    public function index($orderBy, $filterData, $pageSize)
    {
        try {
            $paymentMethodDB = PaymentMethod::query();

            if(isset($filterData['search']) && $filterData['search'] != null) {
                $paymentMethodDB->where('name', 'LIKE', '%'.$filterData['search'].'%');
            }

            if(isset($filterData['status']) && $filterData['status'] != null) {
                $paymentMethodDB->where('status', $filterData['status']);
            }

            if($orderBy) {
                $paymentMethodDB->orderBy($orderBy['column'], $orderBy['order']);
            }

            if($pageSize){
                $paymentMethodDB = $paymentMethodDB->paginate($pageSize);
            } else {
                $paymentMethodDB = $paymentMethodDB->get();
            }


            return [
                'status' => 'success',
                'data' => $paymentMethodDB,
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
        $paymentMethodRequest = new PaymentMethodRequest();
        $requestValidated = $paymentMethodRequest->validate($request);

        try {
            DB::beginTransaction();

            $paymentMethodDB = PaymentMethod::query()->create($requestValidated);

            DB::commit();
            return [
                'status' => 'success',
                'data' => $paymentMethodDB,
                'code' => 200,
                'message' => 'Tipo de pagamento cadastrado com sucesso !'
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
        $paymentMethodRequest = new PaymentMethodRequest();
        $requestValidated = $paymentMethodRequest->validate($request, $id);

        try {
            DB::beginTransaction();

            $paymentMethodDB = PaymentMethod::query()->findOrFail($id);
            $paymentMethodDB->update($requestValidated);

            DB::commit();
            return [
                'status' => 'success',
                'data' => $paymentMethodDB,
                'code' => 200,
                'message' => 'Tipo de pagamento atualizado com sucesso !'
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
            $paymentMethodDB = PaymentMethod::query()->find($id);

            return [
                'status' => 'success',
                'data' => $paymentMethodDB,
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

            $paymentMethodDB = PaymentMethod::query()->findOrFail($id);

            $paymentMethodDB->delete();

            DB::commit();
            return [
                'status' => 'success',
                'data' => $paymentMethodDB,
                'code' => 200,
                'message' => 'Tipo de pagamento deletado com sucesso !'
            ];

        } catch (\Exception $exception) {
            return [
                'status' => 'error',
                'code' => 400,
                'message' => 'Erro ao deletar'
            ];
        }
    }
    public function getSelectPaymentMethod()
    {
        $paymentMethodDB = PaymentMethod::query()->orderBy('name', 'ASC')->whereStatus('Ativo')->get();

        $return = [];

        foreach ($paymentMethodDB as $key => $itemPaymentMethod) {
            $return[0]['label'] = 'Escolha';
            $return[0]['value'] = '';
            $return[$key + 1]['label'] = $itemPaymentMethod['name'];
            $return[$key + 1]['value'] = $itemPaymentMethod['id'];
        }

        return $return;
    }
}
