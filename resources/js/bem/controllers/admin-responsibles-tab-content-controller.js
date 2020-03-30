// admin-responsibles-tab-content-controller

$(document).ready(() => {
    // Открываем модальное окно для добавления ответственного и обнуляем в нем сообщения об ошибках валидации
    $('.admin-responsibles-tab-content-controller').find('.add-btn').click((e) => {
        $('.admin-responsibles-tab-content-controller .add-responsible-modal-window .form-content__field').removeClass('form-content__field_error');
        $('.admin-responsibles-tab-content-controller .add-responsible-modal-window .form-content__error').text('');

        $(e.currentTarget).closest('.admin-responsibles-tab-content-controller').find('.add-responsible-modal-window').addClass('modal-window_show');
    });

    // Обнуляем сообщения об ошибках валидации у текстовых полей
    $('.admin-responsibles-tab-content-controller .add-responsible-modal-window .form-content__text').on('input', (e) => {
        var $formContentField = $(e.currentTarget).closest('.form-content__field');
        $formContentField.removeClass('form-content__field_error');
        $formContentField.find('.form-content__error').text('');
    });

    // Обнуляем сообщения об ошибках валидации у выпадающих списков
    $('.admin-responsibles-tab-content-controller .add-responsible-modal-window .form-content__select').on('change', (e) => {
        var $formContentField = $(e.currentTarget).closest('.form-content__field');
        $formContentField.removeClass('form-content__field_error');
        $formContentField.find('.form-content__error').text('');
    });

    // Валидация и добавление сотрудника
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
});