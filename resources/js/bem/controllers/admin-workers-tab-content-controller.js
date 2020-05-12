// admin-workers-tab-content-controller

$(document).ready(() => {
    // Открываем модальное окно для добавления устройства и обнуляем в нем сообщения об ошибках валидации
    $('.admin-workers-tab-content-controller').find('.add-btn').click((e) => {
        $('.admin-workers-tab-content-controller .add-worker-modal-window .form-content__field').removeClass('form-content__field_error');
        $('.admin-workers-tab-content-controller .add-worker-modal-window .form-content__error').text('');

        $(e.currentTarget).closest('.admin-workers-tab-content-controller').find('.add-worker-modal-window').addClass('modal-window_show');
    });

    // Открываем модальное окно для редактирования сотрудника, обнуляем в нем сообщения об ошибках валидации и заполняем его данными
    $('.admin-workers-tab-content-controller .tab-content-wrapper__edit-worker-btn').click((e) => {
        var workerId = $(e.currentTarget).closest('.tab-content-wrapper__list-item').attr('id'), token = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            type: 'POST',
            url: '/admin/write-edit-worker-form',
            data: {
                _token: token,
                id: workerId,
            },
            dataType: 'json',
            success: (response) => {
                if (response) {
                    $('.admin-workers-tab-content-controller .edit-worker-modal-window .form-content__field').each((index, element) => {
                        var $fieldNameElement = $(element).find('[name]'), fieldName = $fieldNameElement.attr('name');

                        $fieldNameElement.val(response[fieldName]);
                    });

                    $('.admin-workers-tab-content-controller .edit-worker-modal-window .form-content input[name="id"]').val(workerId);
                    $('.admin-workers-tab-content-controller .edit-worker-modal-window .form-content__field').removeClass('form-content__field_error');
                    $('.admin-workers-tab-content-controller .edit-worker-modal-window .form-content__error').text('');

                    $(e.currentTarget).closest('.admin-workers-tab-content-controller').find('.edit-worker-modal-window').addClass('modal-window_show');
                }
            },
        });
    });

    // Обнуляем сообщения об ошибках валидации у текстовых полей
    $('.admin-workers-tab-content-controller .add-worker-modal-window .form-content__text, .admin-workers-tab-content-controller .edit-worker-modal-window .form-content__text, .admin-workers-tab-content-controller .edit-device-modal-window .form-content__text').on('input', (e) => {
        var $formContentField = $(e.currentTarget).closest('.form-content__field');
        $formContentField.removeClass('form-content__field_error');
        $formContentField.find('.form-content__error').text('');
    });

    // Обнуляем сообщения об ошибках валидации у выпадающих списков и дат
    $('.admin-workers-tab-content-controller .add-worker-modal-window .form-content__select, .admin-workers-tab-content-controller .edit-worker-modal-window .form-content__select, .admin-workers-tab-content-controller .edit-device-modal-window .form-content__select, .admin-workers-tab-content-controller .edit-device-modal-window .form-content__date').on('change', (e) => {
        var $formContentField = $(e.currentTarget).closest('.form-content__field');
        $formContentField.removeClass('form-content__field_error');
        $formContentField.find('.form-content__error').text('');
    });

    // Валидация и добавление сотрудника
    $('.admin-workers-tab-content-controller .add-worker-modal-window .form-content').on('submit', (e) => {
        var fields = $(e.currentTarget).serialize(), $formContentField;

        $(e.currentTarget).find('.form-content__field').removeClass('form-content__field_error');
        $(e.currentTarget).find('.form-content__error').text('');

        $.ajax({
            type: 'POST',
            url: '/admin/add-worker',
            data: fields,
            success: (response) => {
                if (response) {
                    window.location.href = '/admin/tab/workers';
                }
            },
            error:  (error) => {
                var errors;

                if (error.status === 422) {
                    errors = error.responseJSON.errors;
                    if (errors !== undefined) {
                        for (var key in errors) {
                            if (errors[key][0]) {
                                $formContentField = $(e.currentTarget).find(`.form-content__error[field-name="${key}"]`).closest('.form-content__field');
                                $formContentField.addClass('form-content__field_error');
                                $formContentField.find('.form-content__error').text(errors[key][0]);
                            }
                        }
                    }
                }
            },
        });

        return false;
    });

    // Валидация и редактирование сотрудника
    $('.admin-workers-tab-content-controller .edit-worker-modal-window .form-content').on('submit', (e) => {
        var fields = $(e.currentTarget).serialize(), $formContentField;

        $(e.currentTarget).find('.form-content__field').removeClass('form-content__field_error');
        $(e.currentTarget).find('.form-content__error').text('');

        $.ajax({
            type: 'POST',
            url: '/admin/edit-worker',
            data: fields,
            success: (response) => {
                if (response) {
                    window.location.href = '/admin/tab/workers';
                }
            },
            error:  (error) => {
                var errors;

                if (error.status === 422) {
                    errors = error.responseJSON.errors;
                    if (errors !== undefined) {
                        for (var key in errors) {
                            if (errors[key][0]) {
                                $formContentField = $(e.currentTarget).find(`.form-content__error[field-name="${key}"]`).closest('.form-content__field');
                                $formContentField.addClass('form-content__field_error');
                                $formContentField.find('.form-content__error').text(errors[key][0]);
                            }
                        }
                    }
                }
            },
        });

        return false;
    });

    // Удаление сотрудника
    $('.admin-workers-tab-content-controller .tab-content-wrapper__del-worker-btn').click((e) => {
        var workerId, token, workerName = $(e.currentTarget).closest('.tab-content-wrapper__list-item-head').find('.tab-content-wrapper__list-item-name').text();

        if (confirm(`Вы действительно хотите удалить сотрудника "${workerName}"?`)) {
            workerId = $(e.currentTarget).closest('.tab-content-wrapper__list-item').attr('id');
            token = $('meta[name="csrf-token"]').attr('content');
            
            $.ajax({
                type: 'POST',
                url: '/admin/del-worker',
                data: {
                    _token: token,
                    id: workerId,
                },
                success: (response) => {
                    if (response) {
                        window.location.href = '/admin/tab/workers';
                    }
                },
            });
        }
    });

    // Открываем модальное окно для редактирования устройства, обнуляем в нем сообщения об ошибках валидации и заполняем его данными
    $('.admin-workers-tab-content-controller .tab-content-wrapper__edit-device-btn').click((e) => {
        var deviceId = $(e.currentTarget).closest('.tab-content-wrapper__list-item').attr('id'), token = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            type: 'POST',
            url: '/admin/write-edit-device-form',
            data: {
                _token: token,
                id: deviceId,
            },
            dataType: 'json',
            success: (response) => {
                if (response) {
                    $('.admin-workers-tab-content-controller .edit-device-modal-window .form-content__field').each((index, element) => {
                        var $fieldNameElement = $(element).find('[name]'), fieldName = $fieldNameElement.attr('name'), date, year, month, day;

                        if (fieldName === 'receipt_date' || fieldName === 'warranty') {
                            date = new Date(response[fieldName] * 1000);
                            year = date.getFullYear();
                            month = +date.getMonth() + 1;
                            day = +date.getDate();

                            if (month < 10) {
                                month = '0' + month;
                            }
                            if (day < 10) {
                                day = '0' + day;
                            }

                            $fieldNameElement.val(`${year}-${month}-${day}`);
                        }
                        else {
                            $fieldNameElement.val(response[fieldName]);
                        }

                        if (fieldName === 'inventar_number') {
                            if (!$fieldNameElement.val()) {
                                $(element).hide();
                            }
                            else {
                                $(element).show();
                            }
                        }
                    });

                    $('.admin-workers-tab-content-controller .edit-device-modal-window .form-content input[name="id"]').val(deviceId);
                    $('.admin-workers-tab-content-controller .edit-device-modal-window .form-content__field').removeClass('form-content__field_error');
                    $('.admin-workers-tab-content-controller .edit-device-modal-window .form-content__error').text('');

                    $(e.currentTarget).closest('.admin-workers-tab-content-controller').find('.edit-device-modal-window').addClass('modal-window_show');
                }
            },
        });
    });

    // Валидация и редактирование устройства
    $('.admin-workers-tab-content-controller .edit-device-modal-window .form-content').on('submit', (e) => {
        var fields = $(e.currentTarget).serialize(), $formContentField;

        $(e.currentTarget).find('.form-content__field').removeClass('form-content__field_error');
        $(e.currentTarget).find('.form-content__error').text('');

        $.ajax({
            type: 'POST',
            url: '/admin/edit-device',
            data: fields,
            success: (response) => {
                if (response) {
                    window.location.href = '/admin/tab/workers';
                }
            },
            error:  (error) => {
                var errors;

                if (error.status === 422) {
                    errors = error.responseJSON.errors;
                    if (errors !== undefined) {
                        for (var key in errors) {
                            if (errors[key][0]) {
                                $formContentField = $(e.currentTarget).find(`.form-content__error[field-name="${key}"]`).closest('.form-content__field');
                                $formContentField.addClass('form-content__field_error');
                                $formContentField.find('.form-content__error').text(errors[key][0]);
                            }
                        }
                    }
                }
            },
        });

        return false;
    });

    // Открепление сотрудника
    $('.admin-workers-tab-content-controller .unattach-worker-btn').click((e) => {
        var deviceId, token;

        if (confirm('Вы действительно хотите открепить сотрудника от устройства?')) {
            deviceId = $(e.currentTarget).closest('.tab-content-wrapper__list-item').attr('id');
            token = $('meta[name="csrf-token"]').attr('content');
            
            $.ajax({
                type: 'POST',
                url: '/admin/unattach-worker',
                data: {
                    _token: token,
                    device_id: deviceId,
                },
                success: (response) => {
                    if (response) {
                        window.location.href = '/admin/tab/workers';
                    }
                },
            });
        }
    });

    // Открываем блок модального окна управления комплектующими
    $('.admin-workers-tab-content-controller .attach-component-parts-btn').click((e) => {
        var $window = $(e.currentTarget).closest('.admin-workers-tab-content-controller').find('.attach-component-parts-modal-window');

        $window.attr('device-id', $(e.currentTarget).closest('.tab-content-wrapper__list-item').attr('id'));
        $window.attr('url-tab', 'workers');
        $window.attr('loading', 'yes');
    });

    // Открываем блок модального окна управления устройствами
    $('.admin-workers-tab-content-controller .attach-devices-btn').click((e) => {
        var $window = $(e.currentTarget).closest('.admin-workers-tab-content-controller').find('.attach-devices-modal-window');

        $window.attr('worker-id', $(e.currentTarget).closest('.tab-content-wrapper__list-item').attr('id'));
        $window.attr('loading', 'yes');
    });
});