@component('modal-window')
    @slot('class', 'create-act-modal-window')

    @slot('ng_controller', '')

    @slot('name', 'Создать акт')

    @slot('search', '')

    @slot('form')
        @include('admin.workers.create-act-modal-window.form-content')
    @endslot
@endcomponent