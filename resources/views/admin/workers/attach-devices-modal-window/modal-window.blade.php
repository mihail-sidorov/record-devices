@component('modal-window')
    @slot('class', 'multi-attach-modal-window attach-devices-modal-window')

    @slot('ng_controller', '')

    @slot('name', 'Прикрепить устройства')

    @slot('search', '')

    @slot('form')
        @include('admin.work-places.attach-component-parts-modal-window.__categories')
    @endslot
@endcomponent