<div>
    <div class="container">
        <ul class="contact-info__wrapper">
            <li>
                <div class="contact-info__icon"><span class="icon-Call"></span></div>
                <p class="contact-info__title">Fale com um atendente</p>
                <h4 class="contact-info__text"><a href="#">{{ $information['phone_01'] ?? '(00) 0 0000-0000' }}</a></h4>
            </li>
            <li>
                <div class="contact-info__icon"><span class="icon-Email"></span></div>
                <p class="contact-info__title">Envie um email</p>
                <h4 class="contact-info__text"><a href="mailto:">{{ $information['email_01']  ?? 'contat@example.com.br'}}</a></h4>
            </li>
        </ul>
    </div>
</div>
