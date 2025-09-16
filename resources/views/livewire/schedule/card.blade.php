<div>
    <div class="row row-cols-4">
        <div class="col">
            {{--            <div class="card bg-transparent">--}}
            {{--                <div class="card-body">--}}
            {{--                    <div class="d-flex no-block align-items-center">--}}
            {{--                        <div>--}}
            {{--                            <h6 class="text-white"></h6>--}}
            {{--                            <h2 class="text-white m-0 "></h2>--}}
            {{--                        </div>--}}
            {{--                        <div class="ms-auto">--}}
            {{--                                        <span class="text-white display-6"><i--}}
            {{--                                                class="fa fa-file-text-o fs-1"></i></span>--}}
            {{--                        </div>--}}
            {{--                    </div>--}}
            {{--                </div>--}}
            {{--            </div>--}}
        </div><!-- col end -->

        <div class="col">
            <div class="card bg-primary">
                <div class="card-body">
                    <div class="no-block align-items-center">
                        <div class="text-center">
                            <h5 class="text-white m-0">Segunda</h5>
                            <h6 class="text-white fs-11">{{ formatDate($response->schedules[0]['trainings'][0]['date'])}}</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- col end -->
        <div class="col">
            <div class="card bg-info">
                <div class="card-body">
                    <div class="no-block align-items-center">
                        <div class="text-center">
                            <h5 class="text-white m-0 ">Terça</h5>
                            <h6 class="text-white fs-11">{{ formatDate($response->schedules[0]['trainings'][1]['date'])}}</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- col end -->
        <div class="col">
            <div class="card bg-success">
                <div class="card-body">
                    <div class="no-block align-items-center">
                        <div class="text-center">
                            <h5 class="text-white m-0 ">Quarta</h5>
                            <h6 class="text-white fs-11">{{ formatDate($response->schedules[0]['trainings'][2]['date'])}}</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- col end -->
        <div class="col">
            <div class="card bg-warning">
                <div class="card-body">
                    <div class="no-block align-items-center">
                        <div class="text-center">
                            <h5 class="text-white m-0 ">Quinta</h5>
                            <h6 class="text-white fs-11">{{ formatDate($response->schedules[0]['trainings'][3]['date'])}}</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- col end -->
        <div class="col">
            <div class="card bg-cyan">
                <div class="card-body">
                    <div class="no-block align-items-center">
                        <div class="text-center">
                            <h5 class="text-white m-0 ">Sexta</h5>
                            <h6 class="text-white fs-11">{{ formatDate($response->schedules[0]['trainings'][4]['date'])}}</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- col end -->
        <div class="col">
            <div class="card bg-purple">
                <div class="card-body">
                    <div class="no-block align-items-center">
                        <div class="text-center">
                            <h5 class="text-white m-0 ">Sabado</h5>
                            <h6 class="text-white fs-11">{{ formatDate($response->schedules[0]['trainings'][5]['date'])}}</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- col end -->
        <div class="col">
            <div class="card bg-orange">
                <div class="card-body">
                    <div class="no-block align-items-center">
                        <div class="text-center">
                            <h5 class="text-white m-0 ">Domingo</h5>
                            <h6 class="text-white fs-11">{{ formatDate($response->schedules[0]['trainings'][6]['date'])}}</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- col end -->
    </div>

    @foreach($response->schedules as $itemSchedule)

        <div class="row row-cols-4">
            <div class="col">
                <div class="card" style="height:140px;">
                    <div class="card-body text-center h-25">
                        <div class="h4 m-2 fs-12"><strong> {{$itemSchedule['room']}}</strong>
                        </div>
                                            <div class="text-muted mt-0">Qtde.</div>
                    </div>
                </div>
            </div>
            @foreach($itemSchedule['trainings'] as $itemTraining)
                <div class="col">
                    <div class="card" style="height:140px;">
                        <div class="card-body text-center h-25">
                            @if($itemTraining['vacancies_occupied'] != null)
                                <div class="h-5 mb-1">
                                    <i class="mdi mdi-account-outline text-primary mx-2"></i>
                                    <strong class="text-red fs-12">{{$itemTraining['vacancies_occupied']}}  </strong>
                                    <strong class="fs-12"> / </strong>
                                    <strong class="text-green fs-12">{{$itemTraining['vacancies']}}  </strong>
                                </div>

                                <div class="text-muted mb-1 fs-10">{{$itemTraining['name']}} {{$itemTraining['team']}} {{$itemTraining['contractor']}}</div>
                            @endif
                        </div>
                        @if($itemTraining['vacancies_occupied'] != null && $itemTraining['vacancies_occupied'] < $itemTraining['vacancies'])
                            @if(auth()->user()->company->type == 'admin')
                                <a href=" {{ route('movement.schedule-company.create', $itemTraining['id']) }}" class="fw-semibold btn btn-sm btn-primary"><i class="fe fe-plus-circle"></i> Agendar </a>
                            @elseif(auth()->user()->company->type == 'client')
                                <a href=" {{ route('client.movement.schedule-company.create', $itemTraining['id']) }}" class="fw-semibold btn btn-sm btn-primary"><i class="fe fe-plus-circle"></i> Agendar </a>
                            @endif
                        @elseif($itemTraining['vacancies_occupied'] != null && $itemTraining['vacancies_occupied'] == $itemTraining['vacancies'])
                            <button class="btn btn-sm btn-danger"> Esgotado</button>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

    @endforeach


</div>
