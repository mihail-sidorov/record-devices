<div class="tab-content-wrapper">
    <div class="tab-content-wrapper__title">Фильтр:</div>    
    <div class="tab-content-wrapper__filter">
        <input class="tab-content-wrapper__filter-field" type="text" placeholder="Модель">
        <input class="tab-content-wrapper__filter-field" type="text" placeholder="Серийный номер">
        <select class="tab-content-wrapper__filter-field">
            <option value="">Портативный</option>
            <option value="">Рабочее место</option>
            <option value="">Переферия</option>
            <option value="">Оргтехника</option>
        </select>
        
        @include('action-btn')
    </div>

    <div class="tab-content-wrapper__title">Список:</div>
    <div class="tab-content-wrapper__list">
        <div class="tab-content-wrapper__list-item">
            <div class="tab-content-wrapper__list-item-head">
                <div class="tab-content-wrapper__list-item-name">Устройство 1</div>
                @include('edit-btn')
                @include('del-btn')
            </div>
            <div class="tab-content-wrapper__list-item-body">
                Развернутая информация об устройстве 1
            </div>
        </div>
        <div class="tab-content-wrapper__list-item">
            <div class="tab-content-wrapper__list-item-head">
                <div class="tab-content-wrapper__list-item-name">Устройство 2</div>
                @include('edit-btn')
                @include('del-btn')
            </div>
            <div class="tab-content-wrapper__list-item-body">
                Развернутая информация об устройстве 2
            </div>
        </div>
        <div class="tab-content-wrapper__list-item">
            <div class="tab-content-wrapper__list-item-head">
                <div class="tab-content-wrapper__list-item-name">Устройство 3</div>
                @include('edit-btn')
                @include('del-btn')
            </div>
            <div class="tab-content-wrapper__list-item-body">
                Развернутая информация об устройстве 3
            </div>
        </div>
        <div class="tab-content-wrapper__list-item">
            <div class="tab-content-wrapper__list-item-head">
                <div class="tab-content-wrapper__list-item-name">Устройство 4</div>
                @include('edit-btn')
                @include('del-btn')
            </div>
            <div class="tab-content-wrapper__list-item-body">
                Развернутая информация об устройстве 4
            </div>
        </div>
    </div>

    @include('add-btn')
</div>