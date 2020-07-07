<div class="form-content__fields">
    <div class="form-content__field">
        <div class="form-content__title">ФИО:</div>
        <input class="form-content__text" type="text" name="name">
        <div class="form-content__error" field-name="name"></div>
    </div>

    <div class="form-content__field">
        <div class="form-content__title">Эл. почта:</div>
        <input class="form-content__text" type="text" name="email">
        <div class="form-content__error" field-name="email"></div>
    </div>

    @isset($add)
    <div class="form-content__field">
        <div class="form-content__title">Пароль:</div>
        <input class="form-content__text" type="password" name="password">
        <div class="form-content__error" field-name="password"></div>
    </div>

    <div class="form-content__field">
        <div class="form-content__title">Подтвердите пароль:</div>
        <input class="form-content__text" type="password" name="password_confirmation">
        <div class="form-content__error" field-name="password_confirmation"></div>
    </div>
    @endisset

    <div class="form-content__field">
        <div class="form-content__title">Должность:</div>
        <input class="form-content__text" type="text" name="post">
        <div class="form-content__error" field-name="post"></div>
    </div>

    <div class="form-content__field">
        <div class="form-content__title">Телефон:</div>
        <input class="form-content__text" type="text" name="phone">
        <div class="form-content__error" field-name="phone"></div>
    </div>

    <div class="form-content__field">
        <div class="form-content__title">Работодатель:</div>
        <select class="form-content__select" name="employer_id">
            <option value="1">ИП Корсун А.В.</option>
            <option value="2">ИП Корсун В.П.</option>
        </select>
        <div class="form-content__error" field-name="employer_id"></div>
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

    <div class="form-content__field">
        <div class="form-content__title">Дата трудоустройства:</div>
        <input class="form-content__date" type="date" name="placement_date">
        <div class="form-content__error" field-name="placement_date"></div>
    </div>
</div>