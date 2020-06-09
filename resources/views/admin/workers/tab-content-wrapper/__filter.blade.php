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