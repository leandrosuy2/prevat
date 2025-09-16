@if(session('success'))
    <div class="card text-white bg-gradient-success">
        <div class="card-body">
            <h4 class="card-title">Sucesso !</h4>
            <p class="card-text">{{ session('success') }}</p>
        </div>
    </div>
@endif

@if(session('error'))
    <div class="card text-white bg-danger ">
        <div class="card-body">
            <h4 class="card-title">Erro !</h4>
            <p class="card-text"> {{ session('error') }}</p>
        </div>
    </div>
@endif




