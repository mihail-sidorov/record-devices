<div class="tab-content-wrapper">
    <div class="tab-content-wrapper__title">Фильтр:</div>    
    <div class="tab-content-wrapper__filter">
        <input class="tab-content-wrapper__filter-field" type="text" placeholder="ФИО">
        
        @include('action-btn')
    </div>

    <div class="tab-content-wrapper__title">Список:</div>
    <div class="tab-content-wrapper__list">
        <div class="tab-content-wrapper__list-item">
            <div class="tab-content-wrapper__list-item-head">
                <div class="tab-content-wrapper__list-item-name">Поставщик 1</div>
                @include('edit-btn')
                @include('del-btn')
            </div>
            <div class="tab-content-wrapper__list-item-body">
                Развернутая информация о поставщике 1
            </div>
        </div>
        <div class="tab-content-wrapper__list-item">
            <div class="tab-content-wrapper__list-item-head">
                <div class="tab-content-wrapper__list-item-name">Поставщик 2</div>
                @include('edit-btn')
                @include('del-btn')
            </div>
            <div class="tab-content-wrapper__list-item-body">
                Развернутая информация о поставщике 2
            </div>
        </div>
        <div class="tab-content-wrapper__list-item">
            <div class="tab-content-wrapper__list-item-head">
                <div class="tab-content-wrapper__list-item-name">Поставщик 3</div>
                @include('edit-btn')
                @include('del-btn')
            </div>
            <div class="tab-content-wrapper__list-item-body">
                Развернутая информация о поставщике 3
            </div>
        </div>
        <div class="tab-content-wrapper__list-item">
            <div class="tab-content-wrapper__list-item-head">
                <div class="tab-content-wrapper__list-item-name">Поставщик 4</div>
                @include('edit-btn')
                @include('del-btn')
            </div>
            <div class="tab-content-wrapper__list-item-body">
                Развернутая информация о поставщике 4
            </div>
        </div>
    </div>

    @include('add-btn')
</div>