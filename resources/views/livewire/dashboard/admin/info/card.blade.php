<div>
    <div class="row mb-3">
        <div class="col-12 text-end">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exportModal">
                <i class="fa fa-file-pdf-o"></i> Exportar dados
            </button>
        </div>
    </div>

    <!-- Modal de Exportação -->
    <div class="modal fade" id="exportModal" tabindex="-1" aria-labelledby="exportModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exportModalLabel">Exportar Relatório</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('dashboard.exportar-dados') }}" method="GET" target="_blank">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="start_date" class="form-label">Data Inicial</label>
                                    <input type="date" class="form-control" id="start_date" name="start_date" 
                                           value="{{ $startDate ?? now()->startOfMonth()->format('Y-m-d') }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="end_date" class="form-label">Data Final</label>
                                    <input type="date" class="form-control" id="end_date" name="end_date" 
                                           value="{{ $endDate ?? now()->endOfMonth()->format('Y-m-d') }}" required>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="training_id" class="form-label">Treinamento (opcional)</label>
                            <select class="form-control" id="training_id" name="training_id">
                                <option value="">Todos os treinamentos</option>
                                @foreach($trainings as $training)
                                    <option value="{{ $training->id }}">{{ $training->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="contractor_filter" class="form-label">Contratante</label>
                            <select class="form-control" id="contractor_filter" name="contractor_filter">
                                <option value="">Todos</option>
                                <option value="alunorte">Alunorte</option>
                                <option value="prevat">Prevat</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Seções a incluir:</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="include_trainings" name="sections[]" value="trainings" checked>
                                <label class="form-check-label" for="include_trainings">
                                    Treinamentos ministrados
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="include_companies" name="sections[]" value="companies" checked>
                                <label class="form-check-label" for="include_companies">
                                    Empresas atendidas
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="include_extra_classes" name="sections[]" value="extra_classes" checked>
                                <label class="form-check-label" for="include_extra_classes">
                                    Turmas extras
                                </label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Formato de exportação:</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" id="format_pdf" name="format" value="pdf" checked>
                                <label class="form-check-label" for="format_pdf">
                                    <i class="fa fa-file-pdf-o"></i> PDF
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" id="format_excel" name="format" value="excel">
                                <label class="form-check-label" for="format_excel">
                                    <i class="fa fa-file-excel-o"></i> Excel
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary" id="exportButton">
                            <i class="fa fa-download"></i> <span id="exportText">Gerar PDF</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const formatRadios = document.querySelectorAll('input[name="format"]');
            const exportButton = document.getElementById('exportButton');
            const exportText = document.getElementById('exportText');
            const exportIcon = exportButton.querySelector('i');

            function updateButtonText() {
                const selectedFormat = document.querySelector('input[name="format"]:checked').value;
                
                if (selectedFormat === 'excel') {
                    exportText.textContent = 'Gerar Excel';
                    exportIcon.className = 'fa fa-file-excel-o';
                } else {
                    exportText.textContent = 'Gerar PDF';
                    exportIcon.className = 'fa fa-file-pdf-o';
                }
            }

            // Atualizar quando a página carrega
            updateButtonText();

            // Atualizar quando o usuário muda a seleção
            formatRadios.forEach(radio => {
                radio.addEventListener('change', updateButtonText);
            });
        });
    </script>
    <div class="row">
        <!-- Card: Treinamentos ministrados no mês -->
        <div class="col-12 col-md-4 mb-3">
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
        <div class="col-12 col-md-4 mb-3">
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
        <div class="col-12 col-md-4 mb-3">
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
    </div>
    <!-- <div class="row row-sm">
        <div class="col-12">
            <div class="card overflow-hidden">
                <div class="card-header pb-0 border-bottom-0">
                    <h3 class="card-title fs-14">Treinamentos mais agendados</h3>
                </div>
                <div class="card-body pt-0">
                    <div class="d-block d-sm-inline-flex align-items-center my-3">
                        <p class="mb-0 me-5"> <span class="legend bg-blue"></span>Marketing Strategy</p>
                        <p class="mb-0 me-5"> <span class="legend bg-teal"></span>Engaging Audience</p>
                        <p class="mb-0 me-5"> <span class="legend bg-pink"></span>Others</p>
                    </div>
                    <div class="progress br-10 progress-md">
                        <div class="progress-bar lh-1 bg-blue w-20">20%</div>
                        <div class="progress-bar lh-1 bg-cyan w-30">30%</div>
                        <div class="progress-bar lh-1 bg-pink w-50">50%</div>
                    </div>
                </div>
            </div>
        </div>
    </div> -->
</div>
