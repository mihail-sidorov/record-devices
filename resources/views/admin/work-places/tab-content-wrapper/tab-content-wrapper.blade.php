<div class="tab-content-wrapper">
    @include('add-btn')

    <div class="tab-content-wrapper__title">Список:</div>
    <div class="tab-content-wrapper__list">
        @foreach ($work_places as $work_place)
            <?php
                $worker = $work_place->get_attach_worker();
                if ($worker) {
                    $worker_id = $worker->id;
                }
                else {
                    $worker_id = '';
                }

                $responsible = $work_place->get_responsible();
                
                $work_place_component_parts = $work_place->component_parts;
                $purchase_price = 0;
                if (count($work_place_component_parts)) {
                    foreach ($work_place_component_parts as $work_place_component_part) {
                        $purchase_price += $work_place_component_part->purchase_price;
                    }
                }
            ?>
            <div class="tab-content-wrapper__list-item" id="{{ $work_place->id }}" worker_id="{{ $worker_id }}">
                <div class="tab-content-wrapper__list-item-head">
                    <div class="tab-content-wrapper__list-item-name">{{ $work_place->name }}</div>

                    @include('attach-component-parts-btn')

                    @if (!$worker)
                        @include('attach-worker-btn')
                    @else
                        @include('unattach-worker-btn')
                    @endif

                    <div class="tab-content-wrapper__edit-work-place-btn">@include('edit-btn')</div>
                    
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
                                    {{ $work_place->get_status() }}
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="tab-content-wrapper__component-parts">
                        <?php
                            if (count($work_place_component_parts)) {
                                ?>
                                @include('admin.work-places.tab-content-wrapper.__component-parts')
                                <?php
                            }
                        ?>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>