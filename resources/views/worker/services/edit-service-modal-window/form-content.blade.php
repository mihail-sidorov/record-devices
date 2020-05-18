<form class="form-content">
    @csrf

    <input type="hidden" name="id" value="">

    <div class="form-content__field">
        <div class="form-content__title">Наименование:</div>
        <input class="form-content__text" type="text" name="name">
        <div class="form-content__error" field-name="name"></div>
    </div>

    <div class="form-content__field">
        <div class="form-content__title">Логин:</div>
        <input class="form-content__text" type="text" name="login">
        <div class="form-content__error" field-name="login"></div>
    </div>

    <div class="form-content__field">
        <div class="form-content__title">Пароль:</div>
        <input class="form-content__text" type="text" name="password">
        <div class="form-content__error" field-name="password"></div>
    </div>

    @include('action-btn')
</form>