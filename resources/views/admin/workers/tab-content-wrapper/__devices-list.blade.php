<div class="tab-content-wrapper__list tab-content-wrapper__devices-list">
    @foreach ($worker_devices as $worker_device)
        <?php
            $d = new DateTime();

            $d->setTimestamp($worker_device->warranty);
            $warranty = $d->format('d-m-Y');
            if ($worker_device->warranty_off()) {
                $warranty = "Истекла $warranty";
            }

            $d->setTimestamp($worker_device->receipt_date);
            $receipt_date = $d->format('d-m-Y');

            switch ($worker_device->type_device_id) {
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

            $worker = $worker_device->get_attach_worker();
            if ($worker) {
                $worker_id = $worker->id;
            }
            else {
                $worker_id = '';
            }
            $responsible = $worker_device->get_responsible();
            $provider = $worker_device->provider;
            $category = $worker_device->category;
            $purchase_price = $worker_device->purchase_price;
        ?>
        <div class="tab-content-wrapper__list-item" id="{{ $worker_device->id }}" worker-id="{{ $worker_id }}">
            <div class="tab-content-wrapper__list-item-head">
                <div class="tab-content-wrapper__list-item-name">{{ $worker_device->name }}</div>
                <div class="tab-content-wrapper__edit-device-btn">
                    @include('edit-btn')
                </div>
                
                @if ($worker)
                    <div class="tab-content-wrapper__unattach-worker-from-device-btn">
                        @include('unattach-worker-btn')
                    </div>                  
                @endif
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
                            <td>{{ $worker_device->model }}</td>
                            <td>{{ $worker_device->serial_number }}</td>
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
                                {{ $worker_device->get_status() }}
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