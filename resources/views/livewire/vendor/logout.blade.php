<div>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <a class="dropdown-item text-dark fw-semibold" href="{{ route('logout') }}"
           onclick="event.preventDefault();
                                        this.closest('form').submit();" >
            <i class="dropdown-icon fe fe-log-out"></i>  Sair
        </a>
    </form>
</div>
