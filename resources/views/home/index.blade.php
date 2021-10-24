@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-12">
        <x-pier-data model="Chef">
            @verbatim
                <div class="mb-6 py-4 px-6 flex items-center justify-between bg-gray-100 rounded">
                    <h2 class="text-xl font-semibold">Chefs</h2>

                    <x-pier-search-bar
                        class="border w-72 px-5 py-2"
                        placeholder="Type to search for chefs..."
                    />
                </div>
                <div class="grid grid-cols-4 gap-6">
                    @foreach ($data as $chef)
                        <a href="{{url('/chef/'.$chef->_id)}}" class="hover:bg-gray-100 rounded border py-6 px-3 flex flex-col items-center text-center">
                            <img class="w-40 h-40 object-cover rounded-full" src="{{$chef->picture}}" alt="" />
                            <h5 class="mt-3">{{ $chef->name }}</h5>
                        </a>
                    @endforeach
                </div>
            @endverbatim
        </x-pier-data>
    </div>
@endsection

@section('scripts')
    <script src="//unpkg.com/alpinejs" defer></script>
@endsection