@component('tab-content-wrapper')
    @slot('filter')
        @include('admin.acts.tab-content-wrapper.__filter')
    @endslot

    @slot('list')
        @include('admin.acts.tab-content-wrapper.__list')
    @endslot
@endcomponent