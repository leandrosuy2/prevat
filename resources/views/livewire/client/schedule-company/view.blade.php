<div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title fs-14">Vizualização</h3>

                </div>

                <div class="card-body">

                    @include('includes.alerts')

                        <div class="row">
                                <div class="row">
                                    <div class="col-md-12 col-xl-12">
                                        <div class="card text-white bg-gradient-primary">
                                            <div class="card-body">
                                                <h4 class="card-title"> {{$schedule['schedule']['training']['name']}}</h4>
                                                <p class="card-text mb-0">{{$schedule['schedule']['location']['address']}} -
                                                    {{ $schedule['schedule']['location']['number'] ?? 'S/N' }}
                                                    {{ $schedule['schedule']['location']['complement'] ? ' - '.$schedule['schedule']['location']['complement'] : ' ' }}
                                                    {{ $schedule['schedule']['location']['neighborhood'] ? ' - '.$schedule['schedule']['location']['neighborhood'] : ' ' }}
                                                    {{ $schedule['schedule']['location']['zip-code'] ? ' - '.$schedule['schedule']['location']['zip-code'] : ' ' }}
                                                    {{ $schedule['schedule']['location']['city'] ? ' - '.$schedule['schedule']['location']['city'] : ' ' }}
                                                    {{ $schedule['schedule']['location']['uf'] ? ' - '.$schedule['schedule']['location']['uf'] : ' ' }}
                                                </p>

                                                <p class="card-text  mb-0">Carga Horaria : {{ $schedule['schedule']['workload']['name'] }} </p>
                                                @if(strtotime($schedule['schedule']['start_event']) != strtotime($schedule['schedule']['end_event']))
                                                    @if($schedule['schedule']['days'] <= 2)
                                                        <p class="card-text  mb-0">Data : {{ formatDate($schedule['schedule']['start_event']) }} e {{ formatDate($schedule['schedule']['end_event']) }}</p>
                                                    @elseif($schedule['schedule']['days'] > 2)
                                                        <p class="card-text  mb-0">Data : {{ formatDate($schedule['schedule']['start_event']) }} à {{ formatDate($schedule['schedule']['end_event']) }}</p>
                                                    @endif
                                                @else
                                                    <p class="card-text  mb-0">Data : {{ formatDate($schedule['schedule']['start_event']) }} </p>
                                                @endif

                                                <p class="card-text"> 1º Horário : {{$schedule['schedule']['first_time']['name']}}
                                                    @if($schedule['schedule']['second_time'])
                                                        - 2º Horário : {{$schedule['schedule']['second_time']['name']}}
                                                    @endif
                                                </p>


{{--                                                <p class="card-text  mb-0">Carga Horaria : {{ $schedule['schedule']['workload']['name'] }} </p>--}}
{{--                                                <p class="card-text"> 1º Horário : {{$schedule['schedule']['first_time']['name']}}--}}
{{--                                                    @if($schedule['schedule']['second_time'])--}}
{{--                                                        - 2º Horário : {{$schedule['schedule']['second_time']['name']}}--}}
{{--                                                    @endif--}}
{{--                                                </p>--}}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 col-xl-12">
                                        <div class="table-responsive">
                                            <table id="data-table3" class="table table-bordered text-nowrap mb-0">
                                                <thead class="text-dark">
                                                <tr>
                                                    <th class="fw-bold fs-12">Nome</th>
                                                    <th class="fw-bold fs-12">Documentos</th>
                                                    <th class="fw-bold fs-12">Empresa</th>
                                                    <th class="fw-bold fs-12" width="40px">Status</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($schedule['participants'] as $key => $itemParticipant)
                                                    <tr>
                                                        <td>
                                                            <div class="d-flex">
                                                                <div class="flex-1 text-uppercase">
                                                                    <h6 class="mb-0 mt-1 text-dark fw-semibold">
                                                                        {{$itemParticipant['participant']['name']}}
                                                                    </h6>
                                                                    <span class="text-muted fw-semibold fs-12"> {{$itemParticipant['participant']['role']['name']}}</span>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="fw-semibold text-muted-dark">
                                                            <span class="text-muted fw-semibold fs-12">CTO. : {{ $itemParticipant['participant']['contract']['contract'] ?? 'S/C' }}</span><br>
                                                            <span class="text-muted fw-semibold fs-12">CPF : {{ $itemParticipant['participant']['taxpayer_registration'] ?? 'S/C'}}</span><br>

                                                        </td>
                                                        <td class="fw-semibold text-dark">
                                                            <span class="text-muted fw-semibold fs-12">E-mail : {{ $itemParticipant['participant']['email'] ?? 'S/C'}} </span><br>
                                                            <span class="text-muted fw-semibold fs-12">Telefone : {{ $itemParticipant['participant']['phone'] ?? 'S/C'}}</span>
                                                        </td>
                                                        <td>
                                                            <div class="text-center">
                                                                @if($itemParticipant['participant']['status'] == 'Ativo')
                                                                    <span class="badge bg-success text-white"> {{$itemParticipant['participant']['status']}}</span>
                                                                @else
                                                                    <span class="badge bg-danger text-white"> {{$itemParticipant['participant']['status']}}</span>
                                                                @endif
                                                            </div>
                                                        </td>

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
    </div>
</div>

@section('scripts')
    <script src="{{asset('build/assets/plugins/select2/select2.full.min.js')}}"></script>
    @vite('resources/assets/js/select2.js')

    @vite('resources/assets/js/form-elements.js')
@endsection
