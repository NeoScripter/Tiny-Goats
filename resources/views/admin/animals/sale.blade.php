<x-layouts.app>

    <x-admin.header />

    <div class="admin-animals">

        <section class="animals">

            <h2 class="animals__title">На продажу</h2>

            <div class="animals__categories">
                <a href="{{ route('animals.create') }}" class="animals__add">Добавить</a>
            </div>

            @isset($animals)
                <div class="animals__grid">
                    @foreach ($animals as $animal)
                        <div class="animals__item">
                            <form method="POST" action="{{ route('animals.destroy', $animal->id) }}"
                                onsubmit="return confirm('Вы уверены что хотите удалить данное животное из базы данных?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="animals__delete-button">
                                    <img src="{{ asset('images/svgs/cross.svg') }}" alt="Удалить">
                                </button>
                            </form>

                            <a href="{{ route('animals.edit', $animal->id) }}" class="animals__edit-link">
                                <img src="{{ asset('images/svgs/pencil.svg') }}" alt="Редактировать">
                            </a>

                            <a href="{{ route('animals.show', $animal->id) }}" class="animals__image">

                                <img src="{{ isset($animal->images[0]) && is_array($animal->images) && !empty($animal->images) && $animal->images[0]
                                    ? asset('storage/' . $animal->images[0])
                                    : asset('images/partials/placeholder.webp') }}"
                                    alt="Animal Image">
                            </a>
                            <div class="animals__content">
                                <h4 class="animals__heading">{{ $animal->name }}</h4>
                                <p class="animals__description">
                                    {{ \Carbon\Carbon::parse($animal->birthDate)->toFormattedDateString() }}</p>
                                <p class="animals__description">{{ $animal->breed }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{ $animals->links('vendor.pagination.default') }}
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
