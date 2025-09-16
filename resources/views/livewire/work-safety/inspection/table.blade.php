<div>
    <div class="row">
        <div class="col-12 col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title fs-14">Lista das Inspeções Geradas</h3>
                        <a href=" {{ route('work-safety.inspection.create') }}" class="fw-semibold btn btn-sm btn-primary"><i class="fe fe-plus-circle"></i> Nova Inspeção</a>
                </div>

                <div class="card-body" style="z-index: 5">

                    @include('includes.alerts')

                    @livewire('work-safety.inspection.filter')

                    <div class="e-table">
                        <div class="table-responsive table-lg">
                            <table class="table table-bordered text-dark">
                                <thead class="text-dark">
                                <tr>
                                    <th class="fw-bold fs-12 w-10">Referencia</th>
                                    <th class="fw-bold fs-12">Empresa</th>
                                    <th class="fw-bold fs-12">Data</th>
                                    <th class="fw-bold fs-12">Hora</th>
                                    <th class="fw-bold fs-12" width="40px">Etapa</th>
                                    <th class="fw-bold fs-12" width="30px">Açoes</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($response->inspections as $itemInspection)
                                    <tr>
                                        <td class="fw-semibold text-dark fs-12"> {{ $itemInspection['reference'] }}</td>
                                        <td class="fw-semibold text-dark fs-12"> {{ $itemInspection['company']['name'] ?? $itemInspection['company']['fantasy_name'] }}</td>
                                        <td class="fw-semibold text-dark fs-12"> {{ formatDate($itemInspection['date'] )}}</td>
                                        <td class="fw-semibold text-dark fs-12"> {{ $itemInspection['time'] }}</td>
                                        <td class="fw-semibold text-dark fs-12"> {{ $itemInspection['step'] }}</td>

                                        <td class="text-nowrap">
                                            <a href="{{ route('work-safety.inspection.list', $itemInspection['id']) }}" class="btn btn-sm btn-icon btn-primary" data-bs-toggle="tooltip" data-bs-placement="top"
                                               title="Itens">
                                                <i class="fa-solid fa-file-lines"></i>
                                            </a>
                                            {{--                                        @can('edit_professional')--}}
                                            <a href="{{ route('work-safety.inspection.edit', $itemInspection['id']) }}" class="btn btn-sm btn-icon btn-warning"  data-bs-toggle="tooltip" data-bs-placement="top"
                                               title="Editar">
                                                <i class="fe fe-edit"></i>
                                            </a>
                                            {{--                                        @endcan--}}
                                            {{--                                        @can('delete_professional')--}}
                                            <button class="btn btn-sm btn-icon btn-danger" onclick='modalDelete({{$itemInspection}})'  data-bs-toggle="tooltip" data-bs-placement="top"
                                                    title="Apagar">
                                                <i class="fe fe-trash"></i>
                                            </button>
                                            {{--                                        @endcan--}}
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex col-md-12 col-xl-2 align-items-center">

                            <label for="firstName" class="col-md-6 form-label text-nowrap mt-2">Mostrando</label>
                            <div class="col-md-9">
                                <x-select2 wire:model.live="pageSize" placeholder="Select Members" class=" select2 form-select">
                                    <option value="10" selected>10</option>
                                    <option value="25">20</option>
                                    <option value="50">50</option>
                                    <option value="75">75</option>
                                    <option value="100">100</option>
                                </x-select2>
                            </div>
                            <div class="text-nowrap mt-1">itens de {{ $response->inspections->total() }}</div>
                        </div>

                        <div class="">
                            {{ $response->inspections->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    function modalDelete(data) {
        $('#nomeUsuario').text(data.name);
        $('#idUsuario').text(data.id);
        $('#confirmDelete').text('confirmDeleteCountry');
        $('#Vertically').modal('show');
    }
</script>


