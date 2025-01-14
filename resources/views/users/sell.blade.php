<x-layouts.app>

    <x-partials.header />

    <div class="user-sell">

        <section class="news">

            <h2 class="news__title">Животные на продажу</h2>
            @isset($animals)


            <div class="news__grid">
                @foreach($animals as $animal)
                    <div class="news__item">
                        <a href="{{ route('user.animals.show', $animal->id) }}" class="news__image">
                            <img src="{{ isset($animal->images[0]) && $animal->images[0]
                                    ? asset('storage/' . $animal->images[0])
                                    : asset('images/partials/placeholder.webp') }}" alt="image">
                        </a>
                        <div class="news__content">
                            <h4 class="news__heading">{{ $animal->name }}</h4>
                            <p class="news__description">{{ \Carbon\Carbon::parse($animal->birthDate)->toFormattedDateString() }}</p>
                            <p class="news__description">{{ $animal->breed }}</p>
                        </div>
                    </div>
                @endforeach
            </div>


            {{ $animals->links('vendor.pagination.default') }}

            @endisset

        </section>

    </div>


    <x-partials.footer />

</x-layouts.app>
