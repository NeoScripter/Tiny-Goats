<x-layouts.app>

    <x-partials.header />

    <div class="user-news-show">

        <section class="piece">

            <div class="piece__image">
                <img src="{{ $news->image ? asset('storage/' . $news->image) : asset('images/partials/placeholder.webp') }}"
                    alt="Фото новости">
            </div>

            <h1 class="piece__title">{{ $news->title }}</h1>

            <div class='markdown__description'>
                {!! $news->content_html !!}
            </div>

        </section>

        <section class="news">

            <div class="news__headline">
                <h2 class="news__title">Новости и статьи</h2>

                <a href="{{ route('user.news.index') }}" class="news__btn">Смотреть все</a>
            </div>


            <div class="news__grid">
                @foreach ($latest_news as $news)
                    <div class="news__item">
                        <a href="{{ route('user.news.show', $news->id) }}" class="news__image">
                            <img src="{{ $news->image ? asset('storage/' . $news->image) : asset('images/partials/placeholder.webp') }}"
                                alt="Фото новости">
                            <span class="news__label">Раздел
                                {{ \Illuminate\Support\Str::lower($news->categories[0]) }}</span>
                        </a>
                        <div class="news__content">
                            <h4 class="news__heading">{{ $news->title }}</h4>

                            <x-partials.news-description>
                                {{ $news->content }}
                            </x-partials.news-description>
                        </div>
                    </div>
                @endforeach
            </div>

        </section>

    </div>


    <x-partials.footer />

</x-layouts.app>
