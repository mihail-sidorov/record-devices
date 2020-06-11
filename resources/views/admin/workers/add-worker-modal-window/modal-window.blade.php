@component('modal-window')
    @slot('class', 'add-worker-modal-window')

    @slot('ng_controller', '')

    @slot('name', 'Добавить сотрудника')

    @slot('search', '')

    @slot('form')
        @include('admin.workers.add-worker-modal-window.form-content.form-content')
    @endslot
@endcomponent