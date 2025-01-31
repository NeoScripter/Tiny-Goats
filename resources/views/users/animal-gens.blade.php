<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <title> {{ config('app.name') }}</title>

    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.0/classic/ckeditor.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll('.wysiwyg-editor').forEach((editorElement) => {
                ClassicEditor
                    .create(editorElement)
                    .catch(error => {
                        console.error(error);
                    });
            });
        });
    </script>

    @vite('resources/sass/app.scss')
</head>

<body>
    <div class="animal-card">

        @isset($animal)

            <div class="gens__table">

                <div class="gens__column">

                    <div class="gens__item">
                        <div class="gens__image">
                            <img src="{{ isset($animal->images[0]) ? asset('storage/' . $animal->images[0]) : asset('images/partials/placeholder.webp') }}"
                                alt="{{ $animal->name }}">
                        </div>
                        <h3 class="gens__name">{{ $animal->name }}</h3>
                        <p class="gens__breed">{{ $animal->breed }}</p>
                    </div>
                </div>


                @foreach ($genealogy as $generationIndex => $generation)
                    <div class="gens__column">
                        @foreach ($generation as $parent)
                            @php
                                $style =
                                    $parent && isset($repeatedColors[$parent->id])
                                        ? "background-color: {$repeatedColors[$parent->id]};"
                                        : '';
                            @endphp
                            <div class="gens__item" style="{{ $style }}">
                                @if ($parent)
                                    @if ($photo)
                                        <a href="{{ route('user.animals.show', $parent->id) }}" class="gens__image">
                                            <img src="{{ $photo && isset($parent->images[0]) ? asset('storage/' . $parent->images[0]) : asset('images/partials/placeholder.webp') }}"
                                                alt="">
                                        </a>
                                    @endif
                                    <a href="{{ route('user.animals.show', $parent->id) }}"
                                        class="gens__name gens__name--link">{{ $parent->name }}</a>
                                    <p class="gens__breed">{{ $parent->breed ?? 'Unknown' }}</p>
                                @else
                                    @if ($photo)
                                        <div class="gens__image">
                                            <img src="{{ asset('images/partials/placeholder.webp') }}" alt="">
                                        </div>
                                    @endif
                                    <h3 class="gens__name">?</h3>
                                    <p class="gens__breed gens__breed--hidden">Неизвестно</p>
                                @endif
                            </div>
                        @endforeach

                    </div>
                @endforeach
            </div>
            </form>

        @endisset


    </div>
</body>

</html>
