@component('modal-window')
    @slot('class', 'edit-work-place-modal-window')

    @slot('ng_controller', '')

    @slot('name', 'Редактировать рабочее место')

    @slot('search', '')

    @slot('form')
        @include('admin.work-places.edit-work-place-modal-window.form-content')
    @endslot
@endcomponent