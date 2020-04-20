// admin-component_parts-tab-content-controller

$(document).ready(() => {
    // Открываем модальное окно для добавления комплектующего и обнуляем в нем сообщения об ошибках валидации
    $('.admin-component_parts-tab-content-controller .add-btn').click((e) => {
        $('.admin-component_parts-tab-content-controller .add-component_part-modal-window .form-content__field').removeClass('form-content__field_error');
        $('.admin-component_parts-tab-content-controller .add-component_part-modal-window .form-content__error').text('');

        $(e.currentTarget).closest('.admin-component_parts-tab-content-controller').find('.add-component_part-modal-window').addClass('modal-window_show');
    });

    // Обнуляем сообщения об ошибках валидации у текстовых полей
    $('.admin-component_parts-tab-content-controller .add-component_part-modal-window .form-content__text, .admin-component_parts-tab-content-controller .edit-component_part-modal-window .form-content__text').on('input', (e) => {
        var $formContentField = $(e.currentTarget).closest('.form-content__field');
        $formContentField.removeClass('form-content__field_error');
        $formContentField.find('.form-content__error').text('');
    });

    // Обнуляем сообщения об ошибках валидации у дат и выпадающих списков
    $('.admin-component_parts-tab-content-controller .add-component_part-modal-window .form-content__select, .admin-component_parts-tab-content-controller .add-component_part-modal-window .form-content__date, .admin-component_parts-tab-content-controller .edit-component_part-modal-window .form-content__select, .admin-component_parts-tab-content-controller .edit-component_part-modal-window .form-content__date').on('change', (e) => {
        var $formContentField = $(e.currentTarget).closest('.form-content__field');
        $formContentField.removeClass('form-content__field_error');
        $formContentField.find('.form-content__error').text('');
    });

    // Валидация и добавление комплектующего
    $('.admin-component_parts-tab-content-controller .add-component_part-modal-window .form-content').on('submit', (e) => {
        var fields = $(e.currentTarget).serialize(), $formContentField;

        $(e.currentTarget).find('.form-content__field').removeClass('form-content__field_error');
        $(e.currentTarget).find('.form-content__error').text('');

        $.ajax({
            type: 'POST',
            url: '/admin/add-component-part',
            data: fields,
            success: (response) => {
                if (response) {
                    window.location.href = '/admin/tab/component_parts';
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