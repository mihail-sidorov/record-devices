<div class="tab-content-wrapper__list tab-content-wrapper__work-places-lis">
    @foreach ($worker_work_places as $worker_work_place)
        <?php
            $worker = $worker_work_place->get_attach_worker();
            if ($worker) {
                $worker_id = $worker->id;
            }
            else {
                $worker_id = '';
            }

            $responsible = $worker_work_place->get_responsible();
            
            $work_place_component_parts = $worker_work_place->component_parts;
            $purchase_price = 0;
            if (count($work_place_component_parts)) {
                foreach ($work_place_component_parts as $work_place_component_part) {
                    $purchase_price += $work_place_component_part->purchase_price;
                }
            }
        ?>
        <div class="tab-content-wrapper__list-item" id="{{ $worker_work_place->id }}" worker_id="{{ $worker_id }}">
            <div class="tab-content-wrapper__list-item-head">
                <div class="tab-content-wrapper__list-item-name">{{ $worker_work_place->name }}</div>

                @include('attach-component-parts-btn')

                @if ($worker)
                    <div class="tab-content-wrapper__unattach-worker-from-work-place-btn">
                        @include('unattach-worker-btn')
                    </div>
                @endif

                <div class="tab-content-wrapper__edit-work-place-btn">@include('edit-btn')</div>
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
                            <td>{{ $worker_work_place->inventar_number }}</td>
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
                                {{ $worker_work_place->get_status() }}
                            </td>
                        </tr>
                    </tbody>
                </table>

                @if ($work_place_component_parts->count())
                    @include('admin.workers.tab-content-wrapper.__component-parts-list')
                @endif
            </div>
        </div>
    @endforeach
</div>