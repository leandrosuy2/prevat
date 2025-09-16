<div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title fs-14">{{$professional ? 'Edição de ' : 'Cadastro de nova '}} Formação do profissional</h3>
                </div>
                <div class="card-body">
                    <p class="card-sub-title text-muted">
                        Insira abaixo a nova Formação do profissional
                    </p>

                    <form wire:submit="save" class="form-horizontal">
                        <div class="row">
                            <div class="col-md-12 col-xl-5">
                                <div class="form-group">
                                    <label for="Nome do Usuário" class="form-label">Nome da Função</label>
                                    <input type="text" wire:model="state.name" class="form-control">
                                    @error('name')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12 col-xl-2">
                                <div class="form-group">
                                    <label class="form-label">Status</label>
                                    <x-select2 wire:model="state.status"  class=" select2 form-select">
                                        <option value="">Escolha</option>
                                        <option value="Ativo">Ativo</option>
                                        <option value="Inativo">Inativo</option>
                                    </x-select2>

                                    @error('status')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary"> {{$professional ? 'Atualizar' : 'Cadastrar'}}</button>
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


    {{--    <script>--}}
    {{--        $(document).ready(function () {--}}
    {{--            $('#select2').select2();--}}
    {{--            $('#select2').on('change', function (e) {--}}
    {{--                var data = $('#select2').select2("val");--}}

    {{--            @this.set('selected', data);--}}

    {{--            });--}}
    {{--        });--}}
    {{--    </script>--}}
@endsection

