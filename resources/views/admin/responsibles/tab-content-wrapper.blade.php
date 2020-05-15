<div class="tab-content-wrapper">
    <div class="tab-content-wrapper__title">Фильтр:</div>    
    <div class="tab-content-wrapper__filter">
        <input class="tab-content-wrapper__filter-field" type="text" placeholder="ФИО">
        <input class="tab-content-wrapper__filter-field" type="text" placeholder="Должность">
        <select class="tab-content-wrapper__filter-field">
            <option value="">Все отделы</option>
            @foreach ($departments as $department)
                <option value="{{ $department->id }}">{{ $department->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="tab-content-wrapper__title">Список:</div>
    <div class="tab-content-wrapper__list">
        @foreach ($responsibles as $responsible)
            <div class="tab-content-wrapper__list-item" id="{{ $responsible->id }}">
                <input type="hidden" class="tab-content-wrapper__list-item-filter-field" value="{{ $responsible->name }}">
                <input type="hidden" class="tab-content-wrapper__list-item-filter-field" value="{{ $responsible->post }}">
                <input type="hidden" class="tab-content-wrapper__list-item-filter-field" value="{{ $responsible->department_id }}">

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
                            <td>
                                @if ($responsible->department)
                                    {{ $responsible->department->name }}
                                @endif
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        @endforeach
    </div>

    @include('add-btn')
</div>