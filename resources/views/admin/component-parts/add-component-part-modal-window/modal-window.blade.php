@component('modal-window')
    @slot('class', 'add-component-part-modal-window')

    @slot('ng_controller', '')

    @slot('name', 'Добавить комплектующее')

    @slot('search', '')

    @slot('form')
        @include('admin.component-parts.add-component-part-modal-window.form-content.form-content')
    @endslot
@endcomponent