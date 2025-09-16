<?php

namespace App\Livewire\Financial\PaymentMethod;

use App\Repositories\Financial\PaymentMethodRepository;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Table extends Component
{
    use WithPagination;

    public $order = [
        'column' => 'name',
        'order' => 'ASC'
    ];

    public $filters;

    public $pageSize = 15;

    #[On('filterTablePaymentMethod')]
    public function filterTablePaymentMethod($filterData = null)
    {
        $this->filters = $filterData;
    }

    #[On('clearFilter')]
    public function clearFilter($visible = null)
    {
        $this->filters = null;
    }

    #[On('getPaymentMethods')]
    public function getPaymentMethods()
    {
        $paymentMethodRepository = new PaymentMethodRepository();
        $paymentMethodReturnDB = $paymentMethodRepository->index($this->order, $this->filters, $this->pageSize)['data'];

        return $paymentMethodReturnDB;
    }

    #[On('confirmDeletePaymentMethod')]
    public function delete($id = null)
    {
        $paymentMethodRepository = new PaymentMethodRepository();
        $paymentMethodReturnDB = $paymentMethodRepository->delete($id);

        if($paymentMethodReturnDB['status'] == 'success') {
            return redirect()->route('financial.payment-method')->with($paymentMethodReturnDB['status'], $paymentMethodReturnDB['message']);
        } else if ($paymentMethodReturnDB['status'] == 'error') {
            return redirect()->route('financial.payment-method')->with($paymentMethodReturnDB['status'], $paymentMethodReturnDB['message']);
        }
    }

    public function render()
    {
        $response = new \stdClass();
        $response->paymentMethods = $this->getPaymentMethods();

        return view('livewire.financial.payment-method.table', ['response' => $response]);
    }
}
