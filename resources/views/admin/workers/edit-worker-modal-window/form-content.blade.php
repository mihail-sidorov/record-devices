@component('form-content')
    @slot('fields')
        <input type="hidden" name="id">
        @include('admin.workers.add-worker-modal-window.form-content.__fields')
    @endslot
@endcomponent