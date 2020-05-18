<div class="tab-content-wrapper">
    @include('add-btn')

    <div class="tab-content-wrapper__title">Фильтр:</div>    
    <div class="tab-content-wrapper__filter">
        <input class="tab-content-wrapper__filter-field" type="text" placeholder="Наименование">
    </div>

    <div class="tab-content-wrapper__title">Список:</div>
    <div class="tab-content-wrapper__list">
        @foreach ($services as $service)
            <div class="tab-content-wrapper__list-item" id="{{ $service->id }}">
                <input type="hidden" class="tab-content-wrapper__list-item-filter-field" value="{{ $service->name }}">

                <div class="tab-content-wrapper__list-item-head">
                    <div class="tab-content-wrapper__list-item-name">{{ $service->name }}</div>
                    @include('edit-btn')
                    @include('del-btn')
                </div>
                <div class="tab-content-wrapper__list-item-body">
                    <table class="tab-content-wrapper__list-item-body-table">
                        <thead>
                            <tr>
                                <td>Логин</td>
                                <td>Пароль</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ $service->login }}</td>
                                <td>{{ $service->password }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        @endforeach
    </div>
</div>