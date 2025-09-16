<div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title fs-14">{{$contact ? 'Edição de ' : 'Cadastro de nova '}} Empresa</h3>
                </div>
                <div class="card-body">
                    <h5 class="card-sub-title text-info">
                        Insira abaixo os dados de faturamento.
                    </h5>

                    <form wire:submit="save" class="form-horizontal">
                        <div class="row">
                            <div class="col-md-12 col-xl-2">
                                <div class="form-group">
                                    <label class="form-label">Tipo</label>
                                    <select wire:model.live="state.type"  class="form-select">
                                        <option value="">Escolha</option>
                                        <option value="CPF">CPF</option>
                                        <option value="CNPJ">CNPJ</option>
                                    </select>
                                    @error('type')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            @if($state['type'] === 'CNPJ')
                                <div class="col-md-12 col-xl-4">
                                    <div class="form-group">
                                        <label class="form-label">Cnpj</label>
                                        <div class="input-group">
                                            <input x-mask="99.999.999/9999-99"  wire:model="state.employer_number" class="form-control">
                                            <button type="button" class="btn btn-primary btn-icon" wire:click.prevent="getCompany()"  wire:loading.class="btn-loading p-4 ">
                                                <i wire:target="getCompany()" wire:loading.remove class="fe fe-search text-white" ></i>
                                            </button>
                                            @error('employer_number')
                                            <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12 col-xl-6">
                                    <div class="form-group">
                                        <label for="Responsável" class="form-label">Responsável</label>
                                        <input type="text" wire:model="state.responsible" class="form-control">
                                        @error('responsible')
                                        <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                            <div class="col-md-12 col-xl-12">
                                <div class="form-group">
                                    <label for="Razão Social" class="form-label">Razão Social CNPJ</label>
                                    <input type="text" wire:model="state.name" class="form-control">
                                    @error('name')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12 col-xl-12">
                                <div class="form-group">
                                    <label for="Nome Fantasia" class="form-label">Nome Fantasia</label>
                                    <input type="text" wire:model="state.fantasy_name" class="form-control">
                                    @error('fantasy_name')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            @elseif($state['type'] === 'CPF')
                                <div class="col-md-12 col-xl-4">
                                    <div class="form-group">
                                        <label class="form-label">CPF</label>
                                            <input x-mask="999.999.999-99"  wire:model="state.taxpayer_registration" class="form-control">

                                            @error('taxpayer_registration')
                                            <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                    </div>
                                </div>

                                <div class="col-md-12 col-xl-6">
                                    <div class="form-group">
                                        <label for="Nome" class="form-label">Nome</label>
                                        <input type="text" wire:model="state.contact_name" class="form-control">
                                        @error('contact_name')
                                        <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            @endif

                                <div class="col-md-12 col-xl-4">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <x-datepicker label="Vencimento" wire:model.live="state.order.due_date"> </x-datepicker>
                                            @error('order.due_date')
                                            <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12 col-xl-4">
                                    <div class="form-group">
                                        <label class="form-label">Tipo de Pagamento</label>
                                        <select wire:model.live="state.order.payment_method_id" class="form-control form-select">
                                            @foreach($response->paymentMethods as $itemPayment)
                                                <option value="{{$itemPayment['value']}}" @if(isset($serviceOrder) && $serviceOrder['payment_method_id'] == $itemPayment['value']) selected @endif>
                                                    {{$itemPayment['label']}}</option>
                                            @endforeach
                                        </select>
                                        @error('order.payment_method_id')
                                        <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                            <div class="col-md-12 col-xl-4">
                                <div class="form-group">
                                    <label for="E-mail" class="form-label">Telefone</label>
                                    <input x-mask="(99) 9 9999-9999" wire:model="state.phone" class="form-control @error('email') is-invalid state-invalid @enderror">
                                    @error('phone')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12 col-xl-5">
                                <div class="form-group">
                                    <label for="E-mail" class="form-label">E-mail</label>
                                    <input type="email" wire:model="state.email" class="form-control">
                                    @error('email')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <h5 class="card-sub-title text-info">
                                Endereço da Faturamento.
                            </h5>

                            <div class="row">
                                <div class="col-md-12 col-xl-4">
                                    <div class="form-group">
                                        <label class="form-label">Cep</label>
                                        <div class="input-group">
                                            <input x-mask="99999-999"  wire:model="state.zip_code" class="form-control">
                                            <button type="button" class="btn btn-primary btn-icon" wire:click.prevent="getAddress()"  wire:loading.class="btn-loading p-4 ">
                                                <i wire:target="getAddress()" wire:loading.remove class="fe fe-search text-white" ></i>
                                            </button>
                                            @error('zip-code')
                                            <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-xl-8">
                                    <div class="form-group">
                                        <label for="Endereço" class="form-label">Endereço</label>
                                        <input wire:model.live="state.address" class="form-control">
                                        @error('address')
                                        <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12 col-xl-2">
                                    <div class="form-group">
                                        <label for="Número" class="form-label">Número</label>
                                        <input wire:model="state.number" class="form-control">
                                        @error('number')
                                        <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-12 col-xl-5">
                                    <div class="form-group">
                                        <label for="Número" class="form-label">Complemento</label>
                                        <input wire:model="state.complement" class="form-control">
                                        @error('complement')
                                        <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-12 col-xl-5">
                                        <div class="form-group">
                                            <label for="Bairro" class="form-label">Bairro</label>
                                            <input wire:model.live="state.neighborhood" class="form-control">
                                            @error('neighborhood')
                                            <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                            </div>

                                <div class="col-md-12 col-xl-4">
                                        <div class="form-group">
                                            <label for="Cidade" class="form-label">Cidade</label>
                                            <input wire:model.live="state.city" class="form-control">
                                            @error('city')
                                            <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                <div class="col-md-12 col-xl-2">
                                        <div class="form-group">
                                            <label for="Estado" class="form-label">Estado</label>
                                            <input wire:model.live="state.uf" class="form-control">
                                            @error('uf')
                                            <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                            </div>

                            <div class="form-group">
                                <label for="Observações"  class="form-label">Observações</label>
                                <textarea wire:model="state.observations" class="form-control" maxlength="225" id="textarea"
                                          rows="3"></textarea>
                            </div>


                        </div>

                        <button type="submit" class="btn btn-primary"> {{$contact ? 'Atualizar' : 'Cadastrar'}}</button>
                    </form>

                </div>
            </div>
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


