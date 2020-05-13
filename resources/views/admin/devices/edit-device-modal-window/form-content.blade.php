<form class="form-content">
    @csrf

    <input type="hidden" name="id">

    <div class="form-content__field">
        <div class="form-content__title">Имя устройства:</div>
        <input class="form-content__text" type="text" name="name">
        <div class="form-content__error" field-name="name"></div>
    </div>

    <div class="form-content__field">
        <div class="form-content__title">Модель устройства:</div>
        <input class="form-content__text" type="text" name="model">
        <div class="form-content__error" field-name="model"></div>
    </div>

    <div class="form-content__field">
        <div class="form-content__title">Серийный номер устройства:</div>
        <input class="form-content__text" type="text" name="serial_number">
        <div class="form-content__error" field-name="serial_number"></div>
    </div>

    <div class="form-content__field">
        <div class="form-content__title">Инвентарный номер устройства:</div>
        <input class="form-content__text" type="text" name="inventar_number">
        <div class="form-content__error" field-name="inventar_number"></div>
    </div>

    <div class="form-content__field">
        <div class="form-content__title">Закупочная стоимость устройства:</div>
        <input class="form-content__text" type="text" name="purchase_price">
        <div class="form-content__error" field-name="purchase_price"></div>
    </div>

    <div class="form-content__field">
        <div class="form-content__title">Тип устройства:</div>
        <select class="form-content__select" name="type_device_id">
            <option value="1">Портативный</option>
            <option value="2">Рабочее место</option>
            <option value="3">Переферия</option>
            <option value="4">Оргтехника</option>
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
        <div class="form-content__title">Дата поступления устройства:</div>
        <input class="form-content__date" type="date" name="receipt_date">
        <div class="form-content__error" field-name="receipt_date"></div>
    </div>

    <div class="form-content__field">
        <div class="form-content__title">Срок гарантии (дата окончания):</div>
        <input class="form-content__date" type="date" name="warranty">
        <div class="form-content__error" field-name="warranty"></div>
    </div>

    @include('action-btn')
</form>