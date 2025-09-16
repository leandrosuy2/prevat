<div>
    <form wire:submit="submit" class="form-horizontal my-2">
        <div class="row">
            <div class="col-md-12 col-xl-4">
                <div class="form-group">
                    <div class="input-group">
                        <x-datepicker label="Data Inicial" wire:model.live="filter.start_date"> </x-datepicker>
                        @error('start_date')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="col-md-12 col-xl-4">
                <div class="form-group">
                    <div class="input-group">
                        <x-datepicker label="Data Final" wire:model.live="filter.end_date"> </x-datepicker>
                        @error('end_date')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-xl-4">
                <div class="form-group">
                    <label for="Busca" class="form-label">Busca</label>
                    <input wire:model="filter.search" class="form-control">
                </div>
            </div>
            <div class="col-md-12 col-xl-4 align-content-center mt-1">
                <button type="submit" class="btn btn-sm btn-primary"> Buscar </button>
                <button wire:click="clearFilter()" class="btn btn-sm btn-default"> Limpar </button>
            </div>
        </div>
    </form>
</div>


@section('scripts')

    <script src="{{asset('build/assets/plugins/select2/select2.full.min.js')}}"></script>
    @vite('resources/assets/js/select2.js')

    @vite('resources/assets/js/form-elements.js')

    <!-- FLATPICKER JS -->
    <script src="{{asset('build/assets/plugins/flatpickr/flatpickr.js')}}"></script>
    @vite('resources/assets/js/flatpickr.js')


    <!-- DATEPICKER JS -->
    {{--    <script src="{{asset('build/assets/plugins/spectrum-date-picker/spectrum.js')}}"></script>--}}
    <script src="{{asset('build/assets/plugins/spectrum-date-picker/jquery-ui.js')}}"></script>

@endsection
