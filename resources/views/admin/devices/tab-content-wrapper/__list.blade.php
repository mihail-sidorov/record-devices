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
                    $type_device = 'Переферия';
                    break;
                case 3:
                    $type_device = 'Оргтехника';
                    break;
            }

            $worker = $device->get_attach_worker();
            if ($worker) {
                $worker_id = $worker->id;
            }
            else {
                $worker_id = '';
            }
            $responsible = $device->get_responsible();
            $provider = $device->provider;
            $category = $device->category;
            $purchase_price = $device->purchase_price;
        ?>
        <div class="tab-content-wrapper__list-item" id="{{ $device->id }}" worker_id="{{ $worker_id }}">
            <input type="hidden" class="tab-content-wrapper__list-item-filter-field" value="{{ $device->model }}">
            <input type="hidden" class="tab-content-wrapper__list-item-filter-field" value="{{ $device->serial_number }}">
            <input type="hidden" class="tab-content-wrapper__list-item-filter-field" value="{{ $device->type_device_id }}">

            <div class="tab-content-wrapper__list-item-head">
                <div class="tab-content-wrapper__list-item-name">{{ $device->name }}</div>
                <div class="tab-content-wrapper__edit-device-btn">
                    @include('btns.edit-btn')
                </div>
                
                @if (!$worker)
                    @if (!$device->write_off())
                        @include('btns.attach-worker-btn')
                    @endif
                @else
                    @include('btns.unattach-worker-btn')
                @endif

                @include('btns.del-btn')
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
            </div>
        </div>
    @endforeach
</div>