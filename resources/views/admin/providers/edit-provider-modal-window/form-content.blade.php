@component('form-content')
    @slot('fields')
        <input type="hidden" name="id">
        @include('admin.providers.add-provider-modal-window.form-content.__fields')
    @endslot
@endcomponent