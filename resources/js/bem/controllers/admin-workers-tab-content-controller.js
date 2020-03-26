// admin-workers-tab-content-controller

$(document).ready(() => {
    // Открываем модальное окно для добавления устройства и обнуляем в нем сообщения об ошибках валидации
    $('.admin-workers-tab-content-controller').find('.add-btn').click((e) => {
        $('.admin-workers-tab-content-controller .add-worker-modal-window .form-content__field').removeClass('form-content__field_error');
        $('.admin-workers-tab-content-controller .add-worker-modal-window .form-content__error').text('');

        $(e.currentTarget).closest('.admin-workers-tab-content-controller').find('.add-worker-modal-window').addClass('modal-window_show');
    });

    // Обнуляем сообщения об ошибках валидации у текстовых полей
    $('.admin-workers-tab-content-controller .add-worker-modal-window .form-content__text').on('input', (e) => {
        var $formContentField = $(e.currentTarget).closest('.form-content__field');
        $formContentField.removeClass('form-content__field_error');
        $formContentField.find('.form-content__error').text('');
    });

    // Обнуляем сообщения об ошибках валидации у выпадающих списков
    $('.admin-workers-tab-content-controller .add-worker-modal-window .form-content__select').on('change', (e) => {
        var $formContentField = $(e.currentTarget).closest('.form-content__field');
        $formContentField.removeClass('form-content__field_error');
        $formContentField.find('.form-content__error').text('');
    });

    // Валидация и добавление сотрудника
    $('.admin-workers-tab-content-controller .add-worker-modal-window .form-content').on('submit', (e) => {
        var fields = $(e.currentTarget).serialize(), $formContentField;

        $(e.currentTarget).find('.form-content__field').removeClass('form-content__field_error');
        $(e.currentTarget).find('.form-content__error').text('');

        $.ajax({
            type: 'POST',
            url: 'admin/add-worker',
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

    // Удаление сотрудника
    $('.admin-workers-tab-content-controller .tab-content-wrapper__list').on('click', '.del-btn', (e) => {
        var workerId, token, workerName = $(e.currentTarget).closest('.tab-content-wrapper__list-item-head').find('.tab-content-wrapper__list-item-name').text();

        if (confirm(`Вы действительно хотите удалить сотрудника "${workerName}"?`)) {
            workerId = $(e.currentTarget).closest('.tab-content-wrapper__list-item').attr('id');
            token = $('meta[name="csrf-token"]').attr('content');
            
            $.ajax({
                type: 'POST',
                url: 'admin/del-worker',
                data: {
                    _token: token,
                    id: workerId,
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