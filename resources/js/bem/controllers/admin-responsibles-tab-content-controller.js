// admin-responsibles-tab-content-controller

$(document).ready(() => {
    // Открываем модальное окно для добавления ответственного и обнуляем в нем сообщения об ошибках валидации
    $('.admin-responsibles-tab-content-controller').find('.add-btn').click((e) => {
        $('.admin-responsibles-tab-content-controller .add-responsible-modal-window .form-content__field').removeClass('form-content__field_error');
        $('.admin-responsibles-tab-content-controller .add-responsible-modal-window .form-content__error').text('');

        $(e.currentTarget).closest('.admin-responsibles-tab-content-controller').find('.add-responsible-modal-window').addClass('modal-window_show');
    });

    // Открываем модальное окно для редактирования ответственного, обнуляем в нем сообщения об ошибках валидации и заполняем его данными
    $('.admin-responsibles-tab-content-controller .edit-btn').click((e) => {
        var responsibleId = $(e.currentTarget).closest('.tab-content-wrapper__list-item').attr('id'), token = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            type: 'POST',
            url: 'admin/write-edit-responsible-form',
            data: {
                _token: token,
                id: responsibleId,
            },
            dataType: 'json',
            success: (response) => {
                if (response) {
                    $('.admin-responsibles-tab-content-controller .edit-responsible-modal-window .form-content__field').each((index, element) => {
                        var $fieldNameElement = $(element).find('[name]'), fieldName = $fieldNameElement.attr('name');

                        $fieldNameElement.val(response[fieldName]);
                    });

                    $('.admin-responsibles-tab-content-controller .edit-responsible-modal-window .form-content input[name="id"]').val(responsibleId);
                    $('.admin-responsibles-tab-content-controller .edit-responsible-modal-window .form-content__field').removeClass('form-content__field_error');
                    $('.admin-responsibles-tab-content-controller .edit-responsible-modal-window .form-content__error').text('');

                    $(e.currentTarget).closest('.admin-responsibles-tab-content-controller').find('.edit-responsible-modal-window').addClass('modal-window_show');
                }
            },
        });
    });

    // Обнуляем сообщения об ошибках валидации у текстовых полей
    $('.admin-responsibles-tab-content-controller .add-responsible-modal-window .form-content__text, .admin-responsibles-tab-content-controller .edit-responsible-modal-window .form-content__text').on('input', (e) => {
        var $formContentField = $(e.currentTarget).closest('.form-content__field');
        $formContentField.removeClass('form-content__field_error');
        $formContentField.find('.form-content__error').text('');
    });

    // Обнуляем сообщения об ошибках валидации у выпадающих списков
    $('.admin-responsibles-tab-content-controller .add-responsible-modal-window .form-content__select, .admin-responsibles-tab-content-controller .edit-responsible-modal-window .form-content__select').on('change', (e) => {
        var $formContentField = $(e.currentTarget).closest('.form-content__field');
        $formContentField.removeClass('form-content__field_error');
        $formContentField.find('.form-content__error').text('');
    });

    // Валидация и добавление ответственного
    $('.admin-responsibles-tab-content-controller .add-responsible-modal-window .form-content').on('submit', (e) => {
        var fields = $(e.currentTarget).serialize(), $formContentField;

        $(e.currentTarget).find('.form-content__field').removeClass('form-content__field_error');
        $(e.currentTarget).find('.form-content__error').text('');

        $.ajax({
            type: 'POST',
            url: 'admin/add-responsible',
            data: fields,
            success: (response) => {
                if (response) {
                    window.location.href = '/admin';
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

    // Валидация и редактирование ответственного
    $('.admin-responsibles-tab-content-controller .edit-responsible-modal-window .form-content').on('submit', (e) => {
        var fields = $(e.currentTarget).serialize(), $formContentField;

        $(e.currentTarget).find('.form-content__field').removeClass('form-content__field_error');
        $(e.currentTarget).find('.form-content__error').text('');

        $.ajax({
            type: 'POST',
            url: 'admin/edit-responsible',
            data: fields,
            success: (response) => {
                if (response) {
                    window.location.href = '/admin';
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

    // Удаление ответственного
    $('.admin-responsibles-tab-content-controller .tab-content-wrapper__list').on('click', '.del-btn', (e) => {
        var responsibleId, token, responsibleName = $(e.currentTarget).closest('.tab-content-wrapper__list-item-head').find('.tab-content-wrapper__list-item-name').text();

        if (confirm(`Вы действительно хотите удалить ответственного "${responsibleName}"?`)) {
            responsibleId = $(e.currentTarget).closest('.tab-content-wrapper__list-item').attr('id');
            token = $('meta[name="csrf-token"]').attr('content');
            
            $.ajax({
                type: 'POST',
                url: 'admin/del-responsible',
                data: {
                    _token: token,
                    id: responsibleId,
                },
                success: (response) => {
                    if (response) {
                        window.location.href = '/admin';
                    }
                },
            });
        }
    });
});