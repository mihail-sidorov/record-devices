<div class="tab-content-wrapper">
    @include('add-btn')

    <div class="tab-content-wrapper__title">Список:</div>
    <div class="tab-content-wrapper__list">
        @foreach ($work_places as $work_place)
            <?php
                // $worker = $work_place->get_attach_worker();
                // $responsible = $work_place->get_responsible();
                // $work_place_component_parts = $work_place->component_parts;
                // $purchase_price = 0;

                // if ($work_place_component_parts->count()) {
                //     foreach ($work_place_component_parts as $work_place_component_part) {
                //         $purchase_price += $work_place_component_part->purchase_price;
                //     }
                // }
            ?>
            <div class="tab-content-wrapper__list-item" id="{{ $work_place->id }}">
                <div class="tab-content-wrapper__list-item-head">
                    <div class="tab-content-wrapper__list-item-name">{{ $work_place->name }}</div>

                    @include('attach-component-parts-btn')
                    
                    @include('edit-btn')

                    @include('del-btn')
                </div>
                <div class="tab-content-wrapper__list-item-body">
                    <table class="tab-content-wrapper__list-item-body-table">
                        <thead>
                            <tr>
                                <td>Инвентарный номер</td>
                                <td>Выдано сотруднику</td>
                                <td>Ответственный</td>
                                <td>Закупочная цена</td>
                                <td>Статус</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ $work_place->inventar_number }}</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="tab-content-wrapper__component-parts">
                        
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>