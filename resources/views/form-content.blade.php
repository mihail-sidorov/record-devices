<form class="form-content">
    @csrf

    {{ $fields }}

    @include('btns.action-btn')
</form>