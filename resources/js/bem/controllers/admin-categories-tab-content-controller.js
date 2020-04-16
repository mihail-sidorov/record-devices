// admin-categories-tab-content-controller
$(document).ready(() => {
    // Открываем модальное окно для добавления категории и обнуляем в нем сообщения об ошибках валидации
    $('.admin-categories-tab-content-controller').find('.add-btn').click((e) => {
        $('.admin-categories-tab-content-controller .add-category-modal-window .form-content__field').removeClass('form-content__field_error');
        $('.admin-categories-tab-content-controller .add-category-modal-window .form-content__error').text('');

        $(e.currentTarget).closest('.admin-categories-tab-content-controller').find('.add-category-modal-window').addClass('modal-window_show');
    });

    // Открываем модальное окно для редактирования категории, обнуляем в нем сообщения об ошибках валидации и заполняем его данными
    $('.admin-categories-tab-content-controller .edit-btn').click((e) => {
        var categoryId = $(e.currentTarget).closest('.tab-content-wrapper__list-item').attr('id'), token = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            type: 'POST',
            url: '/admin/write-edit-category-form',
            data: {
                _token: token,
                id: categoryId,
            },
            dataType: 'json',
            success: (response) => {
                if (response) {
                    $('.admin-categories-tab-content-controller .edit-category-modal-window .form-content__field').each((index, element) => {
                        var $fieldNameElement = $(element).find('[name]'), fieldName = $fieldNameElement.attr('name'), description;

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

                    $('.admin-categories-tab-content-controller .edit-category-modal-window .form-content input[name="id"]').val(categoryId);
                    $('.admin-categories-tab-content-controller .edit-category-modal-window .form-content__field').removeClass('form-content__field_error');
                    $('.admin-categories-tab-content-controller .edit-category-modal-window .form-content__error').text('');

                    $(e.currentTarget).closest('.admin-categories-tab-content-controller').find('.edit-category-modal-window').addClass('modal-window_show');
                }
            },
        });
    });

    // Обнуляем сообщения об ошибках валидации у текстовых полей
    $('.admin-categories-tab-content-controller .add-category-modal-window .form-content__text, .admin-categories-tab-content-controller .edit-category-modal-window .form-content__text').on('input', (e) => {
        var $formContentField = $(e.currentTarget).closest('.form-content__field');
        $formContentField.removeClass('form-content__field_error');
        $formContentField.find('.form-content__error').text('');
    });

    // Валидация и добавление категории
    $('.admin-categories-tab-content-controller .add-category-modal-window .form-content').on('submit', (e) => {
        var fields = $(e.currentTarget).serialize(), $formContentField;

        $(e.currentTarget).find('.form-content__field').removeClass('form-content__field_error');
        $(e.currentTarget).find('.form-content__error').text('');

        $.ajax({
            type: 'POST',
            url: '/admin/add-category',
            data: fields,
            success: (response) => {
                if (response) {
                    window.location.href = '/admin/tab/categories';
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

    // Валидация и редактирование категории
    $('.admin-categories-tab-content-controller .edit-category-modal-window .form-content').on('submit', (e) => {
        var fields = $(e.currentTarget).serialize(), $formContentField;

        $(e.currentTarget).find('.form-content__field').removeClass('form-content__field_error');
        $(e.currentTarget).find('.form-content__error').text('');

        $.ajax({
            type: 'POST',
            url: '/admin/edit-category',
            data: fields,
            success: (response) => {
                if (response) {
                    window.location.href = '/admin/tab/categories';
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