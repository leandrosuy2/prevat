<div>
    <div class="row">
        <!-- Card: Treinamentos ministrados no mês -->
        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 mb-3">
            <div class="card overflow-hidden border-0 shadow-sm" style="background: linear-gradient(90deg, #4e54c8 0%, #8f94fb 100%); color: #fff;">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-0 fw-semibold" style="color: #fff;">Treinamentos no mês</p>
                            <h2 class="mt-1 mb-1 fw-bold" style="color: #fff;">{{$trainingsMonth}}</h2>
                            <span class="fw-semibold fs-12" style="color: #e0e0e0;">Ministrados</span>
                        </div>
                        <span class="ms-auto my-auto avatar avatar-lg brround" style="background: rgba(255,255,255,0.15); color: #fff;">
                            <i class="fa fa-chalkboard-teacher fs-2"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <!-- Card: Empresas atendidas no mês -->
        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 mb-3">
            <div class="card overflow-hidden border-0 shadow-sm" style="background: linear-gradient(90deg, #11998e 0%, #38ef7d 100%); color: #fff;">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-0 fw-semibold" style="color: #fff;">Empresas atendidas</p>
                            <h2 class="mt-1 mb-1 fw-bold" style="color: #fff;">{{$companiesMonth}}</h2>
                            <span class="fw-semibold fs-12" style="color: #e0e0e0;">No mês</span>
                        </div>
                        <span class="ms-auto my-auto avatar avatar-lg brround" style="background: rgba(255,255,255,0.15); color: #fff;">
                            <i class="fa fa-building fs-2"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <!-- Card: Turmas extras no mês -->
        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 mb-3">
            <div class="card overflow-hidden border-0 shadow-sm" style="background: linear-gradient(90deg, #ff512f 0%, #dd2476 100%); color: #fff;">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-0 fw-semibold" style="color: #fff;">Turmas extras</p>
                            <h2 class="mt-1 mb-1 fw-bold" style="color: #fff;">{{$extraClassesMonth}}</h2>
                            <span class="fw-semibold fs-12" style="color: #e0e0e0;">No mês</span>
                        </div>
                        <span class="ms-auto my-auto avatar avatar-lg brround" style="background: rgba(255,255,255,0.15); color: #fff;">
                            <i class="fa fa-users-cog fs-2"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
            <div class="card overflow-hidden">
                <div class="card-body">
                    <div class="d-flex">
                        <div>
                            <p class="mb-0 text-dark fw-semibold">Total de Participantes</p>
                            <h3 class="mt-1 mb-1 text-dark fw-semibold"> {{$participants->count()}}</h3>
                            <span class="text-muted fw-semibold fs-12">Cadastrados nesse contrato</span>
                        </div>
                        <span class="ms-auto my-auto bg-danger-transparent avatar avatar-lg brround text-danger">
                            <i class="fa fa-users fs-4"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
            <div class="card overflow-hidden">
                <div class="card-body">
                    <div class="d-flex">
                        <div>
                            <p class="mb-0 text-dark fw-semibold">Total de Agendamentos</p>
                            <h3 class="mt-1 mb-1 text-dark fw-semibold">{{$schedules->count()}}</h3>
                            <span class="text-muted fw-semibold fs-12"><span class="text-white">_</span> </span>
                        </div>
                        <span class="ms-auto my-auto bg-primary-transparent avatar avatar-lg brround text-primary">
                            <i class="fa fa-calendar fs-4"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
            <div class="card overflow-hidden">
                <div class="card-body">
                    <div class="d-flex">
                        <div>
                            <p class="mb-0 text-dark fw-semibold">Participantes Presentes</p>
                            <h3 class="mt-1 mb-1 fw-semibold">{{$presences}}</h3>
                            <span class="text-muted fw-semibold fs-12"><span class="text-white">_</span> </span>
                        </div>
                        <span class="ms-auto my-auto bg-secondary-transparent avatar avatar-lg brround text-secondary">
                            <i class="fa fa-user-plus fs-4"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 col-lg-6 col-sm-6">
            <div class="card overflow-hidden">
                <div class="card-body">
                    <div class="d-flex">
                        <div>
                            <p class="mb-0 text-dark fw-semibold">Participantes Ausentes</p>
                            <h3 class="mt-1 mb-1 text-dark fw-semibold">{{$absences}}</h3>
{{--                            <span class="text-muted fw-semibold fs-12"><span class="text-primary">05%</span> Higher than Last Month</span>--}}
                            <span class="text-muted fw-semibold fs-12"><span class="text-white">_</span> </span>

                        </div>
                        <span class="ms-auto my-auto bg-info-transparent avatar avatar-lg brround text-info">
                            <i class="fa fa-user-minus fs-4"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
