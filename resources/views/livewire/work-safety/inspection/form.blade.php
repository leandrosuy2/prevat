<div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">

                    <h3 class="card-title fs-14">{{$inspection ? 'Edição de ' : 'Cadastro de nova '}} Inspeção</h3>
                </div>

                <div class="card-body">
                    <h6 class="card-sub-title text-primary">
                        Insira abaixo os dados da empresa
                    </h6>

                    @include('includes.alerts')

                    <form wire:submit="save" class="form-horizontal mt-5">
                        <div class="row">
                            <div class="col-md-12 col-xl-4">
                                <div class="form-group">
                                    <label class="form-label">Empresas</label>
                                    <x-select2 wire:model.live="state.company_id" class="form-control form-select select2 select2-show-search">
                                        @foreach($response->companies as $itemCompany)
                                            <option value="{{$itemCompany['value']}}" @if(isset($scheduleComnpany) && $scheduleComnpany['company_id'] == $itemCompany['value']) selected @endif>
                                                {{$itemCompany['label']}}</option>
                                        @endforeach
                                    </x-select2>
                                    @error('company_id')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12 col-xl-2">
                                <div class="form-group">
                                    <label class="form-label">Cep</label>
                                    <div class="input-group">
                                        <input x-mask="99999-999"  wire:model="state.zip_code" class="form-control">
                                        <button type="button" class="btn btn-primary btn-icon" wire:click.prevent="getAddress()"  wire:loading.class="btn-loading p-4 ">
                                            <i wire:target="getAddress()" wire:loading.remove class="fe fe-search text-white" ></i>
                                        </button>
                                        @error('zip_code')
                                        <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-xl-6">
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
                            <div class="col-md-12 col-xl-3">
                                <div class="form-group">
                                    <label for="Complemento" class="form-label">Complemento</label>
                                    <input wire:model="state.complement" class="form-control">
                                    @error('complement')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12 col-xl-3">
                                <div class="form-group">
                                    <label for="Bairro" class="form-label">Bairro</label>
                                    <input wire:model.live="state.neighborhood" class="form-control">
                                    @error('neighborhood')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12 col-xl-3">
                                <div class="form-group">
                                    <label for="Cidade" class="form-label">Cidade</label>
                                    <input wire:model.live="state.city" class="form-control">
                                    @error('city')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12 col-xl-1">
                                <div class="form-group">
                                    <label for="Estado" class="form-label">Estado</label>
                                    <input wire:model.live="state.uf" class="form-control">
                                    @error('uf')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <h6 class="card-sub-title text-primary">
                            Insira abaixo os dados da nova Inspeção
                        </h6>

                        <div class="row mb-3">
                            <div class="col-md-12 col-xl-3">
                                <x-datepicker label="Data" wire:model.live="state.date"> </x-datepicker>
                                @error('date')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col-md-12 col-xl-3">
                                <x-timepicker label="Hora" wire:model.live="state.time"> </x-timepicker>
                                @error('time')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>


                        @if(!$inspection)
                            <div class="row">
                                <div class="col-md-12 col-xl-12">
                                    @foreach ($response->categories as $index => $item)

                                    <div class="table-responsive mb-3">
                                        <table
                                            class="table table-bordered text-nowrap text-md-nowrap  table-primary mb-0">
                                            <thead>
                                            <tr>
                                                <th class="text-center w-5">ID</th>
                                                <th>{{$item['name']}}</th>
                                                <th class="text-center w-5">Sim</th>
                                                <th class="text-center w-5">Não</th>
                                                <th class="text-center w-5">INFO</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($response->items as $key => $itemItem)
                                                @if($item['id'] == $itemItem['category_id'])
                                                <tr>
                                                    <td>{{$itemItem['id']}}</td>
                                                    <td>{{$itemItem['name']}}</td>
                                                    <td class="text-center">
                                                        <label class="custom-switch">
                                                            <input type="checkbox" name="custom-switch-checkbox"
                                                                   wire:model.live="yes.{{$key}}"
                                                                   class="custom-switch-input">
                                                            <span class="custom-switch-indicator"></span>
                                                        </label>
                                                    </td>
                                                    <td class="text-center">
                                                        <label class="custom-switch">
                                                            <input type="checkbox" name="custom-switch-checkbox"
                                                                   wire:model.live="not.{{$key}}"
                                                                   class="custom-switch-input">
                                                            <span class="custom-switch-indicator"></span>
                                                        </label>
                                                    </td>
                                                    <td class="text-center">
                                                        <button wire:click.prevent="openModal('work_safety.info.form', {'id' : {{$itemItem['id']}}, 'key' : {{$key}} })" class="btn btn-sm btn-icon btn-primary" data-bs-toggle="tooltip" data-bs-placement="top"
                                                           title="Itens">
                                                            <i class="fa-solid fa-file-lines"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                @endif
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <div class="py-2">
                            <button type="submit" class="btn btn-primary"> {{$inspection ? 'Atualizar' : 'Cadastrar'}}</button>
                        </div>
                </form>
            </div>
        </div>
        </div>
    </div>
</div>

@section('scripts')
    <!-- SELECT2 JS -->
    <script src="{{asset('build/assets/plugins/select2/select2.full.min.js')}}"></script>
    @vite('resources/assets/js/select2.js')

    <!-- TIMEPICKER JS -->
    {{--    <script src="{{asset('build/assets/plugins/time-picker/jquery.timepicker.js')}}"></script>--}}
    {{--    <script src="{{asset('build/assets/plugins/time-picker/toggles.min.js')}}"></script>--}}

    <!-- FLATPICKER JS -->
    <script src="{{asset('build/assets/plugins/flatpickr/flatpickr.js')}}"></script>
    @vite('resources/assets/js/flatpickr.js')


    <!-- DATEPICKER JS -->
    {{--    <script src="{{asset('build/assets/plugins/spectrum-date-picker/spectrum.js')}}"></script>--}}
    <script src="{{asset('build/assets/plugins/spectrum-date-picker/jquery-ui.js')}}"></script>
    {{--    <script src="{{asset('build/assets/plugins/input-mask/jquery.maskedinput.js')}}"></script>--}}

    @vite('resources/assets/js/form-elements.js')
@endsection

