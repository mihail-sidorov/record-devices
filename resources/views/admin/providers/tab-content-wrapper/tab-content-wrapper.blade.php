@component('tab-content-wrapper')
    @slot('filter')
        @include('admin.providers.tab-content-wrapper.__filter')
    @endslot

    @slot('list')
        @include('admin.providers.tab-content-wrapper.__list')
    @endslot
@endcomponent