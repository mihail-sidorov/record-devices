@component('modal-window')
    @slot('class', 'add-category-modal-window')

    @slot('ng_controller', '')

    @slot('name', 'Добавить категорию')

    @slot('search', '')

    @slot('form')
        @include('admin.categories.add-category-modal-window.form-content.form-content')
    @endslot
@endcomponent