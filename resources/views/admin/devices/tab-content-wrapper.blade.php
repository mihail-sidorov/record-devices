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
                date_default_timezone_set('Europe/Moscow');

                $status = 1;
                $current_date = new DateTime();
                $current_date_timestamp = $current_date->getTimestamp();
                if ($current_date_timestamp - $device->receipt_date > 1728000) {
                    $status = 0;
                }

                $ts = $device->receipt_date;
                $d = new DateTime();
                $d->setTimestamp($ts);
                $device->receipt_date = $d->format('d-m-Y');

                $ts = $device->warranty;
                $d = new DateTime();
                $d->setTimestamp($ts);
                $device->warranty = $d->format('d-m-Y');

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

                $device_worker_count = $device->device_worker()->count();
                $device_worker_last = $device->device_worker()->orderby('id', 'desc')->first();
                $worker = null;
                $responsible = null;
            ?>
            <div class="tab-content-wrapper__list-item" id="{{ $device->id }}">
                <div class="tab-content-wrapper__list-item-head">
                    <div class="tab-content-wrapper__list-item-name">{{ $device->name }}</div>
                    @include('edit-btn')
                    
                    @if ($device_worker_count === 0)
                        <?php if ($status) { ?>
                            @include('attach-worker-btn')
                        <?php } ?>
                    @elseif ($device_worker_last->attach)
                        @include('unattach-worker-btn')
                        <?php
                            $status = 2;
                            $worker = App\Workers::find($device_worker_last->worker_id);
                            $responsible = $worker->responsible;
                        ?>
                    @else
                        <?php if ($status) { ?>
                            @include('attach-worker-btn')
                        <?php } ?>
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
                                <td>Срок гарантии (дата окончания)</td>
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
                                <td>{{ $type_device }}</td>
                                <td>{{ $device->receipt_date }}</td>
                                <td>{{ $device->purchase_price }}</td>
                                <td>{{ $device->warranty }}</td>
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
                                <td></td>
                                <td>
                                    <?php
                                        switch ($status) {
                                            case 0:
                                                $status = 'Списан';
                                                break;
                                            case 1:
                                                $status = 'На складе';
                                                break;
                                            case 2:
                                                $status = 'Выдан';
                                                break;
                                        }

                                        echo $status;
                                    ?>
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