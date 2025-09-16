<?php

namespace App\Repositories;

use App\Models\Countries;
use App\Requests\CountryRequest;
use Illuminate\Support\Facades\DB;
use PHPUnit\Exception;
class CountryRepository
{
    public function index($orderBy)
    {
        try {
            $countryDB = Countries::query();

            $countryDB->orderBy($orderBy['column'], $orderBy['order']);

            $countryDB = $countryDB->get();

            return [
                'status' => 'success',
                'data' => $countryDB,
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
        $countryRequest = new CountryRequest();
        $requestValidated = $countryRequest->validate($request);

        try {
            DB::beginTransaction();

            $countryDB = Countries::query()->create($requestValidated);

            DB::commit();
            return [
                'status' => 'success',
                'data' => $countryDB,
                'code' => 200,
                'message' => 'Município cadastrado com sucesso !'
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
        $countryRequest = new CountryRequest();
        $requestValidated = $countryRequest->validate($request, $id);

        try {
            DB::beginTransaction();

            $countryDB = Countries::query()->findOrFail($id);
            $countryDB->update($requestValidated);

            DB::commit();
            return [
                'status' => 'success',
                'data' => $countryDB,
                'code' => 200,
                'message' => 'Município atualizado com sucesso !'
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
            $countryDB = Countries::query()->find($id);

            return [
                'status' => 'success',
                'data' => $countryDB,
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

            $countryDB = Countries::query()->findOrFail($id);
            $countryDB->delete();

            DB::commit();
            return [
                'status' => 'success',
                'data' => $countryDB,
                'code' => 200,
                'message' => 'Município deletado com sucesso !'
            ];

        } catch (\Exception $exception) {
            return [
                'status' => 'error',
                'code' => 400,
                'message' => 'Erro ao deletar'
            ];
        }
    }

    public function getSelectCountries()
    {
        $countryDB = Countries::query()->whereStatus('Ativo')->orderBy('city', 'ASC')->get();

        $return = [];

        foreach ($countryDB as $key => $itemCountry) {
            $return[0]['label'] = 'Escolha';
            $return[0]['value'] = '';
            $return[$key + 1]['label'] = $itemCountry['city']. '-' . $itemCountry['uf'];
            $return[$key + 1]['value'] = $itemCountry['id'];
        }

        return $return;
    }

}
