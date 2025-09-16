<div>
    <div class="page-header d-sm-flex d-block">
        <ol class="breadcrumb mb-sm-0 mb-3">
            <!-- breadcrumb -->
            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Agenda Semanal</li>
{{--            <li class="breadcrumb-item active" aria-current="page">{{ formatDate($date->startOfWeek()) }} a {{ formatDate($date->endOfWeek()) }} </li>--}}
        </ol><!-- End breadcrumb -->


        @if(auth()->user()->company->type == 'admin')
            <div class="d-flex align-items-end gap-3">
                @livewire('components.selects.contracts.form')
                @livewire('components.selects.companies.form')
            </div>
        @endif


        <div class="ms-auto">
            <div>
                <button wire:click="previous" class="btn bg-primary-transparent text-primary mx-2 btn-sm"
                   data-bs-toggle="tooltip" title="" data-bs-placement="bottom"
                   data-bs-original-title="Voltar">
                    <span>
                        <i class="fa fa-backward"></i>
                    </span>
                </button>

                <button wire:click.prevent="next" class="btn bg-primary-transparent text-primary mx-2 btn-sm"
                        data-bs-toggle="tooltip" title="" data-bs-placement="bottom"
                        data-bs-original-title="Avançar">
                    <span>
                        <i class="fa fa-forward"></i>
                    </span>
                </button>

            </div>
        </div>
    </div>

    @livewire('schedule.card')

</div>
