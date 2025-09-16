<div>
    <div class="row">
        <div class="col-12 col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center m-0">
                    <h3 class="card-title fs-14">Lista dos tipos de pagamento</h3>

{{--                        @can('add_participant')--}}
                            <a href=" {{ route('financial.payment-method.create') }}" class="fw-semibold btn btn-sm btn-primary"><i class="fe fe-plus-circle"></i> Novo tipo de pagamento </a>
{{--                        @endcan--}}

                </div>

                <div class="card-body" style="z-index: 5">

                    @include('includes.alerts')

                    @livewire('financial.payment-method.filter')

                    <div class="e-table">
                        <div class="table-responsive table-lg">
                            <table class="table table-bordered text-dark">
                                <thead class="text-dark">
                                <tr>
                                    <th class="fw-semibold">Nome</th>
                                    <th class="fw-semibold" width="40px">Status</th>
                                    <th class="fw-semibold w-10" >Açoes</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($response->paymentMethods as $itemPaymentMethod)
                                    <tr>
                                        <td>
                                            <div class="d-flex">
                                                <div class="flex-1">
                                                    <h6 class="mb-0 mt-1 text-dark fw-semibold">
                                                        {{$itemPaymentMethod['name']}}
                                                    </h6>
                                                </div>
                                            </div>
                                        </td>

                                        <td>
                                            <div class="text-center">
                                                @if($itemPaymentMethod['status'] == 'Ativo')
                                                    <span class="badge bg-success text-white"> {{$itemPaymentMethod['status']}}</span>
                                                @else
                                                    <span class="badge bg-danger text-white"> {{$itemPaymentMethod['status']}}</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="text-nowrap">
{{--                                                @can('edit_participant')--}}
                                            <a href="{{ route('registration.participant.edit', $itemPaymentMethod['id']) }}" class="btn btn-sm btn-icon btn-warning">
                                                <i class="fe fe-edit"></i>
                                            </a>
{{--                                                @endcan--}}
{{--                                                @can('delete_participant')--}}
                                            <button class="btn btn-sm btn-icon btn-danger" onclick='modalDelete({{$itemPaymentMethod}})' >
                                                <i class="fe fe-trash"></i>
                                            </button>
{{--                                                @endcan--}}

                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex col-md-12 col-xl-2 align-items-center">

                            <label for="firstName" class="col-md-5 form-label text-nowrap mt-2">Mostrando</label>
                            <div class="col-md-9">
                                <x-select2 wire:model.live="pageSize" placeholder="Select Members" class=" select2 form-select">
                                    <option value="10" selected>10</option>
                                    <option value="25">20</option>
                                    <option value="50">50</option>
                                    <option value="75">75</option>
                                    <option value="100">100</option>
                                </x-select2>
                            </div>
                            <div class="text-nowrap mt-1">itens de {{ $response->paymentMethods->total() }}</div>
                        </div>

                        <div class="">
                            {{ $response->paymentMethods->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    function modalDelete(client) {
        $('#nomeUsuario').text(client.name);
        $('#idUsuario').text(client.id);
        $('#confirmDelete').text('confirmDeletePaymentMethod');
        $('#Vertically').modal('show');
    }
</script>


