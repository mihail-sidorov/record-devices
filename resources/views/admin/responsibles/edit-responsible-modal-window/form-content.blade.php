@component('form-content')
    @slot('fields')
        <input type="hidden" name="id">
        @include('admin.responsibles.add-responsible-modal-window.form-content.__fields')
    @endslot
@endcomponent