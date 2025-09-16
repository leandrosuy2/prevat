<?php

namespace App\Repositories\Site;

use App\Models\SiteInformations;
use App\Requests\Site\InformationRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Exception;

class InfomationsRepository
{
    public function index($orderBy)
    {
        try {
            $siteInformationDB = SiteInformations::query();

            $siteInformationDB->orderBy($orderBy['column'], $orderBy['order']);

            $siteInformationDB = $siteInformationDB->get();

            return [
                'status' => 'success',
                'data' => $siteInformationDB,
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

    public function create($request, $logo = null)
    {
        $informationsRequest = new InformationRequest();
        $requestValidated = $informationsRequest->validate($request);

        if($logo != null){
            $requestValidated['logo'] = $logo->store('logo', 'public');
        }

        try {
            DB::beginTransaction();

            $siteInformationDB = SiteInformations::query()->create($requestValidated);

            DB::commit();
            return [
                'status' => 'success',
                'data' => $siteInformationDB,
                'code' => 200,
                'message' => 'Informações cadastradas com sucesso !'
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

    public function update($request, $id, $logo = null)
    {
        $informationsRequest = new InformationRequest();
        $requestValidated = $informationsRequest->validate($request, $id);

        try {
            DB::beginTransaction();

            $siteInformationDB = SiteInformations::query()->findOrFail($id);

            if(isset($logo) && $logo != $siteInformationDB->logo){
                if(Storage::exists('public/'.$siteInformationDB->logo)) {
                    Storage::delete('public/'.$siteInformationDB->logo);
                }
                $requestValidated['logo'] = $logo->store('logo', 'public');
            }

            $siteInformationDB->update($requestValidated);

            DB::commit();
            return [
                'status' => 'success',
                'data' => $siteInformationDB,
                'code' => 200,
                'message' => 'Informações atualizadas com sucesso !'
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
            $siteInformationDB = SiteInformations::query()->find($id);

            return [
                'status' => 'success',
                'data' => $siteInformationDB,
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

            $siteInformationDB = SiteInformations::query()->findOrFail($id);
            $siteInformationDB->delete();

            DB::commit();
            return [
                'status' => 'success',
                'data' => $siteInformationDB,
                'code' => 200,
                'message' => 'Informações deletadas com sucesso !'
            ];

        } catch (\Exception $exception) {
            return [
                'status' => 'error',
                'code' => 400,
                'message' => 'Erro ao deletar'
            ];
        }
    }

    public function getFirst()
    {
        try {
            $siteInformationDB = SiteInformations::query()->first();

            return [
                'status' => 'success',
                'data' => $siteInformationDB,
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
