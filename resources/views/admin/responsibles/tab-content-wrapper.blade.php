<div class="tab-content-wrapper">
    <div class="tab-content-wrapper__title">Фильтр:</div>    
    <div class="tab-content-wrapper__filter">
        <input class="tab-content-wrapper__filter-field" type="text" placeholder="ФИО">
        <input class="tab-content-wrapper__filter-field" type="text" placeholder="Должность">
        
        @include('action-btn')
    </div>

    <div class="tab-content-wrapper__title">Список:</div>
    <div class="tab-content-wrapper__list">
        <div class="tab-content-wrapper__list-item">
            <div class="tab-content-wrapper__list-item-head">
                <div class="tab-content-wrapper__list-item-name">Ответственный 1</div>
                @include('edit-btn')
                @include('del-btn')
            </div>
            <div class="tab-content-wrapper__list-item-body">
                Развернутая информация об ответственном 1
            </div>
        </div>
        <div class="tab-content-wrapper__list-item">
            <div class="tab-content-wrapper__list-item-head">
                <div class="tab-content-wrapper__list-item-name">Ответственный 2</div>
                @include('edit-btn')
                @include('del-btn')
            </div>
            <div class="tab-content-wrapper__list-item-body">
                Развернутая информация об ответственном 2
            </div>
        </div>
        <div class="tab-content-wrapper__list-item">
            <div class="tab-content-wrapper__list-item-head">
                <div class="tab-content-wrapper__list-item-name">Ответственный 3</div>
                @include('edit-btn')
                @include('del-btn')
            </div>
            <div class="tab-content-wrapper__list-item-body">
                Развернутая информация об ответственном 3
            </div>
        </div>
        <div class="tab-content-wrapper__list-item">
            <div class="tab-content-wrapper__list-item-head">
                <div class="tab-content-wrapper__list-item-name">Ответственный 4</div>
                @include('edit-btn')
                @include('del-btn')
            </div>
            <div class="tab-content-wrapper__list-item-body">
                Развернутая информация об ответственном 4
            </div>
        </div>
    </div>

    @include('add-btn')
</div>