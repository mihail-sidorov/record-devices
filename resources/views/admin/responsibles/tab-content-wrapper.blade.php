<div class="tab-content-wrapper">
    <div class="tab-content-wrapper__title">Фильтр:</div>    
    <div class="tab-content-wrapper__filter">
        <input class="tab-content-wrapper__filter-field" type="text" placeholder="ФИО">
        <input class="tab-content-wrapper__filter-field" type="text" placeholder="Должность">
        <select class="tab-content-wrapper__filter-field">
            @foreach ($departments as $department)
                <option value="{{ $department->id }}">{{ $department->name }}</option>
            @endforeach
        </select>
        
        @include('action-btn')
    </div>

    <div class="tab-content-wrapper__title">Список:</div>
    <div class="tab-content-wrapper__list">
        @foreach ($responsibles as $responsible)
            <div class="tab-content-wrapper__list-item" id="{{ $responsible->id }}">
                <div class="tab-content-wrapper__list-item-head">
                    <div class="tab-content-wrapper__list-item-name">{{ $responsible->name }}</div>
                    @include('edit-btn')
                    @include('del-btn')
                </div>
                <div class="tab-content-wrapper__list-item-body">
                    <table class="tab-content-wrapper__list-item-body-table">
                        <thead>
                            <tr>
                                <td>Должность</td>
                                <td>Отдел</td>
                            </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>{{ $responsible->post }}</td>
                            <td>{{ $responsible->department->name }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        @endforeach
    </div>

    @include('add-btn')
</div>