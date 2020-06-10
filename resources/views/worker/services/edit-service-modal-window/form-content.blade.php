@component('form-content')
    @slot('fields')
        <input type="hidden" name="id">
        @include('worker.services.add-service-modal-window.form-content.__fields')
    @endslot
@endcomponent