<?php

namespace App\Repositories\Manage;

use App\Models\Contacts;
use App\Requests\ContactsRequest;
use Illuminate\Support\Facades\DB;
use PHPUnit\Exception;

class ContactRepository
{
    public function index($orderBy)
    {
        try {
            $contactDB = Contacts::query();

            $contactDB->orderBy($orderBy['column'], $orderBy['order']);

            $contactDB = $contactDB->get();

            return [
                'status' => 'success',
                'data' => $contactDB,
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

    public function create($request, $image = null)
    {
        $contactRequest = new ContactsRequest();
        $requestValidated = $contactRequest->validate($request);


        try {
            DB::beginTransaction();

            $contactDB = Contacts::query()->create($requestValidated);

            DB::commit();
            return [
                'status' => 'success',
                'data' => $contactDB,
                'code' => 200,
                'message' => 'Contato cadastrado com sucesso !'
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

    public function update($request, $id, $image = null)
    {
        $contactRequest = new ContactsRequest();
        $requestValidated = $contactRequest->validate($request);
        try{
            DB::beginTransaction();

            $contactDB = Contacts::query()->findOrFail($id);

            $contactDB->update($requestValidated);

            DB::commit();
            return [
                'status' => 'success',
                'data' => $contactDB,
                'code' => 200,
                'message' => 'Contato atualizado com sucesso !'
            ];

        } catch (Exception $exception) {
            DB::rollback();
            return [
                'status' => 'error',
                'data' => $exception,
                'code' => 400,
                'message' => 'Erro ao atualizar'
            ];
        }
    }
    public function show($id)
    {
        try {
            $contactDB = Contacts::query()->find($id);

            return [
                'status' => 'success',
                'data' => $contactDB,
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

            $contactDB = Contacts::query()->findOrFail($id);

            $contactDB->delete();

            DB::commit();
            return [
                'status' => 'success',
                'data' => $contactDB,
                'code' => 200,
                'message' => 'Contato deletado com sucesso !'
            ];

        } catch (\Exception $exception) {
            return [
                'status' => 'error',
                'code' => 400,
                'message' => 'Erro ao deletar'
            ];
        }
    }
    public function getSelectContacts()
    {
        $contactDB = Contacts::query()->orderBy('name', 'ASC')->get();

        $return = [];

        foreach ($contactDB as $key => $itemContact) {
            $return[0]['label'] = 'Escolha';
            $return[0]['value'] = '';
            $return[$key + 1]['label'] = $itemContact['name'];
            $return[$key + 1]['value'] = $itemContact['id'];
        }

        return $return;
    }

}
