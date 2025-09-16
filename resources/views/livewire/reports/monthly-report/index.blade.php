<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fa fa-chart-line me-2"></i>
                    Relatório Mensal de Treinamentos
                </h3>
            </div>
            <div class="card-body">
                <form wire:submit.prevent="export">
                    <div class="row">
                        <!-- Data Inicial -->
                        <div class="col-md-6 mb-3">
                            <label for="startDate" class="form-label">
                                <i class="fa fa-calendar me-1"></i>
                                Data Inicial <span class="text-danger">*</span>
                            </label>
                            <input type="date" 
                                   class="form-control @error('startDate') is-invalid @enderror" 
                                   id="startDate"
                                   wire:model="startDate">
                            @error('startDate')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Data Final -->
                        <div class="col-md-6 mb-3">
                            <label for="endDate" class="form-label">
                                <i class="fa fa-calendar me-1"></i>
                                Data Final <span class="text-danger">*</span>
                            </label>
                            <input type="date" 
                                   class="form-control @error('endDate') is-invalid @enderror" 
                                   id="endDate"
                                   wire:model="endDate">
                            @error('endDate')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Treinamento (opcional) -->
                        <div class="col-12 mb-3">
                            <label for="trainingId" class="form-label">
                                <i class="fa fa-graduation-cap me-1"></i>
                                Treinamento (opcional)
                            </label>
                            <select class="form-select @error('trainingId') is-invalid @enderror" 
                                    id="trainingId"
                                    wire:model="trainingId">
                                <option value="">Todos os treinamentos</option>
                                @foreach($trainings as $training)
                                    <option value="{{ $training->id }}">{{ $training->name }} ({{ $training->acronym }})</option>
                                @endforeach
                            </select>
                            @error('trainingId')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Seções a incluir -->
                        <div class="col-12 mb-4">
                            <label class="form-label">
                                <i class="fa fa-list me-1"></i>
                                Seções a incluir:
                            </label>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" 
                                               type="checkbox" 
                                               id="trainings"
                                               wire:model="sections.trainings">
                                        <label class="form-check-label" for="trainings">
                                            <i class="fa fa-chart-bar me-1 text-primary"></i>
                                            Treinamentos ministrados
                                        </label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" 
                                               type="checkbox" 
                                               id="companies"
                                               wire:model="sections.companies">
                                        <label class="form-check-label" for="companies">
                                            <i class="fa fa-building me-1 text-success"></i>
                                            Empresas atendidas
                                        </label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" 
                                               type="checkbox" 
                                               id="extra_classes"
                                               wire:model="sections.extra_classes">
                                        <label class="form-check-label" for="extra_classes">
                                            <i class="fa fa-plus-circle me-1 text-warning"></i>
                                            Turmas extras
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" 
                                               type="checkbox" 
                                               id="cards_delivered"
                                               wire:model="sections.cards_delivered">
                                        <label class="form-check-label" for="cards_delivered">
                                            <i class="fa fa-id-card me-1 text-info"></i>
                                            Cartões e Cartas entregues
                                        </label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" 
                                               type="checkbox" 
                                               id="improvements"
                                               wire:model="sections.improvements">
                                        <label class="form-check-label" for="improvements">
                                            <i class="fa fa-tools me-1 text-danger"></i>
                                            Melhorias do mês
                                        </label>
                                    </div>
                                </div>
                            </div>
                            @error('sections')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Formato de exportação -->
                        <div class="col-12 mb-4">
                            <label class="form-label">
                                <i class="fa fa-download me-1"></i>
                                Formato de exportação:
                            </label>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" 
                                               type="radio" 
                                               id="pdf"
                                               value="pdf"
                                               wire:model="exportFormat">
                                        <label class="form-check-label" for="pdf">
                                            <i class="fa fa-file-pdf me-1 text-danger"></i>
                                            PDF
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" 
                                               type="radio" 
                                               id="excel"
                                               value="excel"
                                               wire:model="exportFormat">
                                        <label class="form-check-label" for="excel">
                                            <i class="fa fa-file-excel me-1 text-success"></i>
                                            Excel
                                        </label>
                                    </div>
                                </div>
                            </div>
                            @error('exportFormat')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Botões -->
                        <div class="col-12">
                            <div class="d-flex gap-2">
                                <button type="submit" 
                                        class="btn btn-primary"
                                        wire:loading.attr="disabled">
                                    <span wire:loading.remove wire:target="export">
                                        <i class="fa fa-download me-1"></i>
                                        Exportar Relatório
                                    </span>
                                    <span wire:loading wire:target="export">
                                        <i class="fa fa-spinner fa-spin me-1"></i>
                                        Exportando...
                                    </span>
                                </button>
                                
                                <button type="button" 
                                        class="btn btn-secondary"
                                        wire:click="$set('startDate', '{{ now()->startOfMonth()->format('Y-m-d') }}'); $set('endDate', '{{ now()->endOfMonth()->format('Y-m-d') }}')">
                                    <i class="fa fa-calendar me-1"></i>
                                    Mês Atual
                                </button>
                                
                                <button type="button" 
                                        class="btn btn-outline-secondary"
                                        wire:click="$set('startDate', '{{ now()->subMonth()->startOfMonth()->format('Y-m-d') }}'); $set('endDate', '{{ now()->subMonth()->endOfMonth()->format('Y-m-d') }}')">
                                    <i class="fa fa-calendar-minus me-1"></i>
                                    Mês Anterior
                                </button>
                            </div>
                        </div>
                    </div>
                </form>

                <!-- Preview das seções selecionadas -->
                @if(array_filter($sections))
                    <div class="mt-4">
                        <h5 class="text-muted mb-3">
                            <i class="fa fa-eye me-1"></i>
                            Seções que serão incluídas no relatório:
                        </h5>
                        <div class="row">
                            @if($sections['trainings'])
                                <div class="col-md-6 col-lg-4 mb-2">
                                    <div class="alert alert-primary mb-0 py-2">
                                        <i class="fa fa-chart-bar me-1"></i>
                                        <strong>Quantidade de Treinamentos ministrados no mês (Cronograma do Mês)</strong>
                                    </div>
                                </div>
                            @endif
                            
                            @if($sections['extra_classes'])
                                <div class="col-md-6 col-lg-4 mb-2">
                                    <div class="alert alert-warning mb-0 py-2">
                                        <i class="fa fa-plus-circle me-1"></i>
                                        <strong>Quantidade de Turmas Extras no mês</strong>
                                    </div>
                                </div>
                            @endif
                            
                            @if($sections['companies'])
                                <div class="col-md-6 col-lg-4 mb-2">
                                    <div class="alert alert-success mb-0 py-2">
                                        <i class="fa fa-building me-1"></i>
                                        <strong>Quantidade de empresas atendidas no mês</strong>
                                    </div>
                                </div>
                            @endif
                            
                            @if($sections['cards_delivered'])
                                <div class="col-md-6 col-lg-4 mb-2">
                                    <div class="alert alert-info mb-0 py-2">
                                        <i class="fa fa-id-card me-1"></i>
                                        <strong>Cartões e Cartas entregues no mês</strong>
                                    </div>
                                </div>
                            @endif
                            
                            @if($sections['improvements'])
                                <div class="col-md-6 col-lg-4 mb-2">
                                    <div class="alert alert-danger mb-0 py-2">
                                        <i class="fa fa-tools me-1"></i>
                                        <strong>Quantidade de melhorias do mês (Processo/Instalação)</strong>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
