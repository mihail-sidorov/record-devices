<div class="tab-content-wrapper">
    @include('add-btn')

    <div class="tab-content-wrapper__title">Фильтр:</div>    
    <div class="tab-content-wrapper__filter">
        <input class="tab-content-wrapper__filter-field" type="text" placeholder="ФИО">
        <input class="tab-content-wrapper__filter-field" type="text" placeholder="Должность">
        <select class="tab-content-wrapper__filter-field">
            <option value="">Все отделы</option>
            @foreach ($departments as $department)
                <option value="{{ $department->id }}">{{ $department->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="tab-content-wrapper__title">Список:</div>
    <div class="tab-content-wrapper__list">
        @foreach ($workers as $worker)
            <?php
                $worker_devices = $worker->devices;
                $worker_work_places = $worker->work_places;
            ?>
            <div class="tab-content-wrapper__list-item" id="{{ $worker->id }}">
                <input type="hidden" class="tab-content-wrapper__list-item-filter-field" value="{{ $worker->name }}">
                <input type="hidden" class="tab-content-wrapper__list-item-filter-field" value="{{ $worker->post }}">
                <input type="hidden" class="tab-content-wrapper__list-item-filter-field" value="{{ $worker->department_id }}">

                <div class="tab-content-wrapper__list-item-head">
                    <div class="tab-content-wrapper__list-item-name">{{ $worker->name }}</div>
                    <div class="tab-content-wrapper__edit-worker-btn">
                        @include('edit-btn')
                    </div>

                    @include('attach-devices-btn')

                    <div class="tab-content-wrapper__del-worker-btn">
                        @include('del-btn')
                    </div>
                </div>
                <div class="tab-content-wrapper__list-item-body">
                    <table class="tab-content-wrapper__list-item-body-table">
                        <thead>
                            <tr>
                                <td>Должность</td>
                                <td>Отдел</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ $worker->post }}</td>
                                <td>
                                    @if ($worker->department)
                                        {{ $worker->department->name }}
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    @if ($worker_devices->count())
                        @include('admin.workers.tab-content-wrapper.__devices-list')
                    @endif

                    @if ($worker_work_places->count())
                        @include('admin.workers.tab-content-wrapper.__work-places-list')
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</div>