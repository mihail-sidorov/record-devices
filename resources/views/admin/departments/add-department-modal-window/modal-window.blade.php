@component('modal-window')
    @slot('class', 'add-department-modal-window')

    @slot('ng_controller', '')

    @slot('name', 'Добавить отдел')

    @slot('search', '')

    @slot('form')
        @include('admin.departments.add-department-modal-window.form-content.form-content')
    @endslot
@endcomponent