<x-layouts.app>

    <x-partials.header />

    <div class="user-news">

        <section class="news">

            <h2 class="news__title">Новости и статьи</h2>

            <div class="news__categories">
                <a href="{{ route('user.news.index') }}"
                    class="news__category {{ request('category') ? '' : 'news__category--active' }}">
                    Все
                </a>
                <!-- Links for specific categories -->
                <a href="{{ route('user.news.index', ['category' => 'Новости']) }}"
                    class="news__category {{ request('category') === 'Новости' ? 'news__category--active' : '' }}">
                    Новости
                </a>
                <a href="{{ route('user.news.index', ['category' => 'Статьи']) }}"
                    class="news__category {{ request('category') === 'Статьи' ? 'news__category--active' : '' }}">
                    Статьи
                </a>
                <a href="{{ route('user.news.index', ['category' => 'События']) }}"
                    class="news__category {{ request('category') === 'События' ? 'news__category--active' : '' }}">
                    События
                </a>
            </div>

            <div class="news__grid">
                @foreach ($news as $item)
                    <div class="news__item">
                        <a href="{{ route('user.news.show', $item->id) }}" class="news__image">
                            <img src="{{ $item->image ? asset('storage/' . $item->image) : asset('images/partials/placeholder.webp') }}"
                                alt="Фото новости">
                            <span class="news__label">Раздел
                                {{ \Illuminate\Support\Str::lower($item->categories[0]) }}</span>
                        </a>

                        <div class="news__content">
                            <h4 class="news__heading">{{ $item->title }}</h4>
                            <x-partials.news-description>
                                {{ $news->content }}
                            </x-partials.news-description>

                        </div>
                    </div>
                @endforeach
            </div>


            <div class="news__pagination">
                {{ $news->links('vendor.pagination.default') }}
            </div>

        </section>

    </div>


    <x-partials.footer />

</x-layouts.app>
