<?php

namespace App\Livewire\WorkSafety\Inspection;

use App\Models\SafetyCategories;
use App\Repositories\CompanyRepository;
use App\Repositories\WorkSafety\InspectionRepository;
use App\Services\AddressService;
use App\Trait\Interactions;
use App\Trait\WithSlide;
use Livewire\Component;

class Form extends Component
{
    use Interactions, WithSlide;

    public $state = [
        'company_id' => '',
        'date' => '',
        'time' => '',
        'date_execution' => '',
        'carried_out' => '',
    ];
    public $inspection;

    public $yes;
    public $not;
    public $na;

    public function mount($id = null)
    {
        session()->forget('items');

        $inspectionsRepository = new InspectionRepository();
        $inspectionsReturnDB = $inspectionsRepository->show($id)['data'];

        if($inspectionsReturnDB) {
            $this->inspection = $inspectionsReturnDB;
            $this->state = $this->inspection->toArray();
        } else {
            $inspectionsRepository->getItemsbyInspection();
        }
    }

    public function updatedStateCompanyID()
    {
        $companyRepository = new CompanyRepository();
        $companyReturnDB = $companyRepository->show($this->state['company_id'])['data'];

        if($companyReturnDB) {
            $this->state['zip_code'] = $companyReturnDB['zip_code'];
            $this->state['address'] = $companyReturnDB['address'];
            $this->state['number'] = $companyReturnDB['number'];
            $this->state['complement'] = $companyReturnDB['complement'];
            $this->state['neighborhood'] = $companyReturnDB['neighborhood'];
            $this->state['city'] = $companyReturnDB['city'];
            $this->state['uf'] = $companyReturnDB['uf'];
        }
    }

    public function updatedYes($value, $key)
    {
        $inspectionsRepository = new InspectionRepository();
        $inspectionsRepository->validateYes($key, $value);
    }

    public function updatedNot($value, $key)
    {
        $inspectionsRepository = new InspectionRepository();
        $inspectionsRepository->validateNot($key, $value);
    }

    public function updatedNa($value, $key)
    {
        $inspectionsRepository = new InspectionRepository();
        $inspectionsRepository->validateNA($key, $value);
    }

    public function getAddress()
    {
        if(isset($this->state['zip_code'])){
            $addressService  = new AddressService();
            $addressServiceReturn = $addressService->consultCEP($this->state['zip_code']);

            if($addressServiceReturn['code'] == 200) {

                $this->sendNotificationSuccess('Sucesso', 'Endereço encontrado com sucesso !');
                $this->state['address'] = $addressServiceReturn['data']['logradouro'];
                $this->state['neighborhood'] = $addressServiceReturn['data']['bairro'];
                $this->state['city'] = $addressServiceReturn['data']['localidade'];
                $this->state['uf'] = $addressServiceReturn['data']['uf'];

            } else if($addressServiceReturn['code'] == 400) {
                $this->sendNotificationDanger($addressServiceReturn['title'], $addressServiceReturn['message']);
            }
        }
    }

    public function save()
    {
        $request = $this->state;

        if($this->inspection){
            return $this->update();
        }

        $inspectionsRepository = new InspectionRepository();
        $inspectionReturnDB = $inspectionsRepository->create($request, $this->getItemsByInspections());

        if($inspectionReturnDB['status'] == 'success') {
            return redirect()->route('work-safety.inspection.index')->with($inspectionReturnDB['status'], $inspectionReturnDB['message']);
        } else if ($inspectionReturnDB['status'] == 'error') {
            return redirect()->back()->with($inspectionReturnDB['status'], $inspectionReturnDB['message']);
        }
    }

    public function update()
    {
        $request = $this->state;

        $inspectionsRepository = new InspectionRepository();
        $inspectionReturnDB = $inspectionsRepository->update($request, $this->inspection->id, $this->getItemsByInspections());

        if($inspectionReturnDB['status'] == 'success') {
            return redirect()->route('work-safety.inspection.index')->with($inspectionReturnDB['status'], $inspectionReturnDB['message']);
        } else if ($inspectionReturnDB['status'] == 'error') {
            return redirect()->back()->with($inspectionReturnDB['status'], $inspectionReturnDB['message']);
        }
    }

    public function getSelectCompanies()
    {
        $companiesRepository = new CompanyRepository();
        return $companiesRepository->getSelectCompany();
    }

    public function getItemsByInspections()
    {
        $items = session()->get('items');

        if($items) {
            foreach ($items as $key => $item) {
                $this->yes[$key] = $itemItem['yes'] ?? 0;
                $this->not[$key] = $itemItem['not'] ?? 0;
            }
        }

        return $items;
    }

    public function getCategoryItems()
    {
        return SafetyCategories::query()->get();
    }

    public function render()
    {
        $response = new \stdClass();
        $response->companies = $this->getSelectCompanies();
        $response->categories = $this->getCategoryItems();
        $response->items = $this->getItemsByInspections();

        return view('livewire.work-safety.inspection.form', ['response' => $response]);
    }
}
