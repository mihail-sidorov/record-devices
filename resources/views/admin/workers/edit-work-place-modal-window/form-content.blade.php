<form class="form-content">
    @csrf

    <input type="hidden" name="id">

    <div class="form-content__field">
        <div class="form-content__title">Наименование:</div>
        <input class="form-content__text" type="text" name="name">
        <div class="form-content__error" field-name="name"></div>
    </div>

    <div class="form-content__field">
        <div class="form-content__title">Инвентарный номер:</div>
        <input class="form-content__text" type="text" name="inventar_number">
        <div class="form-content__error" field-name="inventar_number"></div>
    </div>

    <div class="form-content__field">
        <div class="form-content__title">Ответственный на складе:</div>
        <select class="form-content__select" name="responsible_id">
            <option value=""></option>
            @foreach ($responsibles as $responsible)
                <option value="{{ $responsible->id }}">{{ $responsible->name }}</option>
            @endforeach
        </select>
        <div class="form-content__error" field-name="responsible_id"></div>
    </div>

    @include('action-btn')
</form>