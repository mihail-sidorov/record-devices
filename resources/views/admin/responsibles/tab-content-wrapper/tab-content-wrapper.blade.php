@component('tab-content-wrapper')
    @slot('filter')
        @include('admin.responsibles.tab-content-wrapper.__filter')
    @endslot

    @slot('list')
        @include('admin.responsibles.tab-content-wrapper.__list')
    @endslot
@endcomponent