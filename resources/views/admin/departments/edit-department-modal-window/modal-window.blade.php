@component('modal-window')
    @slot('class', 'edit-department-modal-window')

    @slot('ng_controller', '')

    @slot('name', 'Редактировать отдел')

    @slot('search', '')

    @slot('form')
        @include('admin.departments.edit-department-modal-window.form-content')
    @endslot
@endcomponent