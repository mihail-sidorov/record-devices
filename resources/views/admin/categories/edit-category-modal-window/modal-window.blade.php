@component('modal-window')
    @slot('class', 'edit-category-modal-window')

    @slot('ng_controller', '')

    @slot('name', 'Редактировать категорию')

    @slot('search', '')

    @slot('form')
        @include('admin.categories.edit-category-modal-window.form-content')
    @endslot
@endcomponent