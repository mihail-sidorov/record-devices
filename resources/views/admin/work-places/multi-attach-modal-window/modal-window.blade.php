@component('modal-window')
    @slot('class', 'multi-attach-modal-window')

    @slot('ng_controller', '')

    @slot('name', 'Прикрепить комплектующие')

    @slot('search', '')

    @slot('form')
        @include('admin.work-places.multi-attach-modal-window.__categories')
    @endslot
@endcomponent