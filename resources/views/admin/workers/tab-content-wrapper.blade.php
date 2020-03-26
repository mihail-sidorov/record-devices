<div class="tab-content-wrapper">
    <div class="tab-content-wrapper__title">Фильтр:</div>    
    <div class="tab-content-wrapper__filter">
        <input class="tab-content-wrapper__filter-field" type="text" placeholder="ФИО">
        <input class="tab-content-wrapper__filter-field" type="text" placeholder="Должность">
        <select class="tab-content-wrapper__filter-field">
            <option value="">Отдел 1</option>
            <option value="">Отдел 2</option>
            <option value="">Отдел 3</option>
            <option value="">Отдел 4</option>
        </select>
        
        @include('action-btn')
    </div>

    <div class="tab-content-wrapper__title">Список:</div>
    <div class="tab-content-wrapper__list">
        <div class="tab-content-wrapper__list-item">
            <div class="tab-content-wrapper__list-item-head">
                <div class="tab-content-wrapper__list-item-name">Сотрудник 1</div>
                @include('edit-btn')
                @include('del-btn')
            </div>
            <div class="tab-content-wrapper__list-item-body">
                Развернутая информация о сотруднике 1
            </div>
        </div>
        <div class="tab-content-wrapper__list-item">
            <div class="tab-content-wrapper__list-item-head">
                <div class="tab-content-wrapper__list-item-name">Сотрудник 2</div>
                @include('edit-btn')
                @include('del-btn')
            </div>
            <div class="tab-content-wrapper__list-item-body">
                Развернутая информация о сотруднике 2
            </div>
        </div>
        <div class="tab-content-wrapper__list-item">
            <div class="tab-content-wrapper__list-item-head">
                <div class="tab-content-wrapper__list-item-name">Сотрудник 3</div>
                @include('edit-btn')
                @include('del-btn')
            </div>
            <div class="tab-content-wrapper__list-item-body">
                Развернутая информация о сотруднике 3
            </div>
        </div>
        <div class="tab-content-wrapper__list-item">
            <div class="tab-content-wrapper__list-item-head">
                <div class="tab-content-wrapper__list-item-name">Сотрудник 4</div>
                @include('edit-btn')
                @include('del-btn')
            </div>
            <div class="tab-content-wrapper__list-item-body">
                Развернутая информация о сотруднике 4
            </div>
        </div>
    </div>

    @include('add-btn')
</div>