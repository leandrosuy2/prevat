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
                    class="side-menu__icon mdi mdi-home"></i><span
                    class="side-menu__label">Dashboard </span>
            </a>
        </li>

        <li class="slide">
            <a class="side-menu__item has-link" data-bs-toggle="slide" href="{{route('schedule')}}"><i
                    class="side-menu__icon mdi mdi-calendar"></i><span
                    class="side-menu__label">Planejamento Semanal </span>
            </a>
        </li>

        <li class="slide @if(request()->is('financeiro/*')) is-expanded @endif">
            <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0)"><i
                    class="side-menu__icon mdi mdi-currency-usd"></i><span
                    class="side-menu__label">Financeiro</span><i
                    class="angle fe fe-chevron-right"></i></a>
            <ul class="slide-menu">
                <li class="panel sidetab-menu">
                    <div class="panel-body tabs-menu-body p-0 border-0">
                        <div class="tab-content active">
                            <div class="tab-pane active">
                                <ul class="sidemenu-list">
                                    <li class="side-menu-label1 active"><a href="javascript:void(0)">Escopos</a></li>
                                    {{--                                    @can('view_professional_qualification')--}}
                                    <li><a href="{{route('financial.releases')}}" class="slide-item @if(request()->is('financeiro/lancamentos*')) active @endif"> Lançamentos</a></li>
                                    {{--                                    @endcan--}}
                                    {{--                                    @can('view_professional')--}}
                                    <li><a href="{{route('financial.service-order')}}" class="slide-item @if(request()->is('financeiro/ordem-de-servico/*')) active @endif"> Ordem de Serviço</a></li>
                                    {{--                                    @endcan--}}

                                    {{--                                    @can('view_professional')--}}
                                    <li><a href="{{route('financial.payment-method')}}" class="slide-item @if(request()->is('financeiro/tipos-de-pagamento/*')) active @endif"> Tipo de Pagamento</a></li>
                                    {{--                                    @endcan--}}
                                </ul>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </li>

        <li class="sub-category">
            <h3>Cadastros</h3>
        </li>

        <li class="slide @if(request()->is('cadastros/*')) is-expanded @endif">
            <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0)"><i
                    class="side-menu__icon mdi mdi-domain"></i><span
                    class="side-menu__label">Escopos</span><i
                    class="angle fe fe-chevron-right"></i></a>
            <ul class="slide-menu">
                <li class="panel sidetab-menu">
                    <div class="panel-body tabs-menu-body p-0 border-0">
                        <div class="tab-content active">
                            <div class="tab-pane active">
                                <ul class="sidemenu-list">
                                    <li class="side-menu-label1 active"><a href="javascript:void(0)">Escopos</a></li>
{{--                                    @can('view_professional_qualification')--}}
                                        <li><a href="{{route('registration.contractors')}}" class="slide-item @if(request()->is('cadastros/contratos*')) active @endif"> Contratantes</a></li>
{{--                                    @endcan--}}
{{--                                    @can('view_professional')--}}
                                        <li><a href="{{route('registration.company')}}" class="slide-item @if(request()->is('cadastros/empresa*')) active @endif"> Empresas</a></li>
{{--                                    @endcan--}}
                                </ul>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </li>

        <li class="slide @if(request()->is('/treinamentos/*')) is-expanded @endif">
            <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0)"><i
                    class="side-menu__icon mdi mdi-school"></i><span
                    class="side-menu__label">Treinamentos</span><i
                    class="angle fe fe-chevron-right"></i></a>
            <ul class="slide-menu">
                <li class="panel sidetab-menu">
                    <div class="panel-body tabs-menu-body p-0 border-0">
                        <div class="tab-content active">
                            <div class="tab-pane active">
                                <ul class="sidemenu-list">
                                    <li class="side-menu-label1 active"><a href="javascript:void(0)">Produtos</a></li>

                                        <li><a href="{{route('registration.training-category')}}" class="slide-item @if(request()->is('treinamentos/categorias*')) active @endif"> Categorias</a></li>

                                    @can('view_training')
                                        <li><a href="{{route('registration.training')}}" class="slide-item @if(request()->is('treinamentos/treinamentos*')) active @endif"> Treinamento</a></li>
                                    @endcan
                                    @can('view_training_room')
                                        <li><a href="{{route('registration.training-room')}}" class="slide-item @if(request()->is('treinamentos/salas-treinamento*')) active @endif"> Salas de Treinamento</a></li>
                                    @endcan
                                    @can('view_training_location')
                                        <li><a href="{{route('registration.training-location')}}" class="slide-item @if(request()->is('treinamentos/locais-treinamento*')) active @endif"> Local de Treinamento</a></li>
                                    @endcan
                                    @can('view_country')
                                        <li><a href="{{route('registration.countries')}}" class="slide-item @if(request()->is('treinamentos/municipios*')) active @endif"> Município</a></li>
                                    @endcan
                                    @can('view_workload')
                                        <li><a href="{{route('registration.workload')}}" class="slide-item @if(request()->is('treinamentos/carga-horaria*')) active @endif"> Carga Horária</a></li>
                                    @endcan
                                    @can('view_time')
                                        <li><a href="{{route('registration.time')}}" class="slide-item @if(request()->is('treinamentos/horarios*')) active @endif"> Horario</a></li>
                                    @endcan()

{{--                                    @can('view_time')--}}
                                        <li><a href="{{route('registration.team')}}" class="slide-item @if(request()->is('treinamentos/turmas*')) active @endif"> Turmas</a></li>
{{--                                    @endcan()--}}
                                </ul>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </li>

        <li class="slide @if(request()->is('profissionais/*')) is-expanded @endif">
            <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0)"><i
                    class="side-menu__icon mdi mdi-account-star"></i><span
                    class="side-menu__label">Profissionais</span><i
                    class="angle fe fe-chevron-right"></i></a>
            <ul class="slide-menu">
                <li class="panel sidetab-menu">
                    <div class="panel-body tabs-menu-body p-0 border-0">
                        <div class="tab-content active">
                            <div class="tab-pane active">
                                <ul class="sidemenu-list">
                                    <li class="side-menu-label1 active"><a href="javascript:void(0)">Profissionais</a></li>
                                    @can('view_professional_qualification')
                                        <li><a href="{{route('registration.professional-qualification')}}" class="slide-item @if(request()->is('profissionais/formacao-profissional*')) active @endif"> Formação do profissional</a></li>
                                    @endcan
                                    @can('view_professional')
                                        <li><a href="{{route('registration.professional')}}" class="slide-item @if(request()->is('profissionais/profissional*')) active @endif"> Profissional</a></li>
                                    @endcan
                                </ul>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </li>

        <li class="slide ">
            <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0)"><i
                    class="side-menu__icon mdi mdi-account-multiple"></i><span
                    class="side-menu__label">Participantes</span><i
                    class="angle fe fe-chevron-right"></i></a>
            <ul class="slide-menu">
                <li class="panel sidetab-menu">
                    <div class="panel-body tabs-menu-body p-0 border-0">
                        <div class="tab-content active">
                            <div class="tab-pane active">
                                <ul class="sidemenu-list">
                                    <li class="side-menu-label1 active"><a href="javascript:void(0)">Participantes</a></li>

                                    @can('view_participant_role')
                                        <li><a href="{{route('registration.participant-role')}}" class="slide-item @if(request()->is('cadastros/funcao-do-participante*')) active @endif"> Função do participante</a></li>
                                    @endcan
                                    @can('view_participant')
                                        <li><a href="{{route('registration.participant')}}" class="slide-item @if(request()->is('/cadastros/participantes')) active @endif"> Participante</a></li>
                                    @endcan
                                </ul>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </li>



        <li class="slide @if(request()->is('movimentacoes/*'))is-expanded @endif">
            <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0)"><i
                    class="side-menu__icon fa-solid fa-retweet"></i><span
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
                                                <li><a href="{{route('movement.schedule-prevat')}}" class="slide-item @if(request()->is('movimentacoes/agenda-prevat*')) active @endif"> Agenda Prevat</a></li>
                                                <li><a href="{{route('movement.schedule-company')}}" class="slide-item @if(request()->is('movimentacoes/agenda-empresa*')) active @endif"> Agenda Empresa</a></li>
                                                <li><a href="{{route('movement.participant-training')}}" class="slide-item @if(request()->is('movimentacoes/treinamento-participante*')) active @endif"> Treinamento do Participante</a></li>
                                                <li><a href="{{route('movement.evidence')}}" class="slide-item @if(request()->is('movimentacoes/evidencia*')) active @endif"> Evidência</a></li>
                                                <li><a href="{{route('movement.withdrawal-protocol')}}" class="slide-item @if(request()->is('movimentacoes/protocolo-retirada*')) active @endif"> Protocolo de Retirada</a></li>
                                                <li><a href="{{route('movement.historic')}}" class="slide-item @if(request()->is('movimentacoes/historico*')) active @endif"> Histórico</a></li>
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

        <li class="slide @if(request()->is('relatorios/*')) is-expanded @endif">
            <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0)"><i
                    class="side-menu__icon fa-solid fa-file-invoice"></i><span
                    class="side-menu__label">Relatórios</span><i
                    class="angle fe fe-chevron-right"></i></a>
            <ul class="slide-menu mega-slide-menu">
                <li class="panel sidetab-menu">
                    <div class="panel-body tabs-menu-body p-0 border-0">
                        <div class="tab-content">
                            <div class="tab-pane active" >
                                <ul class="sidemenu-list">
                                    <li class="side-menu-label1"><a href="javascript:void(0)">Relatórios</a></li>
                                    <li class="mega-menu">
                                        <div class="">
                                            <ul>
                                                <li><a href="{{route('report.participant-training.index')}}" class="slide-item @if(request()->is('relatorios/treinamentos-do-participante*')) active @endif"> Treinamento do participante</a></li>
                                                <li><a href="{{route('report.companies.index')}}" class="slide-item @if(request()->is('relatorios/empresas*')) active @endif"> Empresas</a></li>
                                                <li><a href="{{route('report.trainings.index')}}" class="slide-item @if(request()->is('relatorios/treinamentos*')) active @endif"> Treinamentos</a></li>
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

        @if(auth()->user()->email === 'financeiro@prevat.com.br')
        <li class="slide @if(request()->is('auditoria*')) is-expanded @endif">
            <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0)"><i
                    class="side-menu__icon fe fe-search"></i><span
                    class="side-menu__label">Auditoria</span><i
                    class="angle fe fe-chevron-right"></i></a>
            <ul class="slide-menu mega-slide-menu">
                <li class="panel sidetab-menu">
                    <div class="panel-body tabs-menu-body p-0 border-0">
                        <div class="tab-content">
                            <div class="tab-pane active" >
                                <ul class="sidemenu-list">
                                    <li class="side-menu-label1"><a href="javascript:void(0)">Auditoria</a></li>
                                    <li class="mega-menu">
                                        <div class="">
                                            <ul>
                                                <li><a href="{{route('audit.index')}}" class="slide-item @if(request()->is('auditoria*')) active @endif"> Dashboard de Auditoria</a></li>
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
        @endif

        <li class="slide @if(request()->is('seguranca-do-trabalho/*'))is-expanded @endif">
            <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0)"><i
                    class="side-menu__icon fa-solid fa-screwdriver-wrench"></i><span
                    class="side-menu__label">Segurança do trabalho</span><i
                    class="angle fe fe-chevron-right"></i></a>
            <ul class="slide-menu mega-slide-menu">
                <li class="panel sidetab-menu">
                    <div class="panel-body tabs-menu-body p-0 border-0">
                        <div class="tab-content">
                            <div class="tab-pane active" id="side9">
                                <ul class="sidemenu-list">
                                    <li class="side-menu-label1"><a href="javascript:void(0)">Segurança do trabalho</a></li>
                                    <li class="mega-menu">
                                        <div class="">
                                            <ul>
                                                <li><a href="{{route('work-safety.inspection.index')}}" class="slide-item @if(request()->is('seguranca-do-trabalho/*')) active @endif"> Inspeções </a></li>
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

        <li class="sub-category">
            <h3>Site</h3>
        </li>
{{--        <li class="slide">--}}
{{--            <a class="side-menu__item has-link" data-bs-toggle="slide" href="{{route('manage.banners')}}"><i--}}
{{--                    class="side-menu__icon mdi mdi-monitor"></i><span--}}
{{--                    class="side-menu__label">Banners </span>--}}
{{--            </a>--}}
{{--        </li>--}}
        <li class="slide @if(request()->is('site/blog*')) is-expanded @endif">
            <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0)"><i
                    class="side-menu__icon mdi mdi-account-card-details"></i><span
                    class="side-menu__label">Blog</span><i
                    class="angle fe fe-chevron-right"></i></a>
            <ul class="slide-menu mega-slide-menu">
                <li class="panel sidetab-menu">
                    <div class="panel-body tabs-menu-body p-0 border-0">
                        <div class="tab-content">
                            <div class="tab-pane active" >
                                <ul class="sidemenu-list">
                                    <li class="side-menu-label1"><a href="javascript:void(0)">Blog</a></li>
                                    <li class="mega-menu">
                                        <div class="">
                                            <ul>
                                                <li><a href="{{route('manage.blog-categories.blog')}}" class="slide-item @if(request()->is('site/blog-categorias*')) active @endif"> Categorias</a></li>
                                                <li><a href="{{route('manage.blog')}}" class="slide-item @if(request()->is('site/blog*')) active @endif"> Posts</a></li>
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

        <li class="slide @if(request()->is('site/produtos*')) is-expanded @endif">
            <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0)"><i
                    class="side-menu__icon mdi mdi-apps"></i><span
                    class="side-menu__label">Produtos</span><i
                    class="angle fe fe-chevron-right"></i></a>
            <ul class="slide-menu mega-slide-menu">
                <li class="panel sidetab-menu">
                    <div class="panel-body tabs-menu-body p-0 border-0">
                        <div class="tab-content">
                            <div class="tab-pane active" >
                                <ul class="sidemenu-list">
                                    <li class="side-menu-label1"><a href="javascript:void(0)">Produtos</a></li>
                                    <li class="mega-menu">
                                        <div class="">
                                            <ul>
                                                <li><a href="{{route('manage.product-categories.index')}}" class="slide-item @if(request()->is('site/produtos-categorias*')) active @endif"> Categorias</a></li>
                                                <li><a href="{{route('manage.product.index')}}" class="slide-item @if(request()->is('site/produtos*')) active @endif"> Produtos</a></li>
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

        <li class="slide">
            <a class="side-menu__item has-link" data-bs-toggle="slide" href="{{route('manage.contact')}}"><i
                    class="side-menu__icon mdi mdi-phone"></i><span
                    class="side-menu__label">Contatos </span>
            </a>
        </li>

        <li class="slide">
            <a class="side-menu__item has-link" data-bs-toggle="slide" href="{{route('manage.consultancy')}}"><i
                    class="side-menu__icon fe fe-message-circle"></i><span
                    class="side-menu__label">Consultoria </span>
            </a>
        </li>

        <li class="slide">
            <a class="side-menu__item has-link" data-bs-toggle="slide" href="{{route('manage.information')}}"><i
                    class="side-menu__icon fe fe-file-text"></i><span
                    class="side-menu__label">Informações Gerais </span>
            </a>
        </li>
        <li class="sub-category">
            <h3>Configurações</h3>
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
                                                <li><a href="{{route('permissions')}}" class="slide-item @if(request()->is('sistema/permissoes*')) active @endif" > Permissões</a></li>
                                                <li><a href="{{route('users')}}" class="slide-item @if(request()->is('sistema/usuarios*')) active @endif"> Usuarios</a></li>
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
        </svg></div>
</div>
