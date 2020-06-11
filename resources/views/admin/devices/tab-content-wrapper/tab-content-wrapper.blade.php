@component('tab-content-wrapper')
    @slot('filter')
        @include('admin.devices.tab-content-wrapper.__filter')
    @endslot

    @slot('list')
        @include('admin.devices.tab-content-wrapper.__list')
    @endslot
@endcomponent