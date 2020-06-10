@component('tab-content-wrapper')
    @slot('filter')
        @include('worker.services.tab-content-wrapper.__filter')
    @endslot

    @slot('list')
        @include('worker.services.tab-content-wrapper.__list')
    @endslot
@endcomponent