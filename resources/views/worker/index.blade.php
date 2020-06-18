@extends('layouts.app')

@section('content')
<div class="content worker" id="<?php echo Auth::user()->getWorkerId(); ?>">
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link<?php if ($active_tabs['services']) echo $active_tabs['services'][0]; ?>" id="services-tab" data-toggle="tab" href="#services" role="tab" aria-controls="services" aria-selected="true">Сервисы</a>
        </li>
        <div class="worker-settings-controller">
            @include('settings-block')
            @include('admin.workers.edit-worker-modal-window.modal-window')
            @include('admin.workers.change-password-modal-window.modal-window')
        </div>
    </ul>
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade<?php if ($active_tabs['services']) echo $active_tabs['services'][1]; ?> services worker-services-tab-content-controller" id="services" role="tabpanel" aria-labelledby="services-tab">
            @include('worker.services.tab-content-wrapper.tab-content-wrapper')
            @include('worker.services.add-service-modal-window.modal-window')
            @include('worker.services.edit-service-modal-window.modal-window')
        </div>
    </div>
</div>
@endsection
