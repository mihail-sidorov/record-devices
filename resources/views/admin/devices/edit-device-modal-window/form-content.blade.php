@component('form-content')
    @slot('fields')
        <input type="hidden" name="id">
        @include('admin.devices.add-device-modal-window.form-content.__fields')
    @endslot
@endcomponent