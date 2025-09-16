<div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex">
                        <div class="flex-1">
                            <h3 class="card-title fs-14">{{$info ? 'Editar' : 'Cadastrar'}} Informação</h3>
                            <p class="">{{$item['name']}}</p>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <h5 class="card-sub-title text-info">
                        Insira abaixo os dados da inspeção
                    </h5>

                    <form wire:submit="save" class="form-horizontal">
                        <div class="row">

                            <div class="col-md-12 col-xl-8">
                                <div class="form-group">
                                    <label for="Responsável pela açao" class="form-label">Responsável pela açao</label>
                                    <input wire:model.live="state.responsible_plan" class="form-control">
                                    @error('responsible_plan')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12 col-xl-4">
                                <x-datepicker label="Data de execução" wire:model.live="state.date_execution"> </x-datepicker>
                                @error('date_execution')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="Plano de ação"  class="form-label">Plano de ação</label>
                                    <textarea wire:model="state.action_plan" class="form-control" maxlength="225" id="textarea"
                                              rows="6"></textarea>
                                </div>
                            </div>


                        </div>
                        <button wire:click="save()" class="btn btn-primary"> {{$info ? 'Atualizar' : 'Cadastrar'}}</button>
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

@endsection


