<div>
    <div class="sidebar">
        <div class="sidebar__single sidebar__category">
            <h3 class="sidebar__title">Categorias</h3>
            <ul class="sidebar__category-list list-unstyled">
                @foreach($response->categories as $itemCategory)
                    <li><a href="javascript:void(0);" wire:click="filterBlog({{$itemCategory['id']}})"> {{$itemCategory['name']}}</a></li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
