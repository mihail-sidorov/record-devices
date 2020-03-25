<div class="tab-content-wrapper">
    <div class="tab-content-wrapper__title">Фильтр:</div>    
    <div class="tab-content-wrapper__filter">
        <input class="tab-content-wrapper__filter-field" type="text" placeholder="Модель">
        <input class="tab-content-wrapper__filter-field" type="text" placeholder="Серийный номер">
        <select class="tab-content-wrapper__filter-field">
            <option value="">Портативный</option>
            <option value="">Рабочее место</option>
            <option value="">Переферия</option>
            <option value="">Оргтехника</option>
        </select>
        
        @include('action-btn')
    </div>

    <div class="tab-content-wrapper__title">Список:</div>
    <div class="tab-content-wrapper__list">
        @foreach ($devices as $device)
            <div class="tab-content-wrapper__list-item" id="{{ $device->id }}">
                <div class="tab-content-wrapper__list-item-head">
                    <div class="tab-content-wrapper__list-item-name">{{ $device->name }}</div>
                    @include('edit-btn')
                    @include('del-btn')
                </div>
                <div class="tab-content-wrapper__list-item-body">
                    <table class="tab-content-wrapper__list-item-body-table">
                        <thead>
                            <tr>
                                <td>Модель</td>
                                <td>Серийный номер</td>
                                <td>Тип</td>
                                <td>Дата поступления</td>
                                <td>Закупочная цена</td>
                                <td>Срок гарантии (мес.)</td>
                                <td>Выдано сотруднику</td>
                                <td>Ответственный</td>
                                <td>Поставщик</td>
                                <td>Статус</td>
                            </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>{{ $device->model }}</td>
                            <td>{{ $device->serial_number }}</td>
                            <td>{{ $device->type_device_id }}</td>
                            <td>{{ $device->receipt_date }}</td>
                            <td>{{ $device->purchase_price }}</td>
                            <td>{{ $device->warranty }}</td>
                            <td>{{ $device->worker_id }}</td>
                            <td>{{ $device->provider_id }}</td>
                            <td>{{ $device->responsible_id }}</td>
                            <td>{{ $device->status }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        @endforeach
    </div>

    @include('add-btn')
</div>