<div>
    <div class="row">
        <div class="col-12 col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title fs-14">Lista de Permissões de : {{ $role['name'] }}</h3>
                    <a href=" {{ route('permissions.create') }}" class="fw-semibold btn btn-sm btn-primary"><i class="fe fe-plus-circle"></i> Nova permissão

                    </a>
                </div>

                <div class="card-body">
                    <form wire:submit="submit">
                        <div class="row">
                            <div class="col-md-12 col-xl-6">
                                <h5 class="card-sub-title text-primary">
                                    Permissões para a gestão de cadastros.
                                </h5>
                                @foreach($response->permissions as $itemGroupPermission)
                                    @if(str_contains($itemGroupPermission['name'], 'Cadastro') && !str_contains($itemGroupPermission['name'], 'Sistema'))
                                        <div class="panel-group1" id="accordion1">
                                            <div class="panel panel-default mb-4">
                                                <div class="panel-heading1 br-7">
                                                    <h4 class="panel-title1">
                                                        <a class="accordion-toggle collapsed" data-bs-toggle="collapse"
                                                           data-bs-parent="#accordion" href="#collapse{{$itemGroupPermission['id']}}"
                                                           aria-expanded="false"> {{$itemGroupPermission['name']}}</a>
                                                    </h4>
                                                </div>
                                                <div id="collapse{{$itemGroupPermission['id']}}" class="panel-collapse collapse" role="tabpanel"
                                                     aria-expanded="false">
                                                    <div class="panel-body">
                                                        <div class="form-group">
                                                        @foreach($itemGroupPermission['permissions'] as $itemPermission)
                                                            <div class="form-label"></div>
                                                            <label class="custom-switch">
                                                                <input type="checkbox" value="{{$itemPermission['name']}}" wire:model="permissions" name="custom-switch-checkbox"
                                                                       class="custom-switch-input">
                                                                <span class="custom-switch-indicator"></span>
                                                                <span class="custom-switch-description">{{$itemPermission['label']}}</span>
                                                            </label>
                                                        @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                    </div>
                                    @endif
                                @endforeach
                            </div>

                            <div class="col-md-12 col-xl-6">
                                <h5 class="card-sub-title text-primary bold">
                                    Permissões para a gestão de movimentações.
                                </h5>
                                @foreach($response->permissions as $itemGroupPermission)
                                    @if(str_contains($itemGroupPermission['name'], 'Gestão'))
                                        <div class="panel-group1" id="accordion1">
                                            <div class="panel panel-default mb-4">
                                                <div class="panel-heading1 br-7">
                                                    <h4 class="panel-title1">
                                                        <a class="accordion-toggle collapsed" data-bs-toggle="collapse"
                                                           data-bs-parent="#accordion" href="#collapse{{$itemGroupPermission['id']}}"
                                                           aria-expanded="false"> {{$itemGroupPermission['name']}}</a>
                                                    </h4>
                                                </div>
                                                <div id="collapse{{$itemGroupPermission['id']}}" class="panel-collapse collapse" role="tabpanel"
                                                     aria-expanded="false">
                                                    <div class="panel-body">
                                                        <div class="form-group">
                                                            @foreach($itemGroupPermission['permissions'] as $itemPermission)
                                                                <div class="form-label"></div>
                                                                <label class="custom-switch">
                                                                    <input type="checkbox" value="{{$itemPermission['name']}}" wire:model="permissions" name="custom-switch-checkbox"
                                                                           class="custom-switch-input">
                                                                    <span class="custom-switch-indicator"></span>
                                                                    <span class="custom-switch-description">{{$itemPermission['label']}}</span>
                                                                </label>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                                <h5 class="card-sub-title text-primary">
                                    Permissões para a gestão de usuários e permissões.
                                </h5>
                                @foreach($response->permissions as $itemGroupPermission)
                                    @if(str_contains($itemGroupPermission['name'], 'Sistema'))
                                        <div class="panel-group1" id="accordion1">
                                            <div class="panel panel-default mb-4">
                                                <div class="panel-heading1 br-7">
                                                    <h4 class="panel-title1">
                                                        <a class="accordion-toggle collapsed" data-bs-toggle="collapse"
                                                           data-bs-parent="#accordion" href="#collapse{{$itemGroupPermission['id']}}"
                                                           aria-expanded="false"> {{$itemGroupPermission['name']}}</a>
                                                    </h4>
                                                </div>
                                                <div id="collapse{{$itemGroupPermission['id']}}" class="panel-collapse collapse" role="tabpanel"
                                                     aria-expanded="false">
                                                    <div class="panel-body">
                                                        <div class="form-group">
                                                            @foreach($itemGroupPermission['permissions'] as $itemPermission)
                                                                <div class="form-label"></div>
                                                                <label class="custom-switch">
                                                                    <input type="checkbox" value="{{$itemPermission['name']}}" wire:model="permissions" name="custom-switch-checkbox"
                                                                           class="custom-switch-input">
                                                                    <span class="custom-switch-indicator"></span>
                                                                    <span class="custom-switch-description">{{$itemPermission['label']}}</span>
                                                                </label>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>




                        <div class="pt-3">
                            <button type="submit" class="btn btn-primary"> Atualizar </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
