<div class="form-content__fields">
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
            @foreach ($departments as $department)
                <option value="{{ $department->id }}">{{ $department->name }}</option>
            @endforeach
        </select>
        <div class="form-content__error" field-name="department_id"></div>
    </div>
</div>