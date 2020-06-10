@component('form-content')
    @slot('fields')
        <input type="hidden" name="id">
        @include('admin.categories.add-category-modal-window.form-content.__fields')
    @endslot
@endcomponent