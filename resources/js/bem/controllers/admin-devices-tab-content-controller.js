// admin-devices-tab-content-controller

$(document).ready(() => {
    // Открываем модальное окно для добавления устройства и обнуляем в нем сообщения об ошибках валидации
    $('.admin-devices-tab-content-controller .add-btn').click((e) => {
        $('.admin-devices-tab-content-controller .add-device-modal-window .form-content__field').removeClass('form-content__field_error');
        $('.admin-devices-tab-content-controller .add-device-modal-window .form-content__error').text('');

        $(e.currentTarget).closest('.admin-devices-tab-content-controller').find('.add-device-modal-window').addClass('modal-window_show');
    });

    // Открываем модальное окно для прикрепления к рабочему месту сотрудника и обнуляем в нем сообщения об ошибках валидации
    $('.admin-devices-tab-content-controller .attach-worker-btn').click((e) => {
        var deviceId = $(e.currentTarget).closest('.tab-content-wrapper__list-item').attr('id'), token = $('meta[name="csrf-token"]').attr('content');

        $('.admin-devices-tab-content-controller .attach-worker-modal-window .form-content input[name="device_id"]').val(deviceId);
        $('.admin-devices-tab-content-controller .attach-worker-modal-window .form-content__field').removeClass('form-content__field_error');
        $('.admin-devices-tab-content-controller .attach-worker-modal-window .form-content__error').text('');

        $.ajax({
            type: 'POST',
            url: '/admin/get-free-workers-to-device',
            data: {
                _token: token,
            },
            dataType: 'json',
            success: (response) => {
                if (response) {
                    window.attachWorkerToDeviceAngularController.workers = response;
                    window.attachWorkerToDeviceAngularController.$apply();

                    $('.admin-devices-tab-content-controller .attach-worker-modal-window__search-input').off('input');
                    $('.admin-devices-tab-content-controller .attach-worker-modal-window__search-input').on('input', (e) => {
                        var inputText = $(e.currentTarget).val().toLowerCase().replace('ё', 'е');
                        
                        if (inputText !== '') {
                            window.attachWorkerToDeviceAngularController.workers = [];
                            response.forEach(function(worker){
                                var name = worker.name.toLowerCase().replace('ё', 'е');
                
                                if (name.match(inputText)) {
                                    window.attachWorkerToDeviceAngularController.workers.push(worker);
                                }
                            });
                        }
                        else {
                            window.attachWorkerToDeviceAngularController.workers = response;
                        }
                
                        window.attachWorkerToDeviceAngularController.$apply();
                    });
                    
                    $(e.currentTarget).closest('.admin-devices-tab-content-controller').find('.attach-worker-modal-window').addClass('modal-window_show');
                    
                    setTimeout(() => {
                        $('.admin-devices-tab-content-controller .attach-worker-modal-window__search-input').focus().val('');
                        $('.admin-devices-tab-content-controller .attach-worker-modal-window .form-content__select').val('');
                    }, 0);
                }
            },
        });
    });

    // Открываем блок модального окна управления комплектующими
    $('.admin-devices-tab-content-controller .attach-component-parts-btn').click((e) => {
        var $window = $(e.currentTarget).closest('.admin-devices-tab-content-controller').find('.attach-component-parts-modal-window');

        $window.attr('device-id', $(e.currentTarget).closest('.tab-content-wrapper__list-item').attr('id'));
        $window.attr('url-tab', 'devices');
        $window.attr('loading', 'yes');
    });

    // Открываем модальное окно для редактирования устройства, обнуляем в нем сообщения об ошибках валидации и заполняем его данными
    $('.admin-devices-tab-content-controller .tab-content-wrapper__edit-device-btn').click((e) => {
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
                    $('.admin-devices-tab-content-controller .edit-device-modal-window .form-content__field').each((index, element) => {
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

                    $('.admin-devices-tab-content-controller .edit-device-modal-window .form-content input[name="id"]').val(deviceId);
                    $('.admin-devices-tab-content-controller .edit-device-modal-window .form-content__field').removeClass('form-content__field_error');
                    $('.admin-devices-tab-content-controller .edit-device-modal-window .form-content__error').text('');

                    $(e.currentTarget).closest('.admin-devices-tab-content-controller').find('.edit-device-modal-window').addClass('modal-window_show');
                }
            },
        });
    });

    // Обнуляем сообщения об ошибках валидации у текстовых полей
    $('.admin-devices-tab-content-controller .add-device-modal-window .form-content__text, .admin-devices-tab-content-controller .edit-device-modal-window .form-content__text, .admin-devices-tab-content-controller .edit-component_part-modal-window .form-content__text').on('input', (e) => {
        var $formContentField = $(e.currentTarget).closest('.form-content__field');
        $formContentField.removeClass('form-content__field_error');
        $formContentField.find('.form-content__error').text('');
    });

    // Обнуляем сообщения об ошибках валидации у дат и выпадающих списков
    $('.admin-devices-tab-content-controller .add-device-modal-window .form-content__select, .admin-devices-tab-content-controller .add-device-modal-window .form-content__date, .admin-devices-tab-content-controller .edit-device-modal-window .form-content__select, .admin-devices-tab-content-controller .edit-device-modal-window .form-content__date, .admin-devices-tab-content-controller .attach-worker-modal-window .form-content__select, .admin-devices-tab-content-controller .edit-component_part-modal-window .form-content__select, .admin-devices-tab-content-controller .edit-component_part-modal-window .form-content__date').on('change', (e) => {
        var $formContentField = $(e.currentTarget).closest('.form-content__field');
        $formContentField.removeClass('form-content__field_error');
        $formContentField.find('.form-content__error').text('');
    });

    // Валидация и добавление устройства
    $('.admin-devices-tab-content-controller .add-device-modal-window .form-content').on('submit', (e) => {
        var fields = $(e.currentTarget).serialize(), $formContentField;

        $(e.currentTarget).find('.form-content__field').removeClass('form-content__field_error');
        $(e.currentTarget).find('.form-content__error').text('');

        $.ajax({
            type: 'POST',
            url: '/admin/add-device',
            data: fields,
            success: (response) => {
                if (response) {
                    window.location.href = '/admin/tab/devices';
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

    // Валидация и прикрепление сотрудника к устройству
    $('.admin-devices-tab-content-controller .attach-worker-modal-window .form-content').on('submit', (e) => {
        var fields = $(e.currentTarget).serialize(), $formContentField;

        $(e.currentTarget).find('.form-content__field').removeClass('form-content__field_error');
        $(e.currentTarget).find('.form-content__error').text('');

        $.ajax({
            type: 'POST',
            url: '/admin/attach-worker',
            data: fields,
            success: (response) => {
                if (response) {
                    window.location.href = '/admin/tab/devices';
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

    // Валидация и редактирование устройства
    $('.admin-devices-tab-content-controller .edit-device-modal-window .form-content').on('submit', (e) => {
        var fields = $(e.currentTarget).serialize(), $formContentField;

        $(e.currentTarget).find('.form-content__field').removeClass('form-content__field_error');
        $(e.currentTarget).find('.form-content__error').text('');

        $.ajax({
            type: 'POST',
            url: '/admin/edit-device',
            data: fields,
            success: (response) => {
                if (response) {
                    window.location.href = '/admin/tab/devices';
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

    // Удаление устройства
    $('.admin-devices-tab-content-controller .tab-content-wrapper__list').on('click', '.del-btn', (e) => {
        var deviceId, token, deviceName = $(e.currentTarget).closest('.tab-content-wrapper__list-item-head').find('.tab-content-wrapper__list-item-name').text();

        if (confirm(`Вы действительно хотите удалить устройство "${deviceName}"?`)) {
            deviceId = $(e.currentTarget).closest('.tab-content-wrapper__list-item').attr('id');
            token = $('meta[name="csrf-token"]').attr('content');
            
            $.ajax({
                type: 'POST',
                url: '/admin/del-device',
                data: {
                    _token: token,
                    id: deviceId,
                },
                success: (response) => {
                    if (response) {
                        window.location.href = '/admin/tab/devices';
                    }
                },
            });
        }
    });

    // Открепление сотрудника от устройства
    $('.admin-devices-tab-content-controller .unattach-worker-btn').click((e) => {
        var deviceId, workerId, token;

        if (confirm('Вы действительно хотите открепить сотрудника от устройства?')) {
            deviceId = $(e.currentTarget).closest('.tab-content-wrapper__list-item').attr('id');
            workerId = $(e.currentTarget).closest('.tab-content-wrapper__list-item').attr('worker_id');
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
                        window.location.href = '/admin/tab/devices';
                    }
                },
            });
        }
    });

    // Открываем модальное окно для редактирования комплектующего, обнуляем в нем сообщения об ошибках валидации и заполняем его данными
    $('.admin-devices-tab-content-controller .tab-content-wrapper__edit-component-part-btn').click((e) => {
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
                    $('.admin-devices-tab-content-controller .edit-component_part-modal-window .form-content__field').each((index, element) => {
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

                    $('.admin-devices-tab-content-controller .edit-component_part-modal-window .form-content input[name="id"]').val(componentPartId);
                    $('.admin-devices-tab-content-controller .edit-component_part-modal-window .form-content__field').removeClass('form-content__field_error');
                    $('.admin-devices-tab-content-controller .edit-component_part-modal-window .form-content__error').text('');

                    $(e.currentTarget).closest('.admin-devices-tab-content-controller').find('.edit-component_part-modal-window').addClass('modal-window_show');
                }
            },
        });
    });

    // Валидация и редактирование комплектующего
    $('.admin-devices-tab-content-controller .edit-component_part-modal-window .form-content').on('submit', (e) => {
        var fields = $(e.currentTarget).serialize(), $formContentField;

        $(e.currentTarget).find('.form-content__field').removeClass('form-content__field_error');
        $(e.currentTarget).find('.form-content__error').text('');

        $.ajax({
            type: 'POST',
            url: '/admin/edit-component-part',
            data: fields,
            success: (response) => {
                if (response) {
                    window.location.href = '/admin/tab/devices';
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