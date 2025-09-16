<?php

namespace App\Repositories\Movements;

use App\Models\EvidenceParticipation;
use Illuminate\Support\Facades\Auth;
use PHPUnit\Exception;

class EvidenceParticipantsRepository
{
    public function index($evidence_id = null, $company_id = null)
    {
        try {
            $evidenceParticipationsDB = EvidenceParticipation::query()->with([
                'evidence' ,
                'participant' => fn ($query) => $query->withoutGlobalScopes(),
                'participant.role' => fn ($query) => $query->withoutGlobalScopes(),
            ]);

            if(Auth::user()->company->type == 'client') {
                $evidenceParticipationsDB->whereHas('participant', function($query) {
                    $query->where('company_id', Auth::user()->company->id);
                });
            }

//            if(Auth::user()->company->type == 'admin') {
//                $evidenceParticipationsDB->whereHas('evidence', function($query) use ($company_id) {
//                    $query->withoutGlobalScopes()->where('company_id', $company_id);
//                });
//            }

            if($evidence_id)  {
                $evidenceParticipationsDB->where('evidence_id', $evidence_id);
            }

            $evidenceParticipationsDB = $evidenceParticipationsDB->get();
//            dd($evidenceParticipationsDB);
            return [
                'status' => 'success',
                'data' => $evidenceParticipationsDB,
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
