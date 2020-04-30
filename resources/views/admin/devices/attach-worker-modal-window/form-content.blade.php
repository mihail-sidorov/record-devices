<form class="form-content">
    @csrf

    <input type="hidden" name="device_id" value="">

    <div class="form-content__field">
        <div class="form-content__title">Сотрудник:</div>
        <select class="form-content__select" name="worker_id" size="3">
            <option value="<%= worker.id %>" ng-repeat="worker in workers"><%= worker.name %></option>
        </select>
        <div class="form-content__error" field-name="worker_id"></div>
    </div>

    @include('action-btn')
</form>