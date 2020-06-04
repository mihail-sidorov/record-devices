@component('modal-window')
    @slot('class', 'add-device-modal-window')

    @slot('ng_controller', '')

    @slot('name', 'Добавить устройство')

    @slot('search', '')

    @slot('form')
        @include('admin.devices.add-device-modal-window.form-content.form-content')
    @endslot
@endcomponent