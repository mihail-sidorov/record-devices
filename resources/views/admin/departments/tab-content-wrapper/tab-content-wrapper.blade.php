@component('tab-content-wrapper')
    @slot('filter')
        @include('admin.departments.tab-content-wrapper.__filter')
    @endslot

    @slot('list')
        @include('admin.departments.tab-content-wrapper.__list')
    @endslot
@endcomponent