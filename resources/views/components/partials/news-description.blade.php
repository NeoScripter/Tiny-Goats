<div class="news__description">
    {!! \Illuminate\Support\Str::of($slot)->stripTags()->markdown()->stripTags()->limit(50) !!}
</div>
