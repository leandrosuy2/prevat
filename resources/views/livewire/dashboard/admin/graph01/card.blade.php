<div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div
                    class="card-header custom-header d-flex justify-content-between align-items-center border-bottom">
                    <h3 class="card-title fs-14">Treinamentos ministrados</h3>
                    <div class="dropdown">
                        <a href="javascript:void(0);" class="d-flex align-items-center bg-primary btn btn-sm mx-1 fw-semibold" data-bs-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true">Comparativo<i class="fe fe-chevron-down fw-semibold mx-1"></i>
                        </a>
                    </div>
                </div>
                <div class="card-body pb-0">
                    <div class="d-flex ms-5">
                        <div>
                            <p class="mb-0 fs-15 text-muted">
                                Este mês
                            </p>
                            <span class="text-primary fs-20 fw-semibold">{{$trainingsThisMonth}}</span>
                        </div>
                        <div class="ms-5">
                            <p class="mb-0 fs-15 text-muted">
                                Mês passado
                            </p>
                            <span class="fs-20 text-secondary fw-semibold">{{$trainingsLastMonth}}</span>
                        </div>
                    </div>
                    <div id="revenue_chart">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
