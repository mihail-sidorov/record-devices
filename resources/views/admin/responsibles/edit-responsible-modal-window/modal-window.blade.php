@component('modal-window')
    @slot('class', 'edit-responsible-modal-window')

    @slot('ng_controller', '')

    @slot('name', 'Редактировать ответственного')

    @slot('search', '')

    @slot('form')
        @include('admin.responsibles.edit-responsible-modal-window.form-content')
    @endslot
@endcomponent