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
        <div class="tab-pane fade show active" id="devices" role="tabpanel" aria-labelledby="devices-tab">@include('admin.tab-content-wrapper')</div>
        <div class="tab-pane fade" id="workers" role="tabpanel" aria-labelledby="workers-tab">workers</div>
        <div class="tab-pane fade" id="providers" role="tabpanel" aria-labelledby="providers-tab">providers</div>
        <div class="tab-pane fade" id="responsibles" role="tabpanel" aria-labelledby="responsibles-tab">responsibles</div>
    </div>
</div>
@endsection
