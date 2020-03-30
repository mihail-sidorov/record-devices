@extends('layouts.app')

@section('content')
<div class="content">
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="devices-tab" data-toggle="tab" href="#devices" role="tab" aria-controls="devices" aria-selected="true">Устройства</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="workers-tab" data-toggle="tab" href="#workers" role="tab" aria-controls="workers" aria-selected="false">Сотрудники</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="providers-tab" data-toggle="tab" href="#providers" role="tab" aria-controls="providers" aria-selected="false">Поставщики</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="responsibles-tab" data-toggle="tab" href="#responsibles" role="tab" aria-controls="responsibles" aria-selected="false">Ответственные</a>
        </li>
    </ul>
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active admin-devices-tab-content-controller" id="devices" role="tabpanel" aria-labelledby="devices-tab">
            @include('admin.devices.tab-content-wrapper')
            @include('admin.devices.add-device-modal-window.modal-window')
            @include('admin.devices.edit-device-modal-window.modal-window')
        </div>
        <div class="tab-pane fade admin-workers-tab-content-controller" id="workers" role="tabpanel" aria-labelledby="workers-tab">
            @include('admin.workers.tab-content-wrapper')
            @include('admin.workers.add-worker-modal-window.modal-window')
            @include('admin.workers.edit-worker-modal-window.modal-window')
        </div>
        <div class="tab-pane fade admin-providers-tab-content-controller" id="providers" role="tabpanel" aria-labelledby="providers-tab">
            @include('admin.providers.tab-content-wrapper')
            @include('admin.providers.add-provider-modal-window.modal-window')
            @include('admin.providers.edit-provider-modal-window.modal-window')
        </div>
        <div class="tab-pane fade admin-responsibles-tab-content-controller" id="responsibles" role="tabpanel" aria-labelledby="responsibles-tab">
            @include('admin.responsibles.tab-content-wrapper')
            @include('admin.responsibles.add-responsible-modal-window.modal-window')
            @include('admin.responsibles.edit-responsible-modal-window.modal-window')
        </div>
    </div>
</div>
@endsection
