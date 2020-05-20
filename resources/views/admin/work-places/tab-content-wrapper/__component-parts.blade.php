<div class="tab-content-wrapper__list component_parts">
    @foreach ($device_component_parts as $device_component_part)
        <?php
            $d = new DateTime();

            $d->setTimestamp($device_component_part->receipt_date);
            $receipt_date = $d->format('d-m-Y');

            $d->setTimestamp($device_component_part->warranty);
            $warranty = $d->format('d-m-Y');
            if ($device_component_part->warranty_off()) {
                $warranty = "Истекла $warranty";
            }

            $provider = $device_component_part->provider;
            $category = $device_component_part->category;
            $responsible = $device_component_part->get_responsible();
        ?>
        <div class="tab-content-wrapper__list-item" id="{{ $device_component_part->id }}">
            <div class="tab-content-wrapper__list-item-head">
                <div class="tab-content-wrapper__list-item-name">{{ $device_component_part->name }}</div>
                <div class="tab-content-wrapper__edit-component-part-btn">
                    @include('edit-btn')
                </div>
            </div>
            <div class="tab-content-wrapper__list-item-body">
                <table class="tab-content-wrapper__list-item-body-table">
                    <thead>
                        <tr>
                            <td>Категория</td>
                            <td>Модель</td>
                            <td>Серийный номер</td>
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
                            <td>
                                @if ($category)
                                    {{ $category->name }}
                                @endif
                            </td>
                            <td>{{ $device_component_part->model }}</td>
                            <td>{{ $device_component_part->serial_number }}</td>
                            <td>
                                @if ($responsible)
                                    {{ $responsible->name }}
                                @endif
                            </td>
                            <td>{{ $device_component_part->purchase_price }}</td>
                            <td>{{ $device_component_part->get_status() }}</td>
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