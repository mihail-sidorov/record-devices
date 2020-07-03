<div class="tab-content-wrapper__list tab-content-wrapper__component_parts">
    @foreach ($work_place_component_parts as $work_place_component_part)
        <?php
            $d = new DateTime();

            $d->setTimestamp($work_place_component_part->receipt_date);
            $receipt_date = $d->format('d-m-Y');

            $d->setTimestamp($work_place_component_part->warranty);
            $warranty = $d->format('d-m-Y');
            if ($work_place_component_part->warranty_off()) {
                $warranty = "Истекла $warranty";
            }

            $provider = $work_place_component_part->provider;
            $category = $work_place_component_part->category;
            $responsible = $work_place_component_part->get_responsible();
        ?>
        <div class="tab-content-wrapper__list-item" id="{{ $work_place_component_part->id }}">
            <div class="tab-content-wrapper__list-item-head">
                <div class="tab-content-wrapper__list-item-name">{{ $work_place_component_part->name }}</div>

                @if(Auth::user()->role === 'admin')
                    <div class="edit-component-part-btn">
                        @include('btns.edit-btn')
                    </div>
                @endif
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
                            <td>{{ $work_place_component_part->model }}</td>
                            <td>{{ $work_place_component_part->serial_number }}</td>
                            <td>
                                @if ($responsible)
                                    {{ $responsible->name }}
                                @endif
                            </td>
                            <td>{{ $work_place_component_part->purchase_price }}</td>
                            <td>{{ $work_place_component_part->get_status() }}</td>
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