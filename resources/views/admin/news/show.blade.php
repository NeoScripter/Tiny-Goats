<x-layouts.app>

    <x-partials.header />

    <div class="admin-news-show">

        <section class="piece">

            <div class="piece__image">
                <img src="{{ $news->image ? asset('storage/' . $news->image) : asset('images/partials/placeholder.webp') }}" alt="news image">
            </div>

            <h1 class="piece__title">{{ $news->title }}</h1>

            {!! $news->content !!}



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
                        <div class="news__image">
                            <img src="{{ $news->image ? asset('storage/' . $news->image) : asset('images/partials/placeholder.webp') }}" alt="image">
                            <span class="news__label">Раздел
                                {{ \Illuminate\Support\Str::lower($news->categories[0]) }}</span>
                        </div>
                        <div class="news__content">
                            <h4 class="news__heading">{{ $news->title }}</h4>
                            <p class="news__description">{!! \Illuminate\Support\Str::limit($news->content, 50) !!}</p>
                        </div>
                    </div>
                @endforeach
            </div>

        </section>

    </div>


    <x-partials.footer />

</x-layouts.app>
