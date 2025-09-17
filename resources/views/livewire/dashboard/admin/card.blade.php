<div>
    <!-- ROW -->
    <div class="row mb-3">
        <div class="col-md-3 col-sm-6 mb-2">
            <label class="form-label mb-1">Data inicial</label>
            <input type="date" class="form-control" wire:model.defer="startDate" wire:change="$refresh">
        </div>
        <div class="col-md-3 col-sm-6 mb-2">
            <label class="form-label mb-1">Data final</label>
            <input type="date" class="form-control" wire:model.defer="endDate" wire:change="$refresh">
        </div>
    </div>
    
    <!-- ROW -->
    <div class="row">
        <div class="col-12">
            @livewire('dashboard.admin.info.card', ['startDate' => $startDate, 'endDate' => $endDate])
        </div>
    </div>
    <!-- END ROW -->
    <div class="row">
        <div class="col-12">
            @livewire('dashboard.admin.graph01.card', ['startDate' => $startDate, 'endDate' => $endDate])
        </div>
    </div>
    <!-- END ROW -->

    <!-- ROW -->
    <div class="row">
        <div class="col-xl-5 col-lg-12 col-md-12">
            @livewire('dashboard.admin.evidences.card')
        </div>
        <div class="col-xl-4 col-lg-12 col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title fs-14">Browser Usage</h3>
                    <div class="dropdown">
                        <ul class="dropdown-menu dropdown-menu-end" role="menu">
                            <li><a href="javascript:void(0);">Seconds</a></li>
                            <li><a href="javascript:void(0);">Minutes</a></li>
                            <li><a href="javascript:void(0);">Hours</a></li>
                        </ul>
                    </div>
                </div>
                <!-- card-header -->
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table border-0 mb-0 text-nowrap">
                            <thead class="bg-light border-bottom-0">
                            <tr>
                                <th class="border-top-0 text-dark fw-semibold ps-5 fs-13">Browser</th>
                                <th class="border-top-0 text-dark fw-semibold fs-13">Sessions</th>
                                <th class="border-top-0 text-dark fw-semibold text-end pe-5 fs-13">Bounce Rate</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr class="border-bottom">
                                <td class="ps-5 d-flex align-items-center border-bottom-0">
                                    <img alt="browser-image" class="avatar br-7 me-2" src="{{asset('build/assets/images/browsers/1.png')}}">
                                    <p class="fw-semibold text-dark mb-0">Chrome</p>
                                </td>
                                <td>
                                    <h6 class="mb-1 mt-1 text-dark fw-semibold">26,230</h6>
                                </td>
                                <td class="text-end pe-5">
                                    <span class="fw-semibold"><i class="fe fe-arrow-up text-success me-1"></i>86.29%</span>
                                    <div class="progress progress-md h-1">
                                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-primary w-85">
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr class="border-bottom">
                                <td class="ps-5 d-flex align-items-center border-bottom-0">
                                    <img alt="browser-image" class="avatar br-7 me-2" src="{{asset('build/assets/images/browsers/4.png')}}">
                                    <p class="fw-semibold text-dark mb-0">Opera</p>
                                </td>
                                <td>
                                    <h6 class="mb-1 mt-1 text-dark fw-semibold">12,420</h6>
                                </td>
                                <td class="text-end pe-5">
                                    <span class="fw-semibold"><i class="fe fe-arrow-down text-danger me-1"></i>42.05%</span>
                                    <div class="progress progress-md h-1">
                                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-primary w-40">
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr class="border-bottom">
                                <td class="ps-5 d-flex align-items-center border-bottom-0">
                                    <img alt="browser-image" class="avatar br-7 me-2" src="{{asset('build/assets/images/browsers/5.png')}}">
                                    <p class="fw-semibold text-dark mb-0">Safari</p>
                                </td>
                                <td>
                                    <h6 class="mb-1 mt-1 text-dark fw-semibold">23,120</h6>
                                </td>
                                <td class="text-end pe-5">
                                    <span class="fw-semibold"><i class="fe fe-arrow-up text-success me-1"></i>30.52%</span>
                                    <div class="progress progress-md h-1">
                                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-primary w-35">
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr class="border-bottom">
                                <td class="ps-5 d-flex align-items-center border-bottom-0">
                                    <img alt="browser-image" class="avatar br-7 me-2" src="{{asset('build/assets/images/browsers/3.png')}}">
                                    <p class="fw-semibold text-dark mb-0">Firefox</p>
                                </td>
                                <td>
                                    <h6 class="mb-1 mt-1 text-dark fw-semibold">42,021</h6>
                                </td>
                                <td class="text-end pe-5">
                                    <span class="fw-semibold"><i class="fe fe-arrow-up text-success me-1"></i>26.65%</span>
                                    <div class="progress progress-md h-1">
                                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-primary w-25">
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr class="border-bottom-0">
                                <td class="ps-5 d-flex align-items-center border-bottom-0">
                                    <img alt="browser-image" class="avatar br-7 me-2" src="{{asset('build/assets/images/browsers/2.png')}}">
                                    <p class="fw-semibold text-dark mb-0">Edge</p>
                                </td>
                                <td>
                                    <h6 class="mb-1 mt-1 text-dark fw-semibold">20,402</h6>
                                </td>
                                <td class="text-end pe-5">
                                    <span class="fw-semibold"><i class="fe fe-arrow-down text-danger me-1"></i>34.12%</span>
                                    <div class="progress progress-md h-1">
                                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-primary w-35">
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-12 col-md-12">
            @livewire('dashboard.admin.graph02.card')
        </div>
    </div>
    <!-- END ROW -->

    <!-- ROW -->
    <div class="row">
        <div class="col-12 col-sm-12">
            @livewire('dashboard.admin.schedules.card')

        </div>
    </div>
    <!-- END ROW -->
</div>
