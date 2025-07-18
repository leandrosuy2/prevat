<div class="main-sidemenu">
    <div class="slide-left disabled" id="slide-left"><svg xmlns="http://www.w3.org/2000/svg"
                                                          fill="#7b8191" width="24" height="24" viewBox="0 0 24 24">
            <path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z" />
        </svg></div>
    <ul class="side-menu">
        <li class="sub-category">
            <h3>Menu</h3>
        </li>
        <li class="slide">
            <a class="side-menu__item has-link" data-bs-toggle="slide" href="{{route('dashboard')}}"><i
                    class="side-menu__icon fe fe-home"></i><span
                    class="side-menu__label">Dashboard </span>
            </a>
        </li>

        <li class="slide">
            <a class="side-menu__item has-link" data-bs-toggle="slide" href="{{route('schedule')}}"><i
                    class="side-menu__icon mdi mdi-calendar"></i><span
                    class="side-menu__label">Planejamento Semanal </span>
            </a>
        </li>
        
        <li class="slide @if(request()->is('participantes*'))is-expanded @endif">
            <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0)"><i
                    class="side-menu__icon fe fe-package"></i><span
                    class="side-menu__label">Cadastros</span><i
                    class="angle fe fe-chevron-right"></i></a>
            <ul class="slide-menu">
                <li class="panel sidetab-menu">
                    <div class="panel-body tabs-menu-body p-0 border-0">
                        <div class="tab-content active">
                            <div class="tab-pane active">
                                <ul class="sidemenu-list">
                                    <li class="side-menu-label1 active"><a href="javascript:void(0)">Cadastros</a></li>
                                    <li><a href="{{route('client.registration.participant')}}" class="slide-item @if(request()->is('participantes*')) active @endif"> Participante</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </li>

        <li class="slide">
            <a class="side-menu__item has-link" data-bs-toggle="slide" href="{{route('client.certificates')}}"><i
                    class="side-menu__icon fe fe-file-text"></i><span
                    class="side-menu__label">Certificados </span>
            </a>
        </li>

        <li class="slide @if(request()->is('agenda-empresa*'))is-expanded @endif">
            <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0)"><i
                    class="side-menu__icon fe fe-repeat"></i><span
                    class="side-menu__label">Movimentações</span><i
                    class="angle fe fe-chevron-right"></i></a>
            <ul class="slide-menu mega-slide-menu">
                <li class="panel sidetab-menu">
                    <div class="panel-body tabs-menu-body p-0 border-0">
                        <div class="tab-content">
                            <div class="tab-pane active" id="side9">
                                <ul class="sidemenu-list">
                                    <li class="side-menu-label1"><a href="javascript:void(0)">Movimentações</a></li>
                                    <li class="mega-menu">
                                        <div class="">
                                            <ul>
                                                <li><a href="{{route('client.movement.schedule-company')}}" class="slide-item @if(request()->is('agenda-empresa*')) active @endif"> Agenda Empresa</a></li>
                                            </ul>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </li>

        <li class="slide @if(request()->is('relatorios/*'))is-expanded @endif">
            <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0)"><i
                    class="side-menu__icon fe fe-file-text"></i><span
                    class="side-menu__label">Relatórios</span><i
                    class="angle fe fe-chevron-right"></i></a>
            <ul class="slide-menu mega-slide-menu">
                <li class="panel sidetab-menu">
                    <div class="panel-body tabs-menu-body p-0 border-0">
                        <div class="tab-content">
                            <div class="tab-pane active" id="side9">
                                <ul class="sidemenu-list">
                                    <li class="side-menu-label1"><a href="javascript:void(0)">Relatórios</a></li>
                                    <li class="mega-menu">
                                        <div class="">
                                            <ul>
                                                <li><a href="{{route('client.report.participant-training.index')}}" class="slide-item @if(request()->is('relatorios/participantes*')) active @endif"> Participantes</a></li>
                                            </ul>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </li>

        <li class="slide @if(request()->is('sistema*')) is-expanded @endif">
            <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0)"><i
                    class="side-menu__icon fe fe-settings"></i><span
                    class="side-menu__label">Sistema</span><i
                    class="angle fe fe-chevron-right"></i></a>
            <ul class="slide-menu mega-slide-menu">
                <li class="panel sidetab-menu">
                    <div class="panel-body tabs-menu-body p-0 border-0">
                        <div class="tab-content">
                            <div class="tab-pane active" >
                                <ul class="sidemenu-list">
                                    <li class="side-menu-label1"><a href="javascript:void(0)">Sistema</a></li>
                                    <li class="mega-menu">
                                        <div class="">
                                            <ul>
                                                <li><a href="{{route('users')}}" class="slide-item @if(request()->is('sistema/usuarios*')) active @endif"> Usuarios</a></li>
{{--                                                <li><a href="{{url('settings')}}" class="slide-item"> Cor e Logo</a></li>--}}
                                                <li><a href="{{route('company')}}" class="slide-item"> Dados da Empresa</a></li>
                                            </ul>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </li>

    </ul>
    <div class="slide-right" id="slide-right"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191"
                                                   width="24" height="24" viewBox="0 0 24 24">
            <path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z" />
        </svg>
    </div>
</div>
