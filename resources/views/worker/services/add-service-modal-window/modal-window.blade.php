@component('modal-window')
    @slot('class', 'add-service-modal-window')

    @slot('ng_controller', '')

    @slot('name', 'Добавить сервис')

    @slot('search', '')

    @slot('form')
        @include('worker.services.add-service-modal-window.form-content.form-content')
    @endslot
@endcomponent