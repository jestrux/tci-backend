<button
    {{ $attributes->merge(
        [
            'type' => 'button', 
            ':class' => $selected
        ]
    )}}
    :pier-ref="ref"
    @click="filters = {...filters, where{{$field}}: '{{$value}}'}"
>
    @if(isset($slot) && strlen($slot) > 0)
        {{$slot}}
    @else
        {{ $value }}
    @endif
</button>