@component('form-content')
    @slot('fields')
        <input type="hidden" name="id">
        @include('admin.departments.add-department-modal-window.form-content.__fields')
    @endslot
@endcomponent