<?php

namespace App\Repositories;

use App\Models\Instalinks_buttons;
use App\Models\Professional;
use App\Models\ProfessionalsFormation;
use App\Requests\ProfessionalRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Exception;

class ProfessionalRepository
{
    public function index($orderBy, $filterData, $pageSize)
    {
        try {
            $professionalDB = Professional::query()->with(['formations.qualification']);

            if(isset($filterData['search']) && $filterData['search'] != null) {
                $professionalDB->where('name', 'LIKE', '%'.$filterData['search'].'%');
                $professionalDB->orWhere('email', 'LIKE', '%'.$filterData['search'].'%');
                $professionalDB->orWhere('document', 'LIKE', '%'.$filterData['search'].'%');
                $professionalDB->orWhere('registry', 'LIKE', '%'.$filterData['search'].'%');
            }

            if($orderBy) {
                $professionalDB->orderBy($orderBy['column'], $orderBy['order']);
            }

            if($pageSize){
                $professionalDB = $professionalDB->paginate($pageSize);
            } else {
                $professionalDB = $professionalDB->get();
            }


            return [
                'status' => 'success',
                'data' => $professionalDB,
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

    public function create($requestValidated)
    {
        if($requestValidated['signature_image'] != null){
            $requestValidated['state']['signature_image'] = $requestValidated['signature_image']->store('signatures', 'public');
        }

        try {
            DB::beginTransaction();

            $professionalDB = Professional::query()->create($requestValidated['state']);

            foreach ($requestValidated['formations'] as $itemFormation) {
                ProfessionalsFormation::query()->create([
                    'professional_id' => $professionalDB['id'],
                    'qualification_id' => $itemFormation['qualification_id']
                ]);
            }

            DB::commit();
            return [
                'status' => 'success',
                'data' => $professionalDB,
                'code' => 200,
                'message' => 'Profissional cadastrado com sucesso !'
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

    public function update($professional_id, $requestValidated, $formationsToDelete = null)
    {
        try{
            DB::beginTransaction();

            $professionalDB = Professional::query()->findOrFail($professional_id);

            if(isset($requestValidated['signature_image']) && $requestValidated['signature_image'] != $professionalDB->signature_image){
                if(Storage::exists('public/'.$professionalDB->signature_image)) {
                    Storage::delete('public/'.$professionalDB->signature_image);
                }
                $requestValidated['state']['signature_image'] = $requestValidated['signature_image']->store('signatures', 'public');
            }

            $professionalDB->update($requestValidated['state']);

            if($formationsToDelete){
                foreach ($formationsToDelete as $key => $link) {
                    ProfessionalsFormation::query()->find($link)->delete();
                }
            }

            $linksButtonDB = [];

            if(isset($requestValidated['formations'])){
                foreach ($requestValidated['formations'] as $key => $value) {
                    $id = $requestValidated['formations'][$key]['id'] ?? false;

                    if ($id) {
                        $linksButtonDB = ProfessionalsFormation::query()->find($id)->update([
                            'qualification_id' => $requestValidated['formations'][$key]['qualification_id'],
                        ]);
                    } else {
                        $linksButtonDB = ProfessionalsFormation::query()->create([
                            'professional_id' => $professional_id,
                            'qualification_id' => $requestValidated['formations'][$key]['qualification_id'],
                        ]);
                    }
                }
            }
            DB::commit();
            return [
                'status' => 'success',
                'data' => $linksButtonDB,
                'code' => 200,
                'message' => 'Profissinal atualizado com sucesso !'
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

    public function update_old($request, $id,)
    {
        $professionalRequest = new ProfessionalRequest();
        $requestValidated = $professionalRequest->validate($request, $id);

        try {
            DB::beginTransaction();

            $professionalDB = Professional::query()->findOrFail($id);
            $professionalDB->update($requestValidated);

            DB::commit();
            return [
                'status' => 'success',
                'data' => $professionalDB,
                'code' => 200,
                'message' => 'Profissional atualizado com sucesso !'
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
            $professionalDB = Professional::query()->find($id);

            return [
                'status' => 'success',
                'data' => $professionalDB,
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

            $professionalDB = Professional::query()->findOrFail($id);

            if(Storage::exists('public/'.$professionalDB->signature_image)) {
                Storage::delete('public/'.$professionalDB->signature_image);
            }

            $professionalDB->delete();

            DB::commit();
            return [
                'status' => 'success',
                'data' => $professionalDB,
                'code' => 200,
                'message' => 'Profissional deletado com sucesso !'
            ];

        } catch (\Exception $exception) {
            return [
                'status' => 'error',
                'code' => 400,
                'message' => 'Erro ao deletar'
            ];
        }
    }
    public function getSelectProfessional()
    {
        $professionalDB = Professional::query()->orderBy('name', 'ASC')->get();

        $return = [];

        foreach ($professionalDB as $key => $itemUser) {
            $return[0]['label'] = 'Escolha';
            $return[0]['value'] = '';
            $return[$key + 1]['label'] = $itemUser['name'];
            $return[$key + 1]['value'] = $itemUser['id'];
        }

        return $return;
    }

    public function getSelecFormationByProfessional($professional_id = null)
    {
        $professionalDB = ProfessionalsFormation::query()->with(['qualification']);

        $professionalDB->whereHas('qualification', function($query) {
            $query->orderBy('name', 'ASC');
        });

        if($professional_id) {
            $professionalDB->where('professional_id', $professional_id);
            $professionalDB = $professionalDB->get();
        }

        $return = [];

        $return[0]['label'] = 'Escolha o profissional';
        $return[0]['value'] = '';
        $return[0]['professional_id'] = '';

        if($professionalDB) {
            foreach ($professionalDB as $key => $itemProfessional) {
                $return[0]['label'] = 'Escolha';
                $return[0]['value'] = '';
                $return[0]['professional_id'] = $itemProfessional['professional_id'];
                $return[$key +1]['label'] = $itemProfessional['qualification']['name'];
                $return[$key +1]['value'] = $itemProfessional['qualification_id'];
                $return[$key +1]['professional_id'] = $itemProfessional['professional_id'];
            }
        }

        return $return;
    }

    public function getProfessionalQualificationActive()
    {
        $professionalDB = Professional::query()->whereStatus('Ativo')->orderBy('name', 'ASC')->get();
        return $professionalDB;
    }

}
