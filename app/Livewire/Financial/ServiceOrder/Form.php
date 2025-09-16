<?php

namespace App\Livewire\Financial\ServiceOrder;

use App\Repositories\CompanyContractRepository;
use App\Repositories\CompanyRepository;
use App\Repositories\Financial\PaymentMethodRepository;
use App\Repositories\Financial\ServiceOrderRepository;
use App\Repositories\ScheduleCompanyRepository;
use App\Trait\Interactions;
use App\Trait\WithSlide;
use Illuminate\Support\Collection;
use Livewire\Attributes\On;
use Livewire\Component;

class Form extends Component
{
    use Interactions, WithSlide;

    public Collection $releases;

    public $state = [
        'company_id' => '',
        'payment_method_id' => '',
        'contract_id' => '',
        'type' => ''
    ];

    public $serviceOrder;

    public function mount($id = null)
    {
        $serviceOrderRepository = new ServiceOrderRepository();
        $serviceOrderReturnDB = $serviceOrderRepository->show($id)['data'];
        $this->serviceOrder = $serviceOrderReturnDB;

        if($this->serviceOrder){
            $this->state = $this->serviceOrder->toArray();
        }

        $this->fill([
            'releases' => collect([]),
        ]);
    }

    public function updatedStateCompanyID()
    {
        $this->state['contract_id'] = '';
    }

    #[On('addRelease')]
    public function addRelease($release_id = null)
    {
        $scheduleCompanyRepository = new ScheduleCompanyRepository();
        $serviceOrderReturnDB = $scheduleCompanyRepository->show($release_id)['data'];

        $this->releases->push([
            'id' => $serviceOrderReturnDB['id'],
            'reference' => $serviceOrderReturnDB['reference'],
            'company' => $serviceOrderReturnDB['company']['name'] ?? $serviceOrderReturnDB['company']['fantasy_name'],
            'training' => $serviceOrderReturnDB['schedule']['training']['name'],
            'date_event' => formatDate($serviceOrderReturnDB['schedule']['date_event']),
            'present' => $serviceOrderReturnDB['participantsPresent']->count(),
            'ausent' => $serviceOrderReturnDB['participantsAusent']->count(),
            'price' => $serviceOrderReturnDB['schedule']['training']['value'],
            'price_total' => $serviceOrderReturnDB['price_total'],
            'status' => $serviceOrderReturnDB['status'],
        ]);
    }

    #[On('addSelectionsRelease')]
    public function addSelectionsRelease($releases = null)
    {
        foreach ($releases as $release_id) {;
            $scheduleCompanyRepository = new ScheduleCompanyRepository();
            $serviceOrderReturnDB = $scheduleCompanyRepository->show($release_id)['data'];

            if($releases){
                $this->releases->push([
                    'id' => $serviceOrderReturnDB['id'],
                    'reference' => $serviceOrderReturnDB['reference'],
                    'company' => $serviceOrderReturnDB['company']['name'] ?? $serviceOrderReturnDB['company']['fantasy_name'],
                    'training' => $serviceOrderReturnDB['schedule']['training']['name'],
                    'date_event' => formatDate($serviceOrderReturnDB['schedule']['date_event']),
                    'present' => $serviceOrderReturnDB['participantsPresent']->count(),
                    'ausent' => $serviceOrderReturnDB['participantsAusent']->count(),
                    'price' => $serviceOrderReturnDB['schedule']['training']['value'],
                    'price_total' => $serviceOrderReturnDB['price_total'],
                    'status' => $serviceOrderReturnDB['status'],
                ]);
            }

        }
    }

    public function remRelease($key)
    {
        $this->releases->pull($key);
    }

    public function getSelectCompanies()
    {
        $companyRepository = new CompanyRepository();
        return $companyRepository->getSelectCompany();
    }

    public function getContratsByCompany()
    {
        $companyContractsRepository = new CompanyContractRepository();
        return $companyContractsRepository->getSelectContracts($this->state['company_id']);
    }

    public function getSelectPaymentMethods()
    {
        $paymentMethodRepository = new PaymentMethodRepository();
        return $paymentMethodRepository->getSelectPaymentMethod();
    }

    public function save()
    {
        if($this->serviceOrder){
            return $this->update();
        }

        $request = $this->state;
        $serviceOrderRepository = new ServiceOrderRepository();
        $serviceOrderReturnDB = $serviceOrderRepository->create($request, $this->releases);

        if($serviceOrderReturnDB['status'] == 'success') {
            return redirect()->route('financial.service-order')->with($serviceOrderReturnDB['status'], $serviceOrderReturnDB['message']);
        } else if ($serviceOrderReturnDB['status'] == 'error') {
            return redirect()->back()->with($serviceOrderReturnDB['status'], $serviceOrderReturnDB['message']);
        }
    }

    public function update()
    {
        $request = $this->state;

        $serviceOrderRepository = new ServiceOrderRepository();
        $serviceOrderReturnDB = $serviceOrderRepository->update($this->serviceOrder->id, $request, $this->releases, $this->participantsDelete);

        if($serviceOrderReturnDB['status'] == 'success') {
            return redirect()->route('financial.service-order')->with($serviceOrderReturnDB['status'], $serviceOrderReturnDB['message']);
        } else if ($serviceOrderReturnDB['status'] == 'error') {
            return redirect()->back()->with($serviceOrderReturnDB['status'], $serviceOrderReturnDB['message']);
        }
    }

    public function render()
    {
        $response = new \stdClass();
        $response->companies = $this->getSelectCompanies();
        $response->paymentMethods = $this->getSelectPaymentMethods();
        $response->contracts = $this->getContratsByCompany();

        return view('livewire.financial.service-order.form', ['response' => $response]);
    }
}
