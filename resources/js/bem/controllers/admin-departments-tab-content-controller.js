// admin-departments-tab-content-controller
$(document).ready(() => {
    // Открываем модальное окно для добавления отдела и обнуляем в нем сообщения об ошибках валидации
    $('.admin-departments-tab-content-controller').find('.add-btn').click((e) => {
        $('.admin-departments-tab-content-controller .add-department-modal-window .form-content__field').removeClass('form-content__field_error');
        $('.admin-departments-tab-content-controller .add-department-modal-window .form-content__error').text('');

        $(e.currentTarget).closest('.admin-departments-tab-content-controller').find('.add-department-modal-window').addClass('modal-window_show');
    });

    // Открываем модальное окно для редактирования отдела, обнуляем в нем сообщения об ошибках валидации и заполняем его данными
    $('.admin-departments-tab-content-controller .edit-btn').click((e) => {
        var departmentId = $(e.currentTarget).closest('.tab-content-wrapper__list-item').attr('id'), token = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            type: 'POST',
            url: '/admin/write-edit-department-form',
            data: {
                _token: token,
                id: departmentId,
            },
            dataType: 'json',
            success: (response) => {
                if (response) {
                    $('.admin-departments-tab-content-controller .edit-department-modal-window .form-content__field').each((index, element) => {
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

                    $('.admin-departments-tab-content-controller .edit-department-modal-window .form-content input[name="id"]').val(departmentId);
                    $('.admin-departments-tab-content-controller .edit-department-modal-window .form-content__field').removeClass('form-content__field_error');
                    $('.admin-departments-tab-content-controller .edit-department-modal-window .form-content__error').text('');

                    $(e.currentTarget).closest('.admin-departments-tab-content-controller').find('.edit-department-modal-window').addClass('modal-window_show');
                }
            },
        });
    });

    // Обнуляем сообщения об ошибках валидации у текстовых полей
    $('.admin-departments-tab-content-controller .add-department-modal-window .form-content__text, .admin-departments-tab-content-controller .edit-department-modal-window .form-content__text').on('input', (e) => {
        var $formContentField = $(e.currentTarget).closest('.form-content__field');
        $formContentField.removeClass('form-content__field_error');
        $formContentField.find('.form-content__error').text('');
    });

    // Валидация и добавление отдела
    $('.admin-departments-tab-content-controller .add-department-modal-window .form-content').on('submit', (e) => {
        var fields = $(e.currentTarget).serialize(), $formContentField;

        $(e.currentTarget).find('.form-content__field').removeClass('form-content__field_error');
        $(e.currentTarget).find('.form-content__error').text('');

        $.ajax({
            type: 'POST',
            url: '/admin/add-department',
            data: fields,
            success: (response) => {
                if (response) {
                    window.location.href = '/admin/tab/departments';
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

    // Валидация и редактирование отдела
    $('.admin-departments-tab-content-controller .edit-department-modal-window .form-content').on('submit', (e) => {
        var fields = $(e.currentTarget).serialize(), $formContentField;

        $(e.currentTarget).find('.form-content__field').removeClass('form-content__field_error');
        $(e.currentTarget).find('.form-content__error').text('');

        $.ajax({
            type: 'POST',
            url: '/admin/edit-department',
            data: fields,
            success: (response) => {
                if (response) {
                    window.location.href = '/admin/tab/departments';
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

    // Удаление отдела
    $('.admin-departments-tab-content-controller .tab-content-wrapper__list').on('click', '.del-btn', (e) => {
        var departmentId, token, departmentName = $(e.currentTarget).closest('.tab-content-wrapper__list-item-head').find('.tab-content-wrapper__list-item-name').text();

        if (confirm(`Вы действительно хотите удалить отдел "${departmentName}"?`)) {
            departmentId = $(e.currentTarget).closest('.tab-content-wrapper__list-item').attr('id');
            token = $('meta[name="csrf-token"]').attr('content');
            
            $.ajax({
                type: 'POST',
                url: '/admin/del-department',
                data: {
                    _token: token,
                    id: departmentId,
                },
                success: (response) => {
                    if (response) {
                        window.location.href = '/admin/tab/departments';
                    }
                },
            });
        }
    });
});