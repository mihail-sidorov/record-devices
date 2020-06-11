@component('modal-window')
    @slot('class', 'add-responsible-modal-window')

    @slot('ng_controller', '')

    @slot('name', 'Добавить ответственного')

    @slot('search', '')

    @slot('form')
        @include('admin.responsibles.add-responsible-modal-window.form-content.form-content')
    @endslot
@endcomponent