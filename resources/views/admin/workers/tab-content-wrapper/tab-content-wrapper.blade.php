@component('tab-content-wrapper')
    @slot('filter')
        @include('admin.workers.tab-content-wrapper.__filter')
    @endslot

    @slot('list')
        @include('admin.workers.tab-content-wrapper.__list')
    @endslot
@endcomponent