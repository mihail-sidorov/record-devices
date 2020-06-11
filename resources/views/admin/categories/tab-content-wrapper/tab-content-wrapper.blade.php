@component('tab-content-wrapper')
    @slot('filter')
        @include('admin.categories.tab-content-wrapper.__filter')
    @endslot

    @slot('list')
        @include('admin.categories.tab-content-wrapper.__list')
    @endslot
@endcomponent