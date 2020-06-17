@component('form-content')
    @slot('fields')
        @include('admin.workers.add-worker-modal-window.form-content.__fields', ['add' => true])
    @endslot
@endcomponent