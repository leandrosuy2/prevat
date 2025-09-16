<div>
    <div class="row">
        <div class="col-12 col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title fs-14">Histórico de downloads da Evidência : {{$evidence['training_participation']['schedule_prevat']['training']['name']}}</h3>
                    <a href="{{ route('movement.evidence')}}" class="btn btn-sm btn-icon btn-primary" data-bs-toggle="tooltip" data-bs-placement="top"
                       title="Voltar">
                        <i class="fa fa-backward"></i> Voltar
                    </a>
                </div>

                <div class="card-body" style="z-index: 5">

                    @include('includes.alerts')

                    <div class="e-table">
                        <div class="table-responsive table-lg">
                            <table class="table table-bordered text-dark">
                                <thead>
                                <tr class="fs-12">
                                    <th class="text-dark fw-semibold fs-12">Usuario</th>
                                    <th class="text-dark fw-semibold fs-12">Certificado</th>
                                    <th class="text-dark fw-semibold fs-12 text-center">Data</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($response->historics as $key => $itemHistoric)
                                    <tr>
                                        <td class="text-nowrap">
                                            <div class="flex-1 my-auto">
                                                <h6 class="mb-0 fw-semibold fs-11">
                                                    <i class="fas fa-graduation-cap "></i> {{$itemHistoric['user']['name']}}
                                                </h6>
                                                <span class="mb-0 fw-semibold fs-11"> <i class="fa fa-envelope "></i>  {{$itemHistoric['user']['email']}}</span>
                                            </div>
                                        </td>


                                        <td class="text-nowrap align-middle fs-11">
                                            <span>{{$itemHistoric['training_participation']['schedule_prevat']['training']['name']}}</span>
                                        </td>



                                        <td class="text-nowrap align-middle text-center  fs-11">
                                            <span>{{formatDateAndTime($itemHistoric['created_at'])}}</span>
                                        </td>

                                        {{--                                        <td class="text-center align-middle">--}}
                                        {{--                                            <button class="btn btn-icon btn-primary" wire:click="download({{$itemHistoric['id']}})" data-bs-toggle="tooltip" data-bs-placement="top"--}}
                                        {{--                                                    title="Download">--}}
                                        {{--                                                <i class="fa fa-download"></i>--}}
                                        {{--                                            </button>--}}
                                        {{--                                        </td>--}}
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
