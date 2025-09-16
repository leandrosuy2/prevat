<div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12">
    <div class="card overflow-hidden">
        <div class="card-header d-flex justify-content-between align-items-center border-bottom-0">
            <h3 class="card-title mb-0">Últimos Agendamentos</h3>
            <a href="{{ route('client.movement.schedule-company') }}" class="btn btn-sm bg-primary-transparent fw-bold">
                Vizualizar todos
            </a>
        </div>
        <div class="card-body p-0">
            <ul class="list-group list-group-flush ">
                @foreach($response->scheduleCompanies as $itemScheduleCompany)
                <li class="list-group-item d-flex align-items-start">
                    <div class="px-2 py-2">
                        <i class="fa-regular fa-calendar-check text-info fs-26"></i>
{{--                        <i class="fa-solid fa-graduation-cap  text-info fs-26"></i>--}}
                    </div>

                    <div class="mt-1 ml-2">
                        <h6 class="fw-semibold text-dark mb-0 fs-13">{{$itemScheduleCompany['schedule']['training']['name']}} - {{formatDate($itemScheduleCompany['schedule']['end_event'])}}</h6>
                        <span class="text-muted fs-11">{{$itemScheduleCompany['schedule']['location']['name']}}</span>
                    </div>
                    <div class="ms-auto d-flex">
                        <a href="{{ route('client.movement.schedule-company.view', $itemScheduleCompany['reference']) }}" class="btn btn-sm btn-light"><i
                                class="fa fa-eye text-cyan"></i></a>
                    </div>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
