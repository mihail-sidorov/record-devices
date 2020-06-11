@component('form-content')
    @slot('fields')
        <input type="hidden" name="id">
        @include('admin.work-places.add-work-place-modal-window.form-content.__fields')
    @endslot
@endcomponent