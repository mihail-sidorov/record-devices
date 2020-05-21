<div class="modal-window attach-worker-modal-window" ng-controller="attachWorkerToDeviceAngularController">
    <div class="modal-window__cover"></div>
    <div class="modal-window__wrapper">
        <div class="modal-window__content">
            <div class="modal-window__close"></div>
            <div class="modal-window__head">Прикрепить сотрудника</div>
            <div class="modal-window__body">
                <div class="attach-worker-modal-window__search">
                    <div class="attach-worker-modal-window__search-title">Поиск:</div>
                    <input type="text" class="attach-worker-modal-window__search-input">
                </div>
                @include('admin.devices.attach-worker-modal-window.form-content')
            </div>
        </div>
    </div>
</div>