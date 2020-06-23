@component('form-content')
    @slot('fields')
        <input type="hidden" name="id">

        <div class="form-content__field">
            <div class="form-content__title">Тип акта:</div>
            <select class="form-content__select" name="type">
                <option value="1">Акт выдачи</option>
                <option value="2">Акт сдачи</option>
            </select>
            <div class="form-content__error" field-name="type"></div>
        </div>
    @endslot
@endcomponent