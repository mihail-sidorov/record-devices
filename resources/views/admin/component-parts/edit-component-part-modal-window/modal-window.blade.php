@component('modal-window')
    @slot('class', 'edit-component-part-modal-window')

    @slot('ng_controller', '')

    @slot('name', 'Редактировать комплектующее')

    @slot('search', '')

    @slot('form')
        @include('admin.component-parts.edit-component-part-modal-window.form-content')
    @endslot
@endcomponent