<footer class="footer">

    <div class="footer__logo">
        <img src="{{ asset('images/partials/logo-footer.webp') }}" alt="logo">
    </div>

    <div class="footer__content">

        <div class="footer__icons">
            <a href="" class="footer__icon">
                {!! file_get_contents(public_path('images/svgs/whatsapp.svg')) !!}
            </a>
            <a href="" class="footer__icon">
                {!! file_get_contents(public_path('images/svgs/telegram.svg')) !!}
            </a>
            <a href="" class="footer__icon">
                {!! file_get_contents(public_path('images/svgs/vk.svg')) !!}
            </a>
            <a href="" class="footer__icon">
                {!! file_get_contents(public_path('images/svgs/email.svg')) !!}
            </a>
        </div>

        <p class="footer__copyright">Все права защищены © 2024</p>
    </div>

    <nav class="footer__nav">
        <ul class="footer__ul">
            <li><a href="">О реестре</a></li>
            <li><a href="">Новости</a></li>
            <li><a href="">На продажу</a></li>
            <li><a href="">Вопросы</a></li>
            <li><a href="">Животные</a></li>
            <li><a href="">Специалисты</a></li>
            <li><a href="">Правила</a></li>
            <li><a href="">Хозяйства</a></li>
            <li><a href="">Партнеры</a></li>
        </ul>
    </nav>
</footer>
