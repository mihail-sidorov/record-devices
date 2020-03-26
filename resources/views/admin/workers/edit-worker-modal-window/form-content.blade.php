<form class="form-content">
    @csrf

    <input type="hidden" name="id" value="">

    <div class="form-content__field">
        <div class="form-content__title">ФИО:</div>
        <input class="form-content__text" type="text" name="name">
        <div class="form-content__error" field-name="name"></div>
    </div>

    <div class="form-content__field">
        <div class="form-content__title">Должность:</div>
        <input class="form-content__text" type="text" name="post">
        <div class="form-content__error" field-name="post"></div>
    </div>

    <div class="form-content__field">
        <div class="form-content__title">Отдел:</div>
        <select class="form-content__select" name="department_id">
            <option value="1">Отдел 1</option>
            <option value="2">Отдел 2</option>
            <option value="3">Отдел 3</option>
            <option value="4">Отдел 4</option>
        </select>
        <div class="form-content__error" field-name="department_id"></div>
    </div>

    @include('action-btn')
</form>