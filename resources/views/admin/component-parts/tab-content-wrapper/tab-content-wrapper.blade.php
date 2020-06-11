@component('tab-content-wrapper')
    @slot('filter')
        @include('admin.component-parts.tab-content-wrapper.__filter')
    @endslot

    @slot('list')
        @include('admin.component-parts.tab-content-wrapper.__list')
    @endslot
@endcomponent