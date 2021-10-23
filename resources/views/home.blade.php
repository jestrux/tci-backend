@extends('layouts.app')

@section('content')
    <section class="py-12 px-12">
        <div class="container mx-auto">
            <x-pier-data model="Speaker">
                @verbatim    
                    <div class="flex items-center justify-between mb-8">
                        <h2 class="text-youlead-primary text-3xl font-semibold">
                            Speakers
                        </h2>

                        <x-pier-search-bar 
                            class="border px-3 py-1" 
                            placeholder="Type to search speakers"
                        />
                    </div>
                    <div class="grid grid-cols-4 gap-6">
                        @foreach($data as $speaker)
                            <div class="border py-4 flex flex-col items-center text-center">
                                <img class="h-40 w-40 rounded-full object-cover" src="{{$speaker->dp}}" alt=""/>
                                <h5 class="mt-2 text-lg font-semibold">
                                    {{ $speaker->full_name }}
                                </h5>
                            </div>
                        @endforeach
                    </div>
                @endverbatim
            </x-pier-data>
        </div>
    </section>
    <section class="py-12 px-12 bg-gray-100">
        <div class="container mx-auto">
            <x-pier-data model="Event">
                @verbatim    
                    <div class="flex items-center justify-between mb-8">
                        <h2 class="text-youlead-primary text-3xl font-semibold">
                            Events
                        </h2>

                        <div class="flex items-center">
                            <span class="mr-4">Country: </span>

                            <div class="flex items-center border-t border-b border-r rounded overflow-hidden">
                                <x-pier-filter
                                    class="border-l px-3 py-1" 
                                    activeClass="bg-blue-500 text-white"
                                    field="country"
                                >
                                    All
                                </x-pier-filter>
    
                                <x-pier-filter
                                    class="border-l px-3 py-1" 
                                    activeClass="bg-blue-500 text-white"
                                    field="country"
                                    value="Tanzania"
                                >
                                    Tanzania
                                </x-pier-filter>
                                
                                <x-pier-filter
                                    class="border-l px-3 py-1" 
                                    activeClass="bg-blue-500 text-white"
                                    field="country"
                                    value="Kenya"
                                >
                                    Kenya
                                </x-pier-filter>
                            </div>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-3 gap-6">
                        @foreach($data as $event)
                            <div>
                                <img class="h-56 rounded w-full object-cover" src="{{$event->poster}}" alt=""/>
                                <h5 class="mt-2 text-lg font-semibold">
                                    {{ $event->title }}
                                </h5>
                                <p>
                                    {{ $event->country }}
                                </p>
                            </div>
                        @endforeach
                    </div>
                @endverbatim
            </x-pier-data>
        </div>
    </section>

    <script src="//unpkg.com/alpinejs" defer></script>
@endsection
