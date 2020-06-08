@component('modal-window')
    @slot('class', 'attach-worker-modal-window')

    @slot('ng_controller')
        ng-controller="attachWorkerToWorkPlaceAngularController"
    @endslot

    @slot('name', 'Прикрепить сотрудника')

    @slot('search')
        @include('admin.devices.attach-worker-modal-window.__search')
    @endslot

    @slot('form')
        @include('admin.devices.attach-worker-modal-window.form-content')
    @endslot
@endcomponent