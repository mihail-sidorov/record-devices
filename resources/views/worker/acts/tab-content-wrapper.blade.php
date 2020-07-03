@component('tab-content-wrapper')
    @slot('filter', '')

    @slot('list')
        @include('admin.acts.tab-content-wrapper.__list')
    @endslot
@endcomponent