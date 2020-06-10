@component('modal-window')
    @slot('class', 'edit-service-modal-window')

    @slot('ng_controller', '')

    @slot('name', 'Редактировать сервис')

    @slot('search', '')

    @slot('form')
        @include('worker.services.edit-service-modal-window.form-content')
    @endslot
@endcomponent