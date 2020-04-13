@extends('layouts.app')

@section('content')
<div class="content">
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link<?php if ($active_tabs['devices']) echo $active_tabs['devices'][0]; ?>" id="devices-tab" data-toggle="tab" href="#devices" role="tab" aria-controls="devices" aria-selected="true">Устройства</a>
        </li>
        <li class="nav-item">
            <a class="nav-link<?php if ($active_tabs['workers']) echo $active_tabs['workers'][0]; ?>" id="workers-tab" data-toggle="tab" href="#workers" role="tab" aria-controls="workers" aria-selected="false">Сотрудники</a>
        </li>
        <li class="nav-item">
            <a class="nav-link<?php if ($active_tabs['providers']) echo $active_tabs['providers'][0]; ?>" id="providers-tab" data-toggle="tab" href="#providers" role="tab" aria-controls="providers" aria-selected="false">Поставщики</a>
        </li>
        <li class="nav-item">
            <a class="nav-link<?php if ($active_tabs['responsibles']) echo $active_tabs['responsibles'][0]; ?>" id="responsibles-tab" data-toggle="tab" href="#responsibles" role="tab" aria-controls="responsibles" aria-selected="false">Ответственные</a>
        </li>
        <li class="nav-item">
            <a class="nav-link<?php if ($active_tabs['departments']) echo $active_tabs['departments'][0]; ?>" id="departments-tab" data-toggle="tab" href="#departments" role="tab" aria-controls="departments" aria-selected="false">Отделы</a>
        </li>
    </ul>
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade<?php if ($active_tabs['devices']) echo $active_tabs['devices'][1]; ?> admin-devices-tab-content-controller" id="devices" role="tabpanel" aria-labelledby="devices-tab">
            @include('admin.devices.tab-content-wrapper')
            @include('admin.devices.add-device-modal-window.modal-window')
            @include('admin.devices.edit-device-modal-window.modal-window')
            @include('admin.devices.attach-worker-modal-window.modal-window')
        </div>
        <div class="tab-pane fade<?php if ($active_tabs['workers']) echo $active_tabs['workers'][1]; ?> admin-workers-tab-content-controller" id="workers" role="tabpanel" aria-labelledby="workers-tab">
            @include('admin.workers.tab-content-wrapper')
            @include('admin.workers.add-worker-modal-window.modal-window')
            @include('admin.workers.edit-worker-modal-window.modal-window')
        </div>
        <div class="tab-pane fade<?php if ($active_tabs['providers']) echo $active_tabs['providers'][1]; ?> admin-providers-tab-content-controller" id="providers" role="tabpanel" aria-labelledby="providers-tab">
            @include('admin.providers.tab-content-wrapper')
            @include('admin.providers.add-provider-modal-window.modal-window')
            @include('admin.providers.edit-provider-modal-window.modal-window')
        </div>
        <div class="tab-pane fade<?php if ($active_tabs['responsibles']) echo $active_tabs['responsibles'][1]; ?> admin-responsibles-tab-content-controller" id="responsibles" role="tabpanel" aria-labelledby="responsibles-tab">
            @include('admin.responsibles.tab-content-wrapper')
            @include('admin.responsibles.add-responsible-modal-window.modal-window')
            @include('admin.responsibles.edit-responsible-modal-window.modal-window')
        </div>
        <div class="tab-pane fade<?php if ($active_tabs['departments']) echo $active_tabs['departments'][1]; ?> admin-departments-tab-content-controller" id="departments" role="tabpanel" aria-labelledby="departments-tab">
            @include('admin.departments.tab-content-wrapper')
            @include('admin.departments.add-department-modal-window.modal-window')
            @include('admin.departments.edit-department-modal-window.modal-window')
        </div>
    </div>
</div>
@endsection
