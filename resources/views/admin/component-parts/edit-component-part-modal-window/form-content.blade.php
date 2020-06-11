@component('form-content')
    @slot('fields')
        <input type="hidden" name="id">
        @include('admin.component-parts.add-component-part-modal-window.form-content.__fields')
    @endslot
@endcomponent