<div class="modal-window attach-worker-modal-window" ng-controller="attachWorkerModalWindowAngularController">
    <div class="modal-window__cover"></div>
    <div class="modal-window__wrapper">
        <div class="modal-window__content">
            <div class="modal-window__close"></div>
            <div class="modal-window__head">Прикрепить сотрудника<%= name %></div>
            <div class="modal-window__body">
                @include('admin.devices.attach-worker-modal-window.form-content')
            </div>
        </div>
    </div>
</div>