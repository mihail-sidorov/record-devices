@component('modal-window')
    @slot('class', 'edit-provider-modal-window')

    @slot('ng_controller', '')

    @slot('name', 'Редактировать поставщика')

    @slot('search', '')

    @slot('form')
        @include('admin.providers.edit-provider-modal-window.form-content')
    @endslot
@endcomponent