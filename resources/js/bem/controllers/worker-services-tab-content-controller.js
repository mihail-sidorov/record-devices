// worker-services-tab-content-controller

$(document).ready(() => {
    // Открываем модальное окно для добавления сервиса и обнуляем в нем сообщения об ошибках валидации
    $('.worker-services-tab-content-controller').find('.add-btn').click((e) => {
        $('.worker-services-tab-content-controller .add-service-modal-window .form-content__field').removeClass('form-content__field_error');
        $('.worker-services-tab-content-controller .add-service-modal-window .form-content__error').text('');

        $(e.currentTarget).closest('.worker-services-tab-content-controller').find('.add-service-modal-window').addClass('modal-window_show');
    });

    // Открываем модальное окно для редактирования сервиса, обнуляем в нем сообщения об ошибках валидации и заполняем его данными
    $('.worker-services-tab-content-controller .edit-btn').click((e) => {
        var serviceId = $(e.currentTarget).closest('.tab-content-wrapper__list-item').attr('id'), token = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            type: 'POST',
            url: '/worker/write-edit-service-form',
            data: {
                _token: token,
                id: serviceId,
            },
            dataType: 'json',
            success: (response) => {
                if (response) {
                    $('.worker-services-tab-content-controller .edit-service-modal-window .form-content__field').each((index, element) => {
                        var $fieldNameElement = $(element).find('[name]'), fieldName = $fieldNameElement.attr('name');

                        if (fieldName === 'description') {
                            description = response[fieldName];
                            description = description.replace(/\*\*\*/g, "\r\n");
                            description = description.replace(/\*\*/g, "\r");
                            description = description.replace(/\*/g, "\n");

                            $fieldNameElement.val(description);
                        }
                        else{
                            $fieldNameElement.val(response[fieldName]);
                        }
                    });

                    $('.worker-services-tab-content-controller .edit-service-modal-window .form-content input[name="id"]').val(serviceId);
                    $('.worker-services-tab-content-controller .edit-service-modal-window .form-content__field').removeClass('form-content__field_error');
                    $('.worker-services-tab-content-controller .edit-service-modal-window .form-content__error').text('');

                    $(e.currentTarget).closest('.worker-services-tab-content-controller').find('.edit-service-modal-window').addClass('modal-window_show');
                }
            },
        });
    });

    // Обнуляем сообщения об ошибках валидации у текстовых полей
    $('.worker-services-tab-content-controller .add-service-modal-window .form-content__text, .worker-services-tab-content-controller .edit-service-modal-window .form-content__text').on('input', (e) => {
        var $formContentField = $(e.currentTarget).closest('.form-content__field');
        $formContentField.removeClass('form-content__field_error');
        $formContentField.find('.form-content__error').text('');
    });

    // Валидация и добавление сервиса
    $('.worker-services-tab-content-controller .add-service-modal-window .form-content').on('submit', (e) => {
        var fields = $(e.currentTarget).serialize(), $formContentField;

        $(e.currentTarget).find('.form-content__field').removeClass('form-content__field_error');
        $(e.currentTarget).find('.form-content__error').text('');

        $.ajax({
            type: 'POST',
            url: '/worker/add-service',
            data: fields,
            success: (response) => {
                if (response) {
                    window.location.href = '/worker/tab/services';
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

    // Валидация и редактирование сервиса
    $('.worker-services-tab-content-controller .edit-service-modal-window .form-content').on('submit', (e) => {
        var fields = $(e.currentTarget).serialize(), $formContentField;

        $(e.currentTarget).find('.form-content__field').removeClass('form-content__field_error');
        $(e.currentTarget).find('.form-content__error').text('');

        $.ajax({
            type: 'POST',
            url: '/worker/edit-service',
            data: fields,
            success: (response) => {
                if (response) {
                    window.location.href = '/worker/tab/services';
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

    // Удаление сервиса
    $('.worker-services-tab-content-controller .tab-content-wrapper__list').on('click', '.del-btn', (e) => {
        var serviceId, token, serviceName = $(e.currentTarget).closest('.tab-content-wrapper__list-item-head').find('.tab-content-wrapper__list-item-name').text();

        if (confirm(`Вы действительно хотите удалить сервис "${serviceName}"?`)) {
            serviceId = $(e.currentTarget).closest('.tab-content-wrapper__list-item').attr('id');
            token = $('meta[name="csrf-token"]').attr('content');
            
            $.ajax({
                type: 'POST',
                url: '/worker/del-service',
                data: {
                    _token: token,
                    id: serviceId,
                },
                success: (response) => {
                    if (response) {
                        window.location.href = '/worker/tab/services';
                    }
                },
            });
        }
    });
});