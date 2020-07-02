@extends('layouts.app')

@section('content')
<div class="content admin">
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link<?php if ($active_tabs['devices']) echo $active_tabs['devices'][0]; ?>" id="devices-tab" data-toggle="tab" href="#devices" role="tab" aria-controls="devices" aria-selected="true">Устройства</a>
        </li>
        <li class="nav-item">
            <a class="nav-link<?php if ($active_tabs['work-places']) echo $active_tabs['work-places'][0]; ?>" id="work-places-tab" data-toggle="tab" href="#work-places" role="tab" aria-controls="work-places" aria-selected="true">Рабочие места</a>
        </li>
        <li class="nav-item">
            <a class="nav-link<?php if ($active_tabs['component-parts']) echo $active_tabs['component-parts'][0]; ?>" id="component-parts-tab" data-toggle="tab" href="#component-parts" role="tab" aria-controls="component-parts" aria-selected="true">Комплектующие</a>
        </li>
        <li class="nav-item">
            <a class="nav-link<?php if ($active_tabs['workers']) echo $active_tabs['workers'][0]; ?>" id="workers-tab" data-toggle="tab" href="#workers" role="tab" aria-controls="workers" aria-selected="false">Сотрудники</a>
        </li>
        <li class="nav-item">
            <a class="nav-link<?php if ($active_tabs['acts']) echo $active_tabs['acts'][0]; ?>" id="acts-tab" data-toggle="tab" href="#acts" role="tab" aria-controls="acts" aria-selected="false">Акты</a>
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
        <li class="nav-item">
            <a class="nav-link<?php if ($active_tabs['categories']) echo $active_tabs['categories'][0]; ?>" id="categories-tab" data-toggle="tab" href="#categories" role="tab" aria-controls="categories" aria-selected="false">Категории</a>
        </li>
    </ul>
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade<?php if ($active_tabs['devices']) echo $active_tabs['devices'][1]; ?> devices admin-devices-tab-content-controller" id="devices" role="tabpanel" aria-labelledby="devices-tab">
            @include('admin.devices.tab-content-wrapper.tab-content-wrapper')
            @include('admin.devices.add-device-modal-window.modal-window')
            @include('admin.devices.edit-device-modal-window.modal-window')
            @include('admin.devices.attach-worker-modal-window.modal-window')
        </div>
        <div class="tab-pane fade<?php if ($active_tabs['work-places']) echo $active_tabs['work-places'][1]; ?> work-places admin-work-places-tab-content-controller" id="work-places" role="tabpanel" aria-labelledby="work-places-tab">
            @include('admin.work-places.tab-content-wrapper.tab-content-wrapper')
            @include('admin.work-places.add-work-place-modal-window.modal-window')
            @include('admin.work-places.edit-work-place-modal-window.modal-window')
            @include('admin.work-places.attach-component-parts-modal-window.modal-window')
            @include('admin.work-places.attach-worker-modal-window.modal-window')
            @include('admin.component-parts.edit-component-part-modal-window.modal-window')
        </div>
        <div class="tab-pane fade<?php if ($active_tabs['component-parts']) echo $active_tabs['component-parts'][1]; ?> component-parts admin-component-parts-tab-content-controller" id="component-parts" role="tabpanel" aria-labelledby="component-parts-tab">
            @include('admin.component-parts.tab-content-wrapper.tab-content-wrapper')
            @include('admin.component-parts.add-component-part-modal-window.modal-window')
            @include('admin.component-parts.edit-component-part-modal-window.modal-window')
        </div>
        <div class="tab-pane fade<?php if ($active_tabs['workers']) echo $active_tabs['workers'][1]; ?> workers admin-workers-tab-content-controller" id="workers" role="tabpanel" aria-labelledby="workers-tab">
            @include('admin.workers.tab-content-wrapper.tab-content-wrapper')
            @include('admin.workers.add-worker-modal-window.modal-window')
            @include('admin.workers.edit-worker-modal-window.modal-window')
            @include('admin.workers.attach-devices-modal-window.modal-window')
            @include('admin.work-places.attach-component-parts-modal-window.modal-window')
            @include('admin.work-places.edit-work-place-modal-window.modal-window')
            @include('admin.devices.edit-device-modal-window.modal-window')
            @include('admin.component-parts.edit-component-part-modal-window.modal-window')
            @include('admin.workers.change-password-modal-window.modal-window')
            @include('admin.workers.create-act-modal-window.modal-window')
            @include('worker.services.edit-service-modal-window.modal-window')
        </div>
        <div class="tab-pane fade<?php if ($active_tabs['acts']) echo $active_tabs['acts'][1]; ?> acts admin-acts-tab-content-controller" id="acts" role="tabpanel" aria-labelledby="acts-tab">
            @include('admin.acts.tab-content-wrapper.tab-content-wrapper')
        </div>
        <div class="tab-pane fade<?php if ($active_tabs['providers']) echo $active_tabs['providers'][1]; ?> providers admin-providers-tab-content-controller" id="providers" role="tabpanel" aria-labelledby="providers-tab">
            @include('admin.providers.tab-content-wrapper.tab-content-wrapper')
            @include('admin.providers.add-provider-modal-window.modal-window')
            @include('admin.providers.edit-provider-modal-window.modal-window')
        </div>
        <div class="tab-pane fade<?php if ($active_tabs['responsibles']) echo $active_tabs['responsibles'][1]; ?> responsibles admin-responsibles-tab-content-controller" id="responsibles" role="tabpanel" aria-labelledby="responsibles-tab">
            @include('admin.responsibles.tab-content-wrapper.tab-content-wrapper')
            @include('admin.responsibles.add-responsible-modal-window.modal-window')
            @include('admin.responsibles.edit-responsible-modal-window.modal-window')
        </div>
        <div class="tab-pane fade<?php if ($active_tabs['departments']) echo $active_tabs['departments'][1]; ?> departments admin-departments-tab-content-controller" id="departments" role="tabpanel" aria-labelledby="departments-tab">
            @include('admin.departments.tab-content-wrapper.tab-content-wrapper')
            @include('admin.departments.add-department-modal-window.modal-window')
            @include('admin.departments.edit-department-modal-window.modal-window')
        </div>
        <div class="tab-pane fade<?php if ($active_tabs['categories']) echo $active_tabs['categories'][1]; ?> categories admin-categories-tab-content-controller" id="categories" role="tabpanel" aria-labelledby="categories-tab">
            @include('admin.categories.tab-content-wrapper.tab-content-wrapper')
            @include('admin.categories.add-category-modal-window.modal-window')
            @include('admin.categories.edit-category-modal-window.modal-window')
        </div>
    </div>
</div>
@endsection
