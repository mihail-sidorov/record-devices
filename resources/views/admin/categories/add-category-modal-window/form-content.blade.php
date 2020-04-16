<form class="form-content">
    @csrf

    <div class="form-content__field">
        <div class="form-content__title">Имя категории:</div>
        <input class="form-content__text" type="text" name="name">
        <div class="form-content__error" field-name="name"></div>
    </div>

    <div class="form-content__field">
        <div class="form-content__title">Описание:</div>
        <textarea class="form-content__text" name="description"></textarea>
        <div class="form-content__error" field-name="description"></div>
    </div>

    @include('action-btn')
</form>