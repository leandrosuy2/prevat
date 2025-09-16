<div class="col-sm-12 col-xl-5">
    <div class="card">
        <div class="card-status card-status-left bg-success br-bl-7 br-tl-7"></div>
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title fs-14">Dados de Faturamento</h3>
                <div class="gap-2 btn-group">
                    <button type="button" wire:click.prevent="openModal('financial.service-order.view.details.form', {'id' : {{$response->serviceOrder['id']}} })"  class="btn btn-warning btn-sm {{(in_array($response->serviceOrder['status_id'], ['3','4'])  ? 'disabled' : '')}}"  ><i class="fe fe-edit"></i> Editar</button>

                    <div class="">

                        <div class="dropdown">
                            <button type="button" class="btn btn-sm btn-primary dropdown-toggle {{(in_array($response->serviceOrder['status_id'], ['3','4'])  ? 'disabled' : '')}}" data-bs-toggle="dropdown">
                                <i class="fe fe-calendar"> Ações</i>
                            </button>
                            <div class="dropdown-menu">
                                <li><a href="javascript:void(0)" wire:click.prevent="sendEmail({{$response->serviceOrder['id']}})"> <i class="fa-regular fa-envelope"></i> Enviar E-mail</a></li>
                                <li><a href="javascript:void(0)" wire:click.prevent="sendWhatsapp({{$response->serviceOrder['id']}})"> <i class="fa-brands fa-whatsapp"></i> Enviar Whatsapp</a></li>
                                <li><a href="{{route('financial.service-order.pdf', $response->serviceOrder['id'])}}" > <i class="fa-regular fa-file-pdf"></i> Vizualizar PDF</a></li>
                                <li><a href="javascript:void(0)" wire:click.prevent="updateStatus({'id': {{$response->serviceOrder['id']}}, 'status_id': '3' })"> <i class="fa-solid fa-check"></i> Concluir OS</a></li>
                                <li><a href="javascript:void(0)" wire:click.prevent="updateStatus({'id': {{$response->serviceOrder['id']}}, 'status_id': '4' })"> <i class="fa-solid fa-ban"></i> Cancelar OS</a></li>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
        <div class="card-body" style="height: 240px;">
            <div class="fs-11"><span class="fw-bold">Tipo :</span>  {{$response->serviceOrder['contact']['type']}}</div>
            @if($response->serviceOrder['contact']['type'] == 'CNPJ')
                <div class="fs-11"><span class="fw-bold">Razão social :</span>  {{$response->serviceOrder['contact']['name']}}</div>
                <div class="fs-11"><span class="fw-bold"> Nome Fantasia : </span> {{$response->serviceOrder['contact']['fantasy_name']}}</div>
                <p class="fs-11"><span class="fw-bold"> CNPJ : </span> {{$response->serviceOrder['contact']['employer_number']}}</p>
            @elseif($response->serviceOrder['contact']['type'] == 'CPF')
                <div class="fs-11"><span class="fw-bold">Nome :</span>  {{$response->serviceOrder['contact']['contact_name']}}</div>
                <div class="fs-11"><span class="fw-bold">CPF :</span>  {{$response->serviceOrder['contact']['taxpayer_registration']}}</div>
            @endif

            <p class="fs-11"><span class="fw-bold"> Contrato : </span> {{$response->serviceOrder['contract']['contract']}}</p>
            <h5 class="fs-11 fw-bold"> Endereço : </h5>
            <p class="fs-11">{{$response->serviceOrder['contact']['address']}},  {{$response->serviceOrder['contact']['number']}} - {{$response->serviceOrder['contact']['zip_code']}} - {{$response->serviceOrder['contact']['neighborhood']}} - {{$response->serviceOrder['contact']['city']}} / {{$response->serviceOrder['contact']['uf']}}</p>
            <div class="d-flex align-items-center gap-2">
                <div class="fs-11"><span class="fw-bold"> Telefone : </span>{{$response->serviceOrder['contact']['phone']}}</div>
                <div class="fs-11"> <span class="fw-bold"> Email : </span>{{$response->serviceOrder['contact']['email']}} </div>
            </div>
            <div class="d-flex align-items-center gap-2 mt-2">
                <div class="fs-11"><span class="fw-bold"> Vencimento : </span>{{formatDate($response->serviceOrder['due_date'])}}</div>
            </div>

        </div>

        <div class="card-footer d-flex justify-content-between align-items-center  br-br-7 br-bl-7">
            <div >Status  :</div>
            <div> <span class="badge {{{$response->serviceOrder['status']['color']}}} text-white"> {{$response->serviceOrder['status']['name']}}</span> </div>
        </div>
    </div>

    <div class="card visually-hidden">
        <div class="card-body">
            <form wire:submit="save" class="form-horizontal">
                <div class="row">
                    <div class="col-md-12 col-xl-6">
                        <div class="form-group">
                            <div class="input-group">
                                <x-datepicker label="Vencimento" wire:model.live="state.due_date" type="hidden"> </x-datepicker>
                                @error('due_date')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 col-xl-6">
                        <div class="form-group">
                            <label class="form-label">Tipo de Pagamento</label>
                            <select wire:model.live="state.payment_method_id" class="form-control form-select">
                                @foreach($response->paymentMethods as $itemPayment)
                                    <option value="{{$itemPayment['value']}}" @if(isset($serviceOrder) && $serviceOrder['payment_method_id'] == $itemPayment['value']) selected @endif>
                                        {{$itemPayment['label']}}</option>
                                @endforeach
                            </select>
                            @error('payment_method_id')
                            <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-sm btn-primary "> Atualizar</button>
            </form>
        </div>



    </div>

</div>



@section('scripts')

    <script src="{{asset('build/assets/plugins/select2/select2.full.min.js')}}"></script>
    @vite('resources/assets/js/select2.js')

    @vite('resources/assets/js/form-elements.js')

    <!-- FLATPICKER JS -->
    <script src="{{asset('build/assets/plugins/flatpickr/flatpickr.js')}}"></script>
    @vite('resources/assets/js/flatpickr.js')


    <!-- DATEPICKER JS -->
    {{--    <script src="{{asset('build/assets/plugins/spectrum-date-picker/spectrum.js')}}"></script>--}}
    <script src="{{asset('build/assets/plugins/spectrum-date-picker/jquery-ui.js')}}"></script>

@endsection
