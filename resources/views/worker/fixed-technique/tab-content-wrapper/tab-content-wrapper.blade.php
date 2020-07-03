@component('tab-content-wrapper')
    @slot('filter')
        @include('worker.fixed-technique.tab-content-wrapper.__filter')
    @endslot

    @slot('list')
        @include('admin.work-places.tab-content-wrapper.__list')
        @include('admin.devices.tab-content-wrapper.__list')
    @endslot
@endcomponent