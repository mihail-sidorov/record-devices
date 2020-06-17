@component('modal-window')
    @slot('class', 'change-password-modal-window')

    @slot('ng_controller', '')

    @slot('name', 'Редактировать пароль')

    @slot('search', '')

    @slot('form')
        @include('admin.workers.change-password-modal-window.form-content')
    @endslot
@endcomponent