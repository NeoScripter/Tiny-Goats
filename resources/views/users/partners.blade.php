<x-layouts.app>

    <x-partials.header />

    <div class="user-partners">

        <section class="news">

            <h2 class="news__title">Наши партнеры</h2>

            @isset($partners)
            <div class="news__grid">
                @foreach ($partners as $index => $partner)
                    <div class="news__item">
                        <a href="{{ route('user.partner.show', $partner->id) }}" class="news__image">
                            <img src="{{ isset($partner->image) ? Storage::url($partner->image) : asset('images/pages/user/animal/placeholder.png') }}" alt="{{$partner->name}}">
                        </a>
                        <div class="news__content">
                            <h4 class="news__heading">{{ $partner->name }}</h4>
                            <p class="news__description">{{ $partner->info }}</p>
                            <p class="news__description">{{ $partner->conditions }}</p>
                            <a href="" class="news__description">{{ $partner->website }}</a>
                        </div>
                    </div>
                @endforeach
            </div>
            @endisset

            {{ $partners->links('vendor.pagination.default') }}

        </section>

    </div>


    <x-partials.footer />

</x-layouts.app>
