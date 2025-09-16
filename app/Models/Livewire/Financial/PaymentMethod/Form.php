<?php

namespace App\Livewire\Financial\PaymentMethod;

use App\Repositories\Financial\PaymentMethodRepository;
use Livewire\Component;

class Form extends Component
{
    public $state = [
        'status' => '',
    ];

    public $paymentMethod;

    public function mount($id = null)
    {
        $paymentMethodRepository = new PaymentMethodRepository();
        $paymentMethodReturnDB = $paymentMethodRepository->show($id)['data'];
        $this->paymentMethod = $paymentMethodReturnDB;

        if($this->paymentMethod){
            $this->state = $this->paymentMethod->toArray();
        }
    }

    public function save()
    {
        if($this->paymentMethod){
            return $this->update();
        }

        $request = $this->state;

        $paymentMethodRepository = new PaymentMethodRepository();
        $paymentMethodReturnDB = $paymentMethodRepository->create($request);

        if($paymentMethodReturnDB['status'] == 'success') {
            return redirect()->route('financial.payment-method')->with($paymentMethodReturnDB['status'], $paymentMethodReturnDB['message']);
        } else if ($paymentMethodReturnDB['status'] == 'error') {
            return redirect()->route('financial.payment-method')->with($paymentMethodReturnDB['status'], $paymentMethodReturnDB['message']);
        }
    }

    public function update()
    {
        $request = $this->state;
        $paymentMethodRepository = new PaymentMethodRepository();

        $paymentMethodReturnDB = $paymentMethodRepository->update($request, $this->paymentMethod->id);

        if($paymentMethodReturnDB['status'] == 'success') {
            return redirect()->route('financial.payment-method')->with($paymentMethodReturnDB['status'], $paymentMethodReturnDB['message']);
        } else if ($paymentMethodReturnDB['status'] == 'error') {
            return redirect()->route('financial.payment-method')->with($paymentMethodReturnDB['status'], $paymentMethodReturnDB['message']);
        }
    }

    public function render()
    {
        return view('livewire.financial.payment-method.form');
    }
}
