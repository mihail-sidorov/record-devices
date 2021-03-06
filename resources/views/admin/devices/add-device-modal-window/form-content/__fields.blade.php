<div class="form-content__fields">
    <div class="form-content__field">
        <div class="form-content__title">Наименование:</div>
        <input class="form-content__text" type="text" name="name">
        <div class="form-content__error" field-name="name"></div>
    </div>

    <div class="form-content__field">
        <div class="form-content__title">Модель:</div>
        <input class="form-content__text" type="text" name="model">
        <div class="form-content__error" field-name="model"></div>
    </div>

    <div class="form-content__field">
        <div class="form-content__title">Серийный номер:</div>
        <input class="form-content__text" type="text" name="serial_number">
        <div class="form-content__error" field-name="serial_number"></div>
    </div>

    <div class="form-content__field">
        <div class="form-content__title">Закупочная цена:</div>
        <input class="form-content__text" type="text" name="purchase_price">
        <div class="form-content__error" field-name="purchase_price"></div>
    </div>

    <div class="form-content__field">
        <div class="form-content__title">Тип:</div>
        <select class="form-content__select" name="type_device_id">
            <option value="1">Портативный</option>
            <option value="2">Переферия</option>
            <option value="3">Оргтехника</option>
        </select>
        <div class="form-content__error" field-name="type_device_id"></div>
    </div>

    <div class="form-content__field">
        <div class="form-content__title">Категория:</div>
        <select class="form-content__select" name="category_id">
            @foreach ($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>
        <div class="form-content__error" field-name="category_id"></div>
    </div>

    <div class="form-content__field">
        <div class="form-content__title">Ответственный на складе:</div>
        <select class="form-content__select" name="responsible_id">
            @foreach ($responsibles as $responsible)
                <option value="{{ $responsible->id }}">{{ $responsible->name }}</option>
            @endforeach
        </select>
        <div class="form-content__error" field-name="responsible_id"></div>
    </div>

    <div class="form-content__field">
        <div class="form-content__title">Поставщик:</div>
        <select class="form-content__select" name="provider_id">
            @foreach ($providers as $provider)
                <option value="{{ $provider->id }}">{{ $provider->name }}</option>
            @endforeach
        </select>
        <div class="form-content__error" field-name="provider_id"></div>
    </div>

    <div class="form-content__field">
        <div class="form-content__title">Дата поступления:</div>
        <input class="form-content__date" type="date" name="receipt_date">
        <div class="form-content__error" field-name="receipt_date"></div>
    </div>

    <div class="form-content__field">
        <div class="form-content__title">Дата окончания гарантии:</div>
        <input class="form-content__date" type="date" name="warranty">
        <div class="form-content__error" field-name="warranty"></div>
    </div>
</div>