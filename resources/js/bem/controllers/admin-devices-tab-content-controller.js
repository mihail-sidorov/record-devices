// admin-devices-tab-content-controller

$(document).ready(() => {
    // Открываем модальное окно для добавления устройства и обнуляем в нем сообщения об ошибках валидации
    $('.admin-devices-tab-content-controller .add-btn').click((e) => {
        $('.admin-devices-tab-content-controller .add-device-modal-window .form-content__field').removeClass('form-content__field_error');
        $('.admin-devices-tab-content-controller .add-device-modal-window .form-content__error').text('');

        $(e.currentTarget).closest('.admin-devices-tab-content-controller').find('.add-device-modal-window').addClass('modal-window_show');
    });

    // Открываем модальное окно для прикрепления к устройству сотрудника и обнуляем в нем сообщения об ошибках валидации
    $('.admin-devices-tab-content-controller .attach-worker-btn').click((e) => {
        var deviceId = $(e.currentTarget).closest('.tab-content-wrapper__list-item').attr('id');

        $('.admin-devices-tab-content-controller .attach-worker-modal-window .form-content input[name="device_id"]').val(deviceId);
        $('.admin-devices-tab-content-controller .attach-worker-modal-window .form-content__field').removeClass('form-content__field_error');
        $('.admin-devices-tab-content-controller .attach-worker-modal-window .form-content__error').text('');

        $(e.currentTarget).closest('.admin-devices-tab-content-controller').find('.attach-worker-modal-window').addClass('modal-window_show');
    });

    // Открываем модальное окно для прикрепления к устройству комплектующих и выводим список всех категорий, которые относятся только к комплектующим
    $('.admin-devices-tab-content-controller .attach-component-parts-btn').click((e) => {
        var $attachComponentPartsBtn = $(e.currentTarget), deviceId = $(e.currentTarget).closest('.tab-content-wrapper__list-item').attr('id'), token = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            type: 'POST',
            url: '/admin/write-attach-component-parts-modal-window',
            data: {
                _token: token,
            },
            dataType: 'json',
            success: (response) => {
                var $categories;

                if (response) {
                    $categories = $('.admin-devices-tab-content-controller .attach-component-parts-modal-window__categories');
                    
                    $categories.html('');
                    response.forEach((categoryObj) => {
                        var category = `
                            <div class="attach-component-parts-modal-window__category" id="${categoryObj.id}">
                                <div class="attach-component-parts-modal-window__category-head">${categoryObj.name}</div>
                                <div class="attach-component-parts-modal-window__category-body"></div>
                            </div>
                        `;
                        $categories.append(category);
                    });

                    // Подгружаем список всех комплектующих, которые относятся к категории
                    $('.admin-devices-tab-content-controller .attach-component-parts-modal-window__category-head').click((e) => {
                        var $category = $(e.currentTarget).closest('.attach-component-parts-modal-window__category'), categoryId = $(e.currentTarget).closest('.attach-component-parts-modal-window__category').attr('id'), $categoryBody = $(e.currentTarget).closest('.attach-component-parts-modal-window__category').find('.attach-component-parts-modal-window__category-body');

                        if (!$categoryBody.html()) {
                            $.ajax({
                                type: 'POST',
                                url: '/admin/load-component-parts-by-category',
                                data: {
                                    _token: token,
                                    category_id: categoryId,
                                    device_id: deviceId,
                                },
                                dataType: 'json',
                                success: (response) => {
                                    if (response) {
                                        var $componentParts = $categoryBody.append('<div class="attach-component-parts-modal-window__component-parts"></div>').find('.attach-component-parts-modal-window__component-parts');

                                        response[0].forEach((componentPartObj, index) => {
                                            if (response[1][index]) {
                                                var attach = ' attach-component-parts-modal-window__component-part_attach';
                                            }
                                            else {
                                                attach = '';
                                            }

                                            var componentPart = `
                                                <div id="${componentPartObj.id}" class="attach-component-parts-modal-window__component-part${attach}">${componentPartObj.name}</div>
                                            `;
                                            $componentParts.append(componentPart);
                                        });

                                        // Производим прикрепление\откреплении комплектующего
                                        $category.find('.attach-component-parts-modal-window__component-part').click((e) => {
                                            var $componentPart = $(e.currentTarget), componentPartId = $componentPart.attr('id');

                                            $.ajax({
                                                type: 'POST',
                                                url: '/admin/attach-component-part-to-device',
                                                data: {
                                                    _token: token,
                                                    device_id: deviceId,
                                                    component_part_id: componentPartId,
                                                },
                                                dataType: 'json',
                                                success: (response) => {
                                                    if (response) {
                                                        if (response.attach) {
                                                            $componentPart.addClass('attach-component-parts-modal-window__component-part_attach');
                                                        }
                                                        else {
                                                            $componentPart.removeClass('attach-component-parts-modal-window__component-part_attach');
                                                        }

                                                        // Подгружаем список комплектующих в интерфейс устройства
                                                        $.ajax({
                                                            type: 'POST',
                                                            url: '/admin/show-component-parts-in-device',
                                                            data: {
                                                                _token: token,
                                                                device_id: deviceId,
                                                            },
                                                            success: (response) => {
                                                                $attachComponentPartsBtn.closest('.tab-content-wrapper__list-item').find('.tab-content-wrapper__component-parts').html(response);
                                                            },
                                                        });
                                                    }
                                                },
                                            });
                                        });
    
                                        $(e.currentTarget).toggleClass('attach-component-parts-modal-window__category-head_show');
                                        $categoryBody.slideToggle();
                                    }
                                },
                                error: (error) => {
                                    console.log(error);
                                },
                            });
                        }
                        else {
                            $(e.currentTarget).toggleClass('attach-component-parts-modal-window__category-head_show');
                            $categoryBody.slideToggle();
                        }
                    });

                    $(e.currentTarget).closest('.admin-devices-tab-content-controller').find('.attach-component-parts-modal-window').addClass('modal-window_show');
                }
            },
        });
    });

    // Открываем модальное окно для редактирования устройства, обнуляем в нем сообщения об ошибках валидации и заполняем его данными
    $('.admin-devices-tab-content-controller .edit-btn').click((e) => {
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
    $('.admin-devices-tab-content-controller .add-device-modal-window .form-content__text, .admin-devices-tab-content-controller .edit-device-modal-window .form-content__text').on('input', (e) => {
        var $formContentField = $(e.currentTarget).closest('.form-content__field');
        $formContentField.removeClass('form-content__field_error');
        $formContentField.find('.form-content__error').text('');
    });

    // Обнуляем сообщения об ошибках валидации у дат и выпадающих списков
    $('.admin-devices-tab-content-controller .add-device-modal-window .form-content__select, .admin-devices-tab-content-controller .add-device-modal-window .form-content__date, .admin-devices-tab-content-controller .edit-device-modal-window .form-content__select, .admin-devices-tab-content-controller .edit-device-modal-window .form-content__date').on('change', (e) => {
        var $formContentField = $(e.currentTarget).closest('.form-content__field');
        $formContentField.removeClass('form-content__field_error');
        $formContentField.find('.form-content__error').text('');
    });

    // Показываем поле для введения инвентарного номера при выборе рабочего места
    $('.admin-devices-tab-content-controller .add-device-modal-window input[name="inventar_number"]').closest('.form-content__field').hide();
    $('.admin-devices-tab-content-controller .add-device-modal-window select[name="type_device_id"], .admin-devices-tab-content-controller .edit-device-modal-window select[name="type_device_id"]').on('change', (e) => {
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

    // Открепление сотрудника
    $('.admin-devices-tab-content-controller .tab-content-wrapper__list').on('click', '.unattach-worker-btn', (e) => {
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
                        window.location.href = '/admin/tab/devices';
                    }
                },
            });
        }
    });
});