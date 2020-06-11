@component('modal-window')
    @slot('class', 'edit-device-modal-window')

    @slot('ng_controller', '')

    @slot('name', 'Редактировать устройство')

    @slot('search', '')

    @slot('form')
        @include('admin.devices.edit-device-modal-window.form-content')
    @endslot
@endcomponent