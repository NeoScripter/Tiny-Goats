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

    <div class="wrapper">
        {{ $slot }}
    </div>

    @vite('resources/ts/app.ts')
</body>

</html>
