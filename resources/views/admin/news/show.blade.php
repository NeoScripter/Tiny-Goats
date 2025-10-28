<x-layouts.app>

    <x-admin.header />

    <div class="admin-news-show">

        @isset($news)
            <section class="piece">

                <div class="piece__image">
                    <img src="{{ $news->image ? asset('storage/' . $news->image) : asset('images/partials/placeholder.webp') }}"
                        alt="news image">
                </div>

                <h1 class="piece__title">{{ $news->title }}</h1>

                <div class='markdown__description'>
                    {!! $news->content_html !!}
                </div>

            </section>

            <section class="news">
                <a href="{{ route('news.edit', $news->id) }}" class="news__btn news__btn--edit">Редактировать</a>
                <div class="news__headline">
                    <h2 class="news__title">Новости и статьи</h2>

                    <a href="{{ route('news.index') }}" class="news__btn">Смотреть все</a>
                </div>


                <div class="news__grid">
                    @foreach ($latest_news as $news)
                        <div class="news__item">
                            <a href="{{ route('news.show', $news->id) }}" class="news__image">
                                <img src="{{ $news->image ? asset('storage/' . $news->image) : asset('images/partials/placeholder.webp') }}"
                                    alt="{{ $news->title }}">
                                @isset($news->categories[0])
                                    <span class="news__label">Раздел
                                        {{ \Illuminate\Support\Str::lower($news->categories[0]) }}</span>
                                @endisset
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
        @endisset

    </div>


    <x-partials.footer />

</x-layouts.app>
