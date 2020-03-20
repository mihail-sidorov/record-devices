@extends('layouts.app')

@section('content')
<div class="content">
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="devices-tab" data-toggle="tab" href="#devices" role="tab" aria-controls="devices" aria-selected="true">Устройства</a>
        </li>
    </ul>
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active worker-devices-tab-content-controller" id="devices" role="tabpanel" aria-labelledby="devices-tab">
            @include('worker.devices.tab-content-wrapper')
        </div>
    </div>
</div>
@endsection
