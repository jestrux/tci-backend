<aside class="flex-shrink-0">
    <div class="long-header bg-blue-100 text-blue-800 tracking-wider">
        <img class="mb-2" style="height:50px; margin-left: -8px" src="{{asset('img/logo.png')}}" alt="">
        Global Compact
    </div>
    <ul>
        @foreach ($models as $model)    
            <li class="">
                <a href="#/{{$model->name}}">
                    {{ $model->name }}
                </a>
            </li>
        @endforeach
    </ul>
</aside>