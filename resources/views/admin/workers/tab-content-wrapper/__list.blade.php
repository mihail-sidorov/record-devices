<div class="tab-content-wrapper__list">
    @foreach ($workers as $worker)
        <?php
            $worker_devices = $worker->devices;
            $worker_work_places = $worker->work_places;
            $worker_services = $worker->services;
        ?>
        <div class="tab-content-wrapper__list-item" id="{{ $worker->id }}">
            <input type="hidden" class="tab-content-wrapper__list-item-filter-field" value="{{ $worker->name }}">
            <input type="hidden" class="tab-content-wrapper__list-item-filter-field" value="{{ $worker->post }}">
            <input type="hidden" class="tab-content-wrapper__list-item-filter-field" value="{{ $worker->department_id }}">

            <div class="tab-content-wrapper__list-item-head">
                <div class="tab-content-wrapper__list-item-name">{{ $worker->name }}</div>

                @include('btns.attach-devices-btn')

                @include('btns.change-password-btn')

                @include('btns.create-act-btn')

                <div class="edit-worker-btn">@include('btns.edit-btn')</div>

                <div class="del-worker-btn">
                    @include('btns.del-btn')
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

                <div class="tab-content-wrapper__list tab-content-wrapper__fixed-technique-list">
                    @if ($worker_work_places->count() || $worker_devices->count())
                        <div class="tab-content-wrapper__list-item">
                            <div class="tab-content-wrapper__list-item-head">
                                <div class="tab-content-wrapper__list-item-name">Закрепленная техника</div>
                            </div>
                            <div class="tab-content-wrapper__list-item-body">
                                @if ($worker_work_places->count())
                                    @include('admin.workers.tab-content-wrapper.__work-places-list')
                                @endif
                                
                                @if ($worker_devices->count())
                                    @include('admin.workers.tab-content-wrapper.__devices-list')
                                @endif
                            </div>
                        </div>
                    @endif

                    @if ($worker_services->count())
                        <div class="tab-content-wrapper__list-item tab-content-wrapper__services-list">
                            <div class="tab-content-wrapper__list-item-head">
                                <div class="tab-content-wrapper__list-item-name">Сервисы</div>
                            </div>
                            <div class="tab-content-wrapper__list-item-body">
                                @include('worker.services.tab-content-wrapper.__list', ['services' => $worker_services])
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endforeach
</div>