@props(['product'])

<div class="part-card h-100">
    <a href="{{ route('catalog.show', $product) }}" class="part-card__link">
        <x-part-art :product="$product" class="part-card__art" />

        <span class="part-card__ribbon">{{ $product->category->name }}</span>

        @if($product->stock === 0)
            <span class="part-card__stock part-card__stock--out">Stok Habis</span>
        @elseif($product->stock <= 5)
            <span class="part-card__stock part-card__stock--low">Sisa {{ $product->stock }}</span>
        @endif
    </a>

    <div class="part-card__body">
        <div class="part-card__meta">
            <span class="mono">{{ $product->sku }}</span>
            <span>{{ $product->brand ?? 'Universal' }}</span>
        </div>

        <h3 class="part-card__title">
            <a href="{{ route('catalog.show', $product) }}">{{ $product->name }}</a>
        </h3>

        <div class="part-card__rating">
            @if($product->reviews_avg_rating)
                <span class="stars" aria-hidden="true">
                    @for($i = 1; $i <= 5; $i++)<i class="bi {{ $i <= round($product->reviews_avg_rating) ? 'bi-star-fill' : 'bi-star' }}"></i>@endfor
                </span>
                <span class="mono small text-muted">{{ number_format($product->reviews_avg_rating, 1) }} ({{ $product->reviews_count }})</span>
            @else
                <span class="small text-muted">Belum ada ulasan</span>
            @endif
        </div>

        <div class="part-card__footer">
            <span class="part-card__price mono">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
            <a href="{{ route('catalog.show', $product) }}" class="btn btn-sm part-card__cta">Detail</a>
        </div>
    </div>
</div>
