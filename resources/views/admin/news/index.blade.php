<x-layouts.app>

    <x-admin.header />

    <div class="admin-news">

        <section class="news">

            <h2 class="news__title">Новости и статьи</h2>

            <div class="news__categories">
                <a href="{{ route('news.create') }}" class="news__add">Добавить новость</a>
            </div>

            @isset($newsItems)
                <div class="news__grid">
                    @forelse ($newsItems as $news)
                        <div class="news__item">
                            <form method="POST" action="{{ route('news.destroy', $news->id) }}"
                                onsubmit="return confirm('Вы уверены что хотите удалить данную новость?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="news__delete-button">
                                    <img src="{{ asset('images/svgs/cross.svg') }}" alt="Удалить">
                                </button>
                            </form>

                            <a href="{{ route('news.edit', $news->id) }}" class="news__edit-link">
                                <img src="{{ asset('images/svgs/pencil.svg') }}" alt="Редактировать">
                            </a>

                            <a href="{{ route('news.show', $news->id) }}" class="news__image">
                                <img src="{{ $news->image ? asset('storage/' . $news->image) : asset('images/partials/placeholder.webp') }}"
                                    alt="image">
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
                    @empty
                        <p style="text-align: center;">По вашему запросу не найдено ни одного результата</p>
                    @endforelse
                </div>

                {{ $newsItems->links('vendor.pagination.default') }}
            @endisset
        </section>

    </div>

    @if (session('success'))
        <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="notification-popup">
            {{ session('success') }}
        </div>
    @endif


    <x-partials.footer />

</x-layouts.app>
