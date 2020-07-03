@extends('layouts.app')

@section('content')
<div class="content worker" id="<?php echo Auth::user()->getWorkerId(); ?>">
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link<?php if ($active_tabs['services']) echo $active_tabs['services'][0]; ?>" id="services-tab" data-toggle="tab" href="#services" role="tab" aria-controls="services" aria-selected="true">Сервисы</a>
        </li>
        <li class="nav-item">
            <a class="nav-link<?php if ($active_tabs['fixed-technique']) echo $active_tabs['fixed-technique'][0]; ?>" id="fixed-technique-tab" data-toggle="tab" href="#fixed-technique" role="tab" aria-controls="fixed-technique" aria-selected="true">Закрепленная техника</a>
        </li>
        <li class="nav-item">
            <a class="nav-link<?php if ($active_tabs['acts']) echo $active_tabs['acts'][0]; ?>" id="acts-tab" data-toggle="tab" href="#acts" role="tab" aria-controls="acts" aria-selected="true">Акты</a>
        </li>
        <li class="nav-item">
            <a class="nav-link<?php if ($active_tabs['workers']) echo $active_tabs['workers'][0]; ?>" id="workers-tab" data-toggle="tab" href="#workers" role="tab" aria-controls="workers" aria-selected="true">Сотрудники</a>
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
        <div class="tab-pane fade<?php if ($active_tabs['fixed-technique']) echo $active_tabs['fixed-technique'][1]; ?> fixed-technique worker-fixed-technique-tab-content-controller" id="fixed-technique" role="tabpanel" aria-labelledby="fixed-technique-tab">
            @include('worker.fixed-technique.tab-content-wrapper.tab-content-wrapper')
        </div>
        <div class="tab-pane fade<?php if ($active_tabs['acts']) echo $active_tabs['acts'][1]; ?> acts worker-acts-tab-content-controller" id="acts" role="tabpanel" aria-labelledby="acts-tab">
            @include('worker.acts.tab-content-wrapper')
        </div>
        <div class="tab-pane fade<?php if ($active_tabs['workers']) echo $active_tabs['workers'][1]; ?> workers worker-workers-tab-content-controller" id="workers" role="tabpanel" aria-labelledby="workers-tab">
            @include('admin.workers.tab-content-wrapper.tab-content-wrapper')
        </div>
    </div>
</div>
@endsection
