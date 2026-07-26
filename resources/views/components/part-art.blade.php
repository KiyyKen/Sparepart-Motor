@props(['product', 'square' => false])
@php($visual = $product->category->visual())
<div {{ $attributes->merge(['class' => 'part-art'.($square ? ' part-art--square' : '')]) }} style="--from: {{ $visual['from'] }}; --to: {{ $visual['to'] }};">
    @if($product->image)
        <img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}">
    @else
        <i class="bi {{ $visual['icon'] }} part-art__icon"></i>
        <div class="part-art__grid"></div>
    @endif
</div>
