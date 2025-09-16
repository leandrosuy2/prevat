@extends('layouts.app')

@section('title', 'Relatório Mensal de Treinamentos')

@section('content')
    <!-- PAGE HEADER -->
    <div class="page-header d-sm-flex d-block">
        <ol class="breadcrumb mb-sm-0 mb-3">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('reports.index') }}">Relatórios</a></li>
            <li class="breadcrumb-item active" aria-current="page">Relatório Mensal</li>
        </ol>
        <div class="ms-auto">
            <div>
                <a href="{{ route('reports.index') }}" class="btn bg-secondary-transparent text-secondary btn-sm"
                   data-bs-toggle="tooltip" title="Voltar para Relatórios">
                    <span><i class="fa fa-arrow-left"></i></span>
                </a>
            </div>
        </div>
    </div>
    <!-- END PAGE HEADER -->

    @livewire('reports.monthly-report.index')

@endsection

@section('scripts')
    <script>
        // Auto-focus no primeiro campo
        document.addEventListener('DOMContentLoaded', function() {
            const startDateInput = document.getElementById('startDate');
            if (startDateInput) {
                startDateInput.focus();
            }
        });

        // Validação de datas
        document.addEventListener('livewire:init', () => {
            Livewire.on('validation-error', (errors) => {
                // Scroll para o primeiro erro
                const firstError = document.querySelector('.is-invalid');
                if (firstError) {
                    firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    firstError.focus();
                }
            });
        });
    </script>
@endsection
