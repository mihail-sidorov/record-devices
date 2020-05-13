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
        @foreach ($component_parts as $component_part)
            <?php
                $d = new DateTime();

                $d->setTimestamp($component_part->receipt_date);
                $receipt_date = $d->format('d-m-Y');

                $d->setTimestamp($component_part->warranty);
                $warranty = $d->format('d-m-Y');
                if ($component_part->warranty_off()) {
                    $warranty = "Истекла $warranty";
                }

                $provider = $component_part->provider;
                $category = $component_part->category;
                $responsible = $component_part->get_responsible();
            ?>
            <div class="tab-content-wrapper__list-item" id="{{ $component_part->id }}">
                <div class="tab-content-wrapper__list-item-head">
                    <div class="tab-content-wrapper__list-item-name">{{ $component_part->name }}</div>
                    @include('edit-btn')
                    @include('del-btn')
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
                                <td>{{ $component_part->model }}</td>
                                <td>{{ $component_part->serial_number }}</td>
                                <td>
                                    @if ($responsible)
                                        {{ $responsible->name }}
                                    @endif
                                </td>
                                <td>{{ $component_part->purchase_price }}</td>
                                <td>{{ $component_part->get_status() }}</td>
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

    @include('add-btn')
</div>