@component('tab-content-wrapper')
    @slot('filter')
        @include('admin.work-places.tab-content-wrapper.__filter')
    @endslot

    @slot('list')
        @include('admin.work-places.tab-content-wrapper.__list')
    @endslot
@endcomponent