<form class="form-content">
    @csrf

    <input type="hidden" name="id" value="">

    <div class="form-content__field">
        <div class="form-content__title">ФИО:</div>
        <input class="form-content__text" type="text" name="name">
        <div class="form-content__error" field-name="name"></div>
    </div>

    @include('action-btn')
</form>