@extends('layouts.app')

@section('content')
<div class="content">
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link<?php if ($active_tabs['services']) echo $active_tabs['services'][0]; ?>" id="services-tab" data-toggle="tab" href="#services" role="tab" aria-controls="services" aria-selected="true">Сервисы</a>
        </li>
    </ul>
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade<?php if ($active_tabs['services']) echo $active_tabs['services'][1]; ?> worker-services-tab-content-controller" id="services" role="tabpanel" aria-labelledby="services-tab">

        </div>
    </div>
</div>
@endsection
