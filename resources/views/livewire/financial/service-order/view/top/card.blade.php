<div class="row">
    <div class="col-sm-6 col-md-6 col-lg-3">
        <div class="card bg-primary">
            <div class="card-body">
                <div class="d-flex no-block align-items-center">
                    <div>
                        <h6 class="text-white">Total de Treinamentos</h6>
                        <h2 class="text-white m-0 ">{{$response->serviceOrder['releases']->count()}}</h2>
                    </div>
                    <div class="ms-auto">
                        <span class="text-white display-6"><i
                                class="fa fa-file-text-o fs-1"></i></span>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- col end -->
    <div class="col-sm-6 col-md-6 col-lg-3">
        <div class="card bg-info">
            <div class="card-body">
                <div class="d-flex no-block align-items-center">
                    <div>
                        <h6 class="text-white">Total de Items</h6>
                        <h2 class="text-white m-0 ">{{$response->participants->sum('quantity')}}</h2>
                    </div>
                    <div class="ms-auto">
                        <span class="text-white display-6"><i
                                class="fa fa-signal fs-1"></i></span>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- col end -->
    <div class="col-sm-6 col-md-6 col-lg-3">
        <div class="card bg-success">
            <div class="card-body">
                <div class="d-flex no-block align-items-center">
                    <div>
                        <h6 class="text-white">Total dos Serviços</h6>
                        <h2 class="text-white m-0 ">{{formatMoney($response->serviceOrder['total_value'])}}</h2>
                    </div>
                    <div class="ms-auto">
                        <span class="text-white display-6"><i
                                class="fa fa-usd fs-1"></i></span>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- col end -->
    <div class="col-sm-6 col-md-6 col-lg-3">
        <div class="card bg-danger">
            <div class="card-body">
                <div class="d-flex no-block align-items-center">
                    <div>
                        <h6 class="text-white">Total de Impostos</h6>
                        <h2 class="text-white m-0 ">{{formatMoney($response->serviceOrder['total_fees'])}}</h2>
                    </div>
                    <div class="ms-auto">
                        <span class="text-white display-6"><i
                                class="fa fa-newspaper-o fs-1"></i></span>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- col end -->
</div>
