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
                    $type_device = 'Рабочее место';
                    break;
                case 3:
                    $type_device = 'Переферия';
                    break;
                case 4:
                    $type_device = 'Оргтехника';
                    break;
            }

            $worker = $worker_device->get_attach_worker();
            $responsible = $worker_device->get_responsible();
            $provider = $worker_device->provider;
            $category = $worker_device->category;
            $device_component_parts = $worker_device->component_parts;
            $purchase_price = $worker_device->purchase_price;

            if ($device_component_parts->count()) {
                $purchase_price = 0;
                foreach ($device_component_parts as $device_component_part) {
                    $purchase_price += $device_component_part->purchase_price;
                }
            }
        ?>
        <div class="tab-content-wrapper__list-item" id="{{ $worker_device->id }}">
            <div class="tab-content-wrapper__list-item-head">
                <div class="tab-content-wrapper__list-item-name">{{ $worker_device->name }}</div>
                @include('edit-btn')
                
                @if (!$worker)
                    @if (!$device->write_off())
                        @include('attach-worker-btn')
                    @endif
                @else
                    @include('unattach-worker-btn')
                @endif

                @if ($worker_device->component_parts()->count())
                    @include('attach-component-parts-btn')
                @elseif (!$worker_device->write_off())
                    @if ($worker_device->type_device_id === 2)
                        @include('attach-component-parts-btn')
                    @endif
                @endif

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
                            <td>{{ $worker_device->model }}</td>
                            <td>{{ $worker_device->serial_number }}</td>
                            <td>{{ $type_device }}</td>
                            <td>{{ $receipt_date }}</td>
                            <td>{{ $purchase_price }}</td>
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
                                {{ $worker_device->get_status() }}
                            </td>
                            <td>
                                @if ($category)
                                    {{ $category->name }}
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>

                <div class="tab-content-wrapper__component-parts">
                    @if ($device_component_parts->count())
                        @include('admin.workers.tab-content-wrapper.__component-parts-list')
                    @endif
                </div>
            </div>
        </div>
    @endforeach
</div>