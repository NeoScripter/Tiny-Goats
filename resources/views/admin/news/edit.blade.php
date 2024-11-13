<x-layouts.app>

    <x-partials.header />

    <div class="admin-edit-news">
        <form method="POST" action="{{ route('news.update', $news->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- News Data Section -->
            <section class="edit-news">
                <div class="edit-news__data">
                    <!-- Title Input -->
                    <label for="title" class="edit-news__label-title">Введите заголовок</label>
                    <input type="text" name="title" id="title" value="{{ old('title', $news->title) }}"
                        class="news__input" required>
                    @error('title')
                        <span class="edit-news__error">{{ $message }}</span>
                    @enderror

                    <!-- Content Textarea -->
                    <label for="content" class="edit-news__label-edit">Введите текст</label>
                    <textarea name="content" id="content" rows="6" class="wysiwyg-editor news__textarea" required>{!! old('content', $news->content) !!}</textarea>
                    @error('content')
                        <span class="edit-news__error">{{ $message }}</span>
                    @enderror
                </div>

                <!-- News Visual Section -->
                <div class="edit-news__visual">
                    <div class="edit-news__snapshot">
                        <!-- Image Preview & File Upload -->
                        <label for="image">
                            <img id="imagePreview"
                                src="{{ $news->image ? asset('storage/' . $news->image) : asset('images/partials/placeholder.webp') }}"
                                alt="News Image">
                        </label>
                        <input type="file" name="image" id="image" accept="image/*" class="news__file-input"
                            onchange="previewImage(event)">
                    </div>
                    @error('image')
                        <span class="edit-news__error">{{ $message }}</span>
                    @enderror
                </div>
            </section>

            <!-- Categories Checkboxes -->
            <div class="edit-news__checkboxes">
                <label>Раздел:</label>
                @php
                    $categories = ['Новости', 'Статьи', 'События'];
                @endphp

                @foreach ($categories as $category)
                    <label class="edit-news__checkbox-label">
                        <input type="checkbox" name="categories[]" value="{{ $category }}"
                            {{ in_array($category, old('categories', $news->categories ?? [])) ? 'checked' : '' }}>
                        {{ $category }}
                    </label>
                @endforeach

            </div>
            @error('categories')
                <span class="edit-news__error">{{ $message }}</span>
            @enderror

            <!-- Action Buttons -->
            <div class="edit-news__btns">
                <button type="submit" class="edit-news__publish-btn">Опубликовать</button>
                <!-- Delete Button -->
                <button type="submit" form="delete-news-form" class="edit-news__delete-btn">Удалить</button>
            </div>
        </form>
    </div>

    <form id="delete-news-form" method="POST" action="{{ route('news.destroy', $news->id) }}">
        @csrf
        @method('DELETE')
    </form>


    <!-- Image Preview Script -->
    <script>
        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function() {
                const output = document.getElementById('imagePreview');
                output.src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>



    <x-partials.footer />

</x-layouts.app>
