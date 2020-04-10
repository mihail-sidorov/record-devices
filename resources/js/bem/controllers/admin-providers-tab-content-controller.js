// admin-providers-tab-content-controller

$(document).ready(() => {
    // Открываем модальное окно для добавления поставщика и обнуляем в нем сообщения об ошибках валидации
    $('.admin-providers-tab-content-controller').find('.add-btn').click((e) => {
        $('.admin-providers-tab-content-controller .add-provider-modal-window .form-content__field').removeClass('form-content__field_error');
        $('.admin-providers-tab-content-controller .add-provider-modal-window .form-content__error').text('');

        $(e.currentTarget).closest('.admin-providers-tab-content-controller').find('.add-provider-modal-window').addClass('modal-window_show');
    });

    // Открываем модальное окно для редактирования поставщика, обнуляем в нем сообщения об ошибках валидации и заполняем его данными
    $('.admin-providers-tab-content-controller .edit-btn').click((e) => {
        var providerId = $(e.currentTarget).closest('.tab-content-wrapper__list-item').attr('id'), token = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            type: 'POST',
            url: '/admin/write-edit-provider-form',
            data: {
                _token: token,
                id: providerId,
            },
            dataType: 'json',
            success: (response) => {
                if (response) {
                    $('.admin-providers-tab-content-controller .edit-provider-modal-window .form-content__field').each((index, element) => {
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

                    $('.admin-providers-tab-content-controller .edit-provider-modal-window .form-content input[name="id"]').val(providerId);
                    $('.admin-providers-tab-content-controller .edit-provider-modal-window .form-content__field').removeClass('form-content__field_error');
                    $('.admin-providers-tab-content-controller .edit-provider-modal-window .form-content__error').text('');

                    $(e.currentTarget).closest('.admin-providers-tab-content-controller').find('.edit-provider-modal-window').addClass('modal-window_show');
                }
            },
        });
    });

    // Обнуляем сообщения об ошибках валидации у текстовых полей
    $('.admin-providers-tab-content-controller .add-provider-modal-window .form-content__text, .admin-providers-tab-content-controller .edit-provider-modal-window .form-content__text').on('input', (e) => {
        var $formContentField = $(e.currentTarget).closest('.form-content__field');
        $formContentField.removeClass('form-content__field_error');
        $formContentField.find('.form-content__error').text('');
    });

    // Валидация и добавление поставщика
    $('.admin-providers-tab-content-controller .add-provider-modal-window .form-content').on('submit', (e) => {
        var fields = $(e.currentTarget).serialize(), $formContentField;

        $(e.currentTarget).find('.form-content__field').removeClass('form-content__field_error');
        $(e.currentTarget).find('.form-content__error').text('');

        $.ajax({
            type: 'POST',
            url: '/admin/add-provider',
            data: fields,
            success: (response) => {
                if (response) {
                    window.location.href = '/admin/tab/providers';
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

    // Валидация и редактирование поставщика
    $('.admin-providers-tab-content-controller .edit-provider-modal-window .form-content').on('submit', (e) => {
        var fields = $(e.currentTarget).serialize(), $formContentField;

        $(e.currentTarget).find('.form-content__field').removeClass('form-content__field_error');
        $(e.currentTarget).find('.form-content__error').text('');

        $.ajax({
            type: 'POST',
            url: '/admin/edit-provider',
            data: fields,
            success: (response) => {
                if (response) {
                    window.location.href = '/admin/tab/providers';
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

    // Удаление поставщика
    $('.admin-providers-tab-content-controller .tab-content-wrapper__list').on('click', '.del-btn', (e) => {
        var providerId, token, providerName = $(e.currentTarget).closest('.tab-content-wrapper__list-item-head').find('.tab-content-wrapper__list-item-name').text();

        if (confirm(`Вы действительно хотите удалить поставщика "${providerName}"?`)) {
            providerId = $(e.currentTarget).closest('.tab-content-wrapper__list-item').attr('id');
            token = $('meta[name="csrf-token"]').attr('content');
            
            $.ajax({
                type: 'POST',
                url: '/admin/del-provider',
                data: {
                    _token: token,
                    id: providerId,
                },
                success: (response) => {
                    if (response) {
                        window.location.href = '/admin/tab/providers';
                    }
                },
            });
        }
    });
});