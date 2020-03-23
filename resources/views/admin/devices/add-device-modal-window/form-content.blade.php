<form class="form-content">
    <div class="form-content__title">Имя устройства:</div>
    <input class="form-content__text" type="text" name="name">

    <div class="form-content__title">Модель устройства:</div>
    <input class="form-content__text" type="text" name="model">

    <div class="form-content__title">Серийный номер устройства:</div>
    <input class="form-content__text" type="text" name="serial_number">

    <div class="form-content__title">Тип устройства:</div>
    <select class="form-content__select" name="type_device_id">
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
    </select>

    <div class="form-content__title">Дата поступления устройства:</div>
    <input class="form-content__text" type="text" name="receipt_date">

    <div class="form-content__title">Закупочная стоимость устройства:</div>
    <input class="form-content__text" type="text" name="purchase_price">

    <div class="form-content__title">Срок гарантии устройства (мес.):</div>
    <select class="form-content__select" name="warranty">
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="1">5</option>
        <option value="2">6</option>
        <option value="3">7</option>
        <option value="4">8</option>
        <option value="1">9</option>
        <option value="2">10</option>
        <option value="3">11</option>
        <option value="4">12</option>
    </select>

    @include('admin.devices.add-device-modal-window.action-btn')
</form>