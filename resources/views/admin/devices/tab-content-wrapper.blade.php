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
            <?php
                $d = new DateTime();

                $d->setTimestamp($device->warranty);
                $warranty = $d->format('d-m-Y');
                if ($device->warranty_off()) {
                    $warranty = "Истекла $warranty";
                }

                $d->setTimestamp($device->receipt_date);
                $receipt_date = $d->format('d-m-Y');

                switch ($device->type_device_id) {
                    case 1:
                        $type_device = 'Портативный';
                        break;
                    case 2:
                        $type_device = 'Рабочее место';
                        break;
                    case 3:
                        $type_device = 'Переферия';
                        break;
                    case 4:
                        $type_device = 'Оргтехника';
                        break;
                }

                $worker = $device->get_attach_worker();
                $responsible = $device->get_responsible();
                $provider = $device->provider;
                $category = $device->category;
            ?>
            <div class="tab-content-wrapper__list-item" id="{{ $device->id }}">
                <div class="tab-content-wrapper__list-item-head">
                    <div class="tab-content-wrapper__list-item-name">{{ $device->name }}</div>
                    @include('edit-btn')
                    @if (!$worker)
                        @if (!$device->write_off())
                            @include('attach-worker-btn')
                        @endif
                    @else
                        @include('unattach-worker-btn')
                    @endif
                    @include('attach-component-parts-btn')
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
                                <td>Дата окончания гарантии</td>
                                <td>Выдано сотруднику</td>
                                <td>Ответственный</td>
                                <td>Поставщик</td>
                                <td>Статус</td>
                                <td>Категория</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ $device->model }}</td>
                                <td>{{ $device->serial_number }}</td>
                                <td>{{ $type_device }}</td>
                                <td>{{ $receipt_date }}</td>
                                <td>{{ $device->purchase_price }}</td>
                                <td>{{ $warranty }}</td>
                                <td>
                                    @if ($worker)
                                        {{ $worker->name }}
                                    @endif
                                </td>
                                <td>
                                    @if ($responsible)
                                        {{ $responsible->name }}
                                    @endif
                                </td>
                                <td>
                                    @if ($provider)
                                        {{ $provider->name }}
                                    @endif
                                </td>
                                <td>
                                    {{ $device->get_status() }}
                                </td>
                                <td>
                                    @if ($category)
                                        {{ $category->name }}
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        @endforeach
    </div>

    @include('add-btn')
</div>