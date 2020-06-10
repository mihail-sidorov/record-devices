@component('modal-window')
    @slot('class', 'add-provider-modal-window')

    @slot('ng_controller', '')

    @slot('name', 'Добавить поставщика')

    @slot('search', '')

    @slot('form')
        @include('admin.providers.add-provider-modal-window.form-content.form-content')
    @endslot
@endcomponent