@component('modal-window')
    @slot('class', 'add-work-place-modal-window')

    @slot('ng_controller', '')

    @slot('name', 'Добавить рабочее место')

    @slot('search', '')

    @slot('form')
        @include('admin.work-places.add-work-place-modal-window.form-content.form-content')
    @endslot
@endcomponent