<div>
    @foreach($response->categories as $itemCategory)
        <li><a href="{{route('courses', $itemCategory['id'])}}"> {{$itemCategory['name']}}</a></li>
    @endforeach
</div>
