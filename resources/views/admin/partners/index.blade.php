<x-layouts.app>

    <x-admin.header />

    <div class="user-seach-animal">

        <div class="user-partners">
            @isset($partners)

            <section class="news">

                <h2 class="news__title">Наши партнеры</h2>

                <div class="animals__categories">
                    <a href="{{ route('partner.create') }}" class="animals__add">Добавить</a>
                </div>

                <div class="news__grid">
                    @foreach ($partners as $partner)
                        <div class="news__item">
                            <form method="POST" action="{{ route('partner.destroy', $partner->id) }}"
                                onsubmit="return confirm('Вы уверены что хотите удалить данного партнера?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="animals__delete-button">
                                    <img src="{{ asset('images/svgs/cross.svg') }}" alt="Удалить">
                                </button>
                            </form>

                            <a href="{{ route('partner.edit', $partner->id) }}" class="animals__edit-link">
                                <img src="{{ asset('images/svgs/pencil.svg') }}" alt="Редактировать">
                            </a>

                            <a href="{{ route('partner.show', $partner->id) }}" class="news__image">
                                <img src="{{ isset($partner->image)
                                ? asset('storage/' . $partner->image)
                                : asset('images/partials/placeholder.webp') }}"
                                alt="{{ $partner->name }}">
                            </a>
                            <div class="news__content">
                                <h4 class="news__heading">{{ $partner->name }}</h4>
                                <p class="news__description">{{ Str::words($partner->info, 10) }}</p>
                                <p class="news__description">{{ $partner->conditions }}</p>
                                <a href="" class="news__description">{{ $partner->website }}</a>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{ $partners->links('vendor.pagination.default') }}

            </section>
            @endisset
        </div>

    @if (session('success'))
        <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="notification-popup">
            {{ session('success') }}
        </div>
    @endif


    <x-partials.footer />

</x-layouts.app>
