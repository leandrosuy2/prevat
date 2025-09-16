<div>
    <div class="row">
        <div class="col-12 col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title fs-14">Imagens Cadastradas para : {{ $product['name'] }}</h3>
                    {{--                    @can('add_time')--}}
                    <button class="btn btn-sm btn-secondary" type="button" wire:click.prevent="openSlide('manage.product-images.form', { 'id' : {{$product['id']}} })"><i class="fa fa-plus"></i> Cadastrar</button>                    {{--                    @endcan--}}
                </div>

                <div class="card-body" style="z-index: 5">

                    @include('includes.alerts')

                    <div class="row">
                        @foreach($response->images as $itemImage)
                        <div class="col-md-12 col-lg-3">
                            <div class="thumbnail mb-lg-0">
                                <a href="javascript:void(0);">
                                    <img src="{{asset('storage/'.$itemImage['path'])}}" alt="thumb1"
                                         class="thumbimg">
                                </a>
                                <div class="caption">
                                    <h4><strong>{{$itemImage['name']}}</strong></h4>
                                    <p></p>
                                    <div class=" align-content-center">
                                        <button class="btn btn-icon btn-danger" onclick='modalDelete({{$itemImage}})' >
                                            <i class="fe fe-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    function modalDelete(data) {
        $('#nomeUsuario').text(data.name);
        $('#idUsuario').text(data.id);
        $('#confirmDelete').text('confirmDeleteImageProduct');
        $('#Vertically').modal('show');
    }
</script>


