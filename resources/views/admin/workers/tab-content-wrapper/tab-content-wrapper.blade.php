<div class="tab-content-wrapper">
    <div class="tab-content-wrapper__title">Фильтр:</div>    
    <div class="tab-content-wrapper__filter">
        <input class="tab-content-wrapper__filter-field" type="text" placeholder="ФИО">
        <input class="tab-content-wrapper__filter-field" type="text" placeholder="Должность">
        <select class="tab-content-wrapper__filter-field">
            @foreach ($departments as $department)
                <option value="{{ $department->id }}">{{ $department->name }}</option>
            @endforeach
        </select>
        
        @include('action-btn')
    </div>

    <div class="tab-content-wrapper__title">Список:</div>
    <div class="tab-content-wrapper__list">
        @foreach ($workers as $worker)
            <?php
                $worker_devices = $worker->devices;
            ?>
            <div class="tab-content-wrapper__list-item" id="{{ $worker->id }}">
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
                </div>
            </div>
        @endforeach
    </div>

    @include('add-btn')
</div>