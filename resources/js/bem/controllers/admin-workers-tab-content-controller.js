// admin-workers-tab-content-controller

$(document).ready(() => {
    // Открываем модальное окно для добавления сотрудника и обнуляем в нем сообщения об ошибках валидации
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
    $('.admin-workers-tab-content-controller .edit-work-place-modal-window .form-content__text, .admin-workers-tab-content-controller .add-worker-modal-window .form-content__text, .admin-workers-tab-content-controller .edit-worker-modal-window .form-content__text, .admin-workers-tab-content-controller .edit-device-modal-window .form-content__text, .admin-workers-tab-content-controller .edit-component_part-modal-window .form-content__text').on('input', (e) => {
        var $formContentField = $(e.currentTarget).closest('.form-content__field');
        $formContentField.removeClass('form-content__field_error');
        $formContentField.find('.form-content__error').text('');
    });

    // Обнуляем сообщения об ошибках валидации у выпадающих списков и дат
    $('.admin-workers-tab-content-controller .edit-work-place-modal-window .form-content__select, .admin-workers-tab-content-controller .add-worker-modal-window .form-content__select, .admin-workers-tab-content-controller .edit-worker-modal-window .form-content__select, .admin-workers-tab-content-controller .edit-device-modal-window .form-content__select, .admin-workers-tab-content-controller .edit-device-modal-window .form-content__date, .admin-workers-tab-content-controller .edit-component_part-modal-window .form-content__select, .admin-workers-tab-content-controller .edit-component_part-modal-window .form-content__date').on('change', (e) => {
        var $formContentField = $(e.currentTarget).closest('.form-content__field');
        $formContentField.removeClass('form-content__field_error');
        $formContentField.find('.form-content__error').text('');
    });

    // Показываем поле для введения инвентарного номера при выборе рабочего места
    $('.admin-workers-tab-content-controller .edit-device-modal-window select[name="type_device_id"]').on('change', (e) => {
        var $inventarNumber = $(e.currentTarget).closest('.form-content').find('[name="inventar_number"]'), $formContentField = $inventarNumber.closest('.form-content__field');
        $formContentField.removeClass('form-content__field_error');
        $formContentField.find('.form-content__error').text('');

        if ($(e.currentTarget).val() === '2') {
            $formContentField.show();
            $inventarNumber.focus();
        }
        else {
            $formContentField.hide();
        }
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

    // Открепление сотрудника от устройства
    $('.admin-workers-tab-content-controller .tab-content-wrapper__unattach-worker-from-device-btn .unattach-worker-btn').click((e) => {
        var deviceId, workerId, token;

        if (confirm('Вы действительно хотите открепить сотрудника от устройства?')) {
            deviceId = $(e.currentTarget).closest('.tab-content-wrapper__list-item').attr('id');
            workerId = $(e.currentTarget).closest('.tab-content-wrapper__list-item').attr('worker-id');
            token = $('meta[name="csrf-token"]').attr('content');
            
            $.ajax({
                type: 'POST',
                url: '/admin/unattach-worker-from-device',
                data: {
                    _token: token,
                    device_id: deviceId,
                    worker_id: workerId,
                },
                success: (response) => {
                    if (response) {
                        window.location.href = '/admin/tab/workers';
                    }
                },
            });
        }
    });

    // Открываем блок модального окна управления устройствами
    $('.admin-workers-tab-content-controller .attach-devices-btn').click((e) => {
        var $window = $(e.currentTarget).closest('.admin-workers-tab-content-controller').find('.attach-devices-modal-window');

        $window.attr('worker-id', $(e.currentTarget).closest('.tab-content-wrapper__list-item').attr('id'));
        $window.attr('loading', 'yes');
    });

    // Открываем модальное окно для редактирования комплектующего, обнуляем в нем сообщения об ошибках валидации и заполняем его данными
    $('.admin-workers-tab-content-controller .tab-content-wrapper__edit-component-part-btn .edit-btn').click((e) => {
        var componentPartId = $(e.currentTarget).closest('.tab-content-wrapper__list-item').attr('id'), token = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            type: 'POST',
            url: '/admin/write-edit-component-part-form',
            data: {
                _token: token,
                id: componentPartId,
            },
            dataType: 'json',
            success: (response) => {
                if (response) {
                    $('.admin-workers-tab-content-controller .edit-component_part-modal-window .form-content__field').each((index, element) => {
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
                    });

                    $('.admin-workers-tab-content-controller .edit-component_part-modal-window .form-content input[name="id"]').val(componentPartId);
                    $('.admin-workers-tab-content-controller .edit-component_part-modal-window .form-content__field').removeClass('form-content__field_error');
                    $('.admin-workers-tab-content-controller .edit-component_part-modal-window .form-content__error').text('');

                    $(e.currentTarget).closest('.admin-workers-tab-content-controller').find('.edit-component_part-modal-window').addClass('modal-window_show');
                }
            },
        });
    });

    // Валидация и редактирование комплектующего
    $('.admin-workers-tab-content-controller .edit-component_part-modal-window .form-content').on('submit', (e) => {
        var fields = $(e.currentTarget).serialize(), $formContentField;

        $(e.currentTarget).find('.form-content__field').removeClass('form-content__field_error');
        $(e.currentTarget).find('.form-content__error').text('');

        $.ajax({
            type: 'POST',
            url: '/admin/edit-component-part',
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

    // Открываем блок модального окна управления комплектующими
    $('.admin-workers-tab-content-controller .attach-component-parts-btn').click((e) => {
        var $window = $(e.currentTarget).closest('.admin-workers-tab-content-controller').find('.attach-component-parts-modal-window');

        $window.attr('work-place-id', $(e.currentTarget).closest('.tab-content-wrapper__list-item').attr('id'));
        $window.attr('url-tab', 'workers');
        $window.attr('loading', 'yes');
    });

    // Открепление сотрудника от рабочего места
    $('.admin-workers-tab-content-controller .tab-content-wrapper__unattach-worker-from-work-place-btn .unattach-worker-btn').click((e) => {
        var workPlaceId, workerId, token;

        if (confirm('Вы действительно хотите открепить сотрудника от рабочего места?')) {
            workPlaceId = $(e.currentTarget).closest('.tab-content-wrapper__list-item').attr('id');
            workerId = $(e.currentTarget).closest('.tab-content-wrapper__list-item').attr('worker_id');
            token = $('meta[name="csrf-token"]').attr('content');
            
            $.ajax({
                type: 'POST',
                url: '/admin/unattach-worker-from-work-place',
                data: {
                    _token: token,
                    work_place_id: workPlaceId,
                    worker_id: workerId,
                },
                success: (response) => {
                    if (response) {
                        window.location.href = '/admin/tab/workers';
                    }
                },
            });
        }
    });

    // Открываем модальное окно для редактирования рабочего места, обнуляем в нем сообщения об ошибках валидации и заполняем его данными
    $('.admin-workers-tab-content-controller .tab-content-wrapper__edit-work-place-btn .edit-btn').click((e) => {
        var workPlaceId = $(e.currentTarget).closest('.tab-content-wrapper__list-item').attr('id'), token = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            type: 'POST',
            url: '/admin/write-edit-work-place-form',
            data: {
                _token: token,
                id: workPlaceId,
            },
            dataType: 'json',
            success: (response) => {
                if (response) {
                    $('.admin-workers-tab-content-controller .edit-work-place-modal-window .form-content__field').each((index, element) => {
                        var $fieldNameElement = $(element).find('[name]'), fieldName = $fieldNameElement.attr('name'), date, year, month, day;

                        $fieldNameElement.val(response[fieldName]);
                    });

                    $('.admin-workers-tab-content-controller .edit-work-place-modal-window .form-content input[name="id"]').val(workPlaceId);
                    $('.admin-workers-tab-content-controller .edit-work-place-modal-window .form-content__field').removeClass('form-content__field_error');
                    $('.admin-workers-tab-content-controller .edit-work-place-modal-window .form-content__error').text('');

                    $(e.currentTarget).closest('.admin-workers-tab-content-controller').find('.edit-work-place-modal-window').addClass('modal-window_show');
                }
            },
        });
    });

    // Валидация и редактирование рабочего места
    $('.admin-workers-tab-content-controller .edit-work-place-modal-window .form-content').on('submit', (e) => {
        var fields = $(e.currentTarget).serialize(), $formContentField;

        $(e.currentTarget).find('.form-content__field').removeClass('form-content__field_error');
        $(e.currentTarget).find('.form-content__error').text('');

        $.ajax({
            type: 'POST',
            url: '/admin/edit-work-place',
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
});