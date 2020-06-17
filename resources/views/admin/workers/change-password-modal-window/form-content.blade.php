@component('form-content')
    @slot('fields')
        <input type="hidden" name="id">

        <div class="form-content__field">
            <div class="form-content__title">Текущий пароль:</div>
            <input class="form-content__text" type="password" name="current_password">
            <div class="form-content__error" field-name="current_password"></div>
        </div>

        <div class="form-content__field">
            <div class="form-content__title">Новый пароль:</div>
            <input class="form-content__text" type="password" name="password">
            <div class="form-content__error" field-name="password"></div>
        </div>

        <div class="form-content__field">
            <div class="form-content__title">Подтвердите пароль:</div>
            <input class="form-content__text" type="password" name="password_confirmation">
            <div class="form-content__error" field-name="password_confirmation"></div>
        </div>
    @endslot
@endcomponent