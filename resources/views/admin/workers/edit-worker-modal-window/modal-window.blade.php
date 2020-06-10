@component('modal-window')
    @slot('class', 'edit-worker-modal-window')

    @slot('ng_controller', '')

    @slot('name', 'Редактировать сотрудника')

    @slot('search', '')

    @slot('form')
        @include('admin.workers.edit-worker-modal-window.form-content')
    @endslot
@endcomponent