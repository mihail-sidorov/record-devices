<div class="tab-content-wrapper">
    <div class="tab-content-wrapper__title">Фильтр:</div>    
    <div class="tab-content-wrapper__filter">
        <input class="tab-content-wrapper__filter-field" type="text" placeholder="Модель">
        <input class="tab-content-wrapper__filter-field" type="text" placeholder="Серийный номер">
        <select class="tab-content-wrapper__filter-field">
            <option value="">Все типы устройств</option>
            <option value="1">Портативный</option>
            <option value="2">Рабочее место</option>
            <option value="3">Переферия</option>
            <option value="4">Оргтехника</option>
        </select>
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
                $device_component_parts = $device->component_parts;
                $purchase_price = $device->purchase_price;

                if ($device_component_parts->count()) {
                    $purchase_price = 0;
                    foreach ($device_component_parts as $device_component_part) {
                        $purchase_price += $device_component_part->purchase_price;
                    }
                }
            ?>
            <div class="tab-content-wrapper__list-item" id="{{ $device->id }}">
                <input type="hidden" class="tab-content-wrapper__list-item-filter-field" value="{{ $device->model }}">
                <input type="hidden" class="tab-content-wrapper__list-item-filter-field" value="{{ $device->serial_number }}">
                <input type="hidden" class="tab-content-wrapper__list-item-filter-field" value="{{ $device->type_device_id }}">

                <div class="tab-content-wrapper__list-item-head">
                    <div class="tab-content-wrapper__list-item-name">{{ $device->name }}</div>
                    <div class="tab-content-wrapper__edit-device-btn">
                        @include('edit-btn')
                    </div>
                    
                    @if (!$worker)
                        @if (!$device->write_off())
                            @include('attach-worker-btn')
                        @endif
                    @else
                        @include('unattach-worker-btn')
                    @endif

                    @if ($device->component_parts()->count())
                        @include('attach-component-parts-btn')
                    @elseif (!$device->write_off())
                        @if ($device->type_device_id === 2)
                            @include('attach-component-parts-btn')
                        @endif
                    @endif

                    @include('del-btn')
                </div>
                <div class="tab-content-wrapper__list-item-body">
                    <table class="tab-content-wrapper__list-item-body-table">
                        <thead>
                            <tr>
                                <td>Тип</td>
                                <td>Категория</td>
                                <td>Модель</td>
                                <td>Серийный номер</td>
                                <td>Выдано сотруднику</td>
                                <td>Ответственный</td>
                                <td>Закупочная цена</td>
                                <td>Статус</td>
                                <td>Дата поступления</td>
                                <td>Дата окончания гарантии</td>
                                <td>Поставщик</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ $type_device }}</td>
                                <td>
                                    @if ($category)
                                        {{ $category->name }}
                                    @endif
                                </td>
                                <td>{{ $device->model }}</td>
                                <td>{{ $device->serial_number }}</td>
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
                                <td>{{ $purchase_price }}</td>
                                <td>
                                    {{ $device->get_status() }}
                                </td> 
                                <td>{{ $receipt_date }}</td>
                                <td>{{ $warranty }}</td>
                                <td>
                                    @if ($provider)
                                        {{ $provider->name }}
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="tab-content-wrapper__component-parts">
                        @if ($device_component_parts->count())
                            @include('admin.devices.tab-content-wrapper.component-parts')
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    @include('add-btn')
</div>