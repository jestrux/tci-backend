@extends('layouts.app')

@section('content')
    <section class="bg-gray-200 py-10">
        <div class="container mx-auto">
            <x-pier-data model="Chef" :rowId="$id">
                @verbatim
                    <div class="flex flex-col items-center">
                        <img class="border-4 border-white mb-3 w-20 h-20 object-cover rounded-full" src="{{$data->picture}}" alt="" />

                        <h2 class="text-3xl font-semibold">{{ $data->name }}</h2>
                    </div>
                @endverbatim
            </x-pier-data>
        </div>
    </section>

    <section class="py-10">
        <div class="container mx-auto">
            <x-pier-data model="Lesson" :filters="['chef' => $id]">
                @verbatim
                    <div class="mb-6 py-4 px-6 flex items-center justify-between bg-gray-100 rounded">
                        <h2 class="text-xl font-semibold">Chef's Lessons</h2>

                        <div class="flex items-center">
                            <span class="mr-4">Duration: </span>

                            <x-pier-filter 
                                field="duration" 
                                comparison="lessThan"
                                value="100"
                                class="border border-black px-4 py-1 rounded-sm mr-2"
                                activeClass="bg-black text-white"
                            >
                                Short
                            </x-pier-filter>

                            <x-pier-search-bar
                                class="border w-72 px-5 py-2"
                                placeholder="Type to search lessons..."
                            />
                        </div>
                    </div>

                    <div class="grid grid-cols-3 gap-6">
                        @foreach ($data as $lesson)
                            <a href="{{url('/lesson/'.$lesson->_id)}}" class="hover:bg-gray-100 rounded border pt-3 pb-4 px-3 flex flex-col">
                                <img class="w-full h-56 object-cover rounded" src="{{$lesson->poster}}" alt="" />
                                <h5 class="ml-1 mt-3">{{ $lesson->title }}</h5>
                                <p class="ml-1 mt-3">{{ $lesson->duration }}</p>
                            </a>
                        @endforeach
                    </div>
                @endverbatim
            </x-pier-data>
        </div>
    </section>
@endsection

@section('scripts')
    <script src="//unpkg.com/alpinejs" defer></script>
@endsection