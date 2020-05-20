// admin-work-places-tab-content-controller

$(document).ready(() => {
    // Открываем модальное окно для добавления рабочего места и обнуляем в нем сообщения об ошибках валидации
    $('.admin-work-places-tab-content-controller .add-btn').click((e) => {
        $('.admin-work-places-tab-content-controller .add-work-place-modal-window .form-content__field').removeClass('form-content__field_error');
        $('.admin-work-places-tab-content-controller .add-work-place-modal-window .form-content__error').text('');

        $(e.currentTarget).closest('.admin-work-places-tab-content-controller').find('.add-work-place-modal-window').addClass('modal-window_show');
    });

    // Открываем модальное окно для редактирования рабочего места, обнуляем в нем сообщения об ошибках валидации и заполняем его данными
    $('.admin-work-places-tab-content-controller .edit-btn').click((e) => {
        var workPlaceId = $(e.currentTarget).closest('.tab-content-wrapper__list-item').attr('id'), token = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            type: 'POST',
            url: '/admin/write-edit-work-place-form',
            data: {
                _token: token,
                id: workPlaceId,
            },
            dataType: 'json',
            success: (response) => {
                if (response) {
                    $('.admin-work-places-tab-content-controller .edit-work-place-modal-window .form-content__field').each((index, element) => {
                        var $fieldNameElement = $(element).find('[name]'), fieldName = $fieldNameElement.attr('name'), date, year, month, day;

                        $fieldNameElement.val(response[fieldName]);
                    });

                    $('.admin-work-places-tab-content-controller .edit-work-place-modal-window .form-content input[name="id"]').val(workPlaceId);
                    $('.admin-work-places-tab-content-controller .edit-work-place-modal-window .form-content__field').removeClass('form-content__field_error');
                    $('.admin-work-places-tab-content-controller .edit-work-place-modal-window .form-content__error').text('');

                    $(e.currentTarget).closest('.admin-work-places-tab-content-controller').find('.edit-work-place-modal-window').addClass('modal-window_show');
                }
            },
        });
    });

    // Обнуляем сообщения об ошибках валидации у текстовых полей
    $('.admin-work-places-tab-content-controller .add-work-place-modal-window .form-content__text, .admin-work-places-tab-content-controller .edit-work-place-modal-window .form-content__text').on('input', (e) => {
        var $formContentField = $(e.currentTarget).closest('.form-content__field');
        $formContentField.removeClass('form-content__field_error');
        $formContentField.find('.form-content__error').text('');
    });

    // Обнуляем сообщения об ошибках валидации у выпадающих списков
    $('.admin-work-places-tab-content-controller .add-work-place-modal-window .form-content__select, .admin-work-places-tab-content-controller .edit-work-place-modal-window .form-content__select, .admin-work-places-tab-content-controller .attach-worker-modal-window .form-content__select').on('change', (e) => {
        var $formContentField = $(e.currentTarget).closest('.form-content__field');
        $formContentField.removeClass('form-content__field_error');
        $formContentField.find('.form-content__error').text('');
    });

    // Валидация и добавление рабочего места
    $('.admin-work-places-tab-content-controller .add-work-place-modal-window .form-content').on('submit', (e) => {
        var fields = $(e.currentTarget).serialize(), $formContentField;

        $(e.currentTarget).find('.form-content__field').removeClass('form-content__field_error');
        $(e.currentTarget).find('.form-content__error').text('');

        $.ajax({
            type: 'POST',
            url: '/admin/add-work-place',
            data: fields,
            success: (response) => {
                if (response) {
                    window.location.href = '/admin/tab/work-places';
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

    // Валидация и редактирование рабочего места
    $('.admin-work-places-tab-content-controller .edit-work-place-modal-window .form-content').on('submit', (e) => {
        var fields = $(e.currentTarget).serialize(), $formContentField;

        $(e.currentTarget).find('.form-content__field').removeClass('form-content__field_error');
        $(e.currentTarget).find('.form-content__error').text('');

        $.ajax({
            type: 'POST',
            url: '/admin/edit-work-place',
            data: fields,
            success: (response) => {
                if (response) {
                    window.location.href = '/admin/tab/work-places';
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

    // Удаление рабочего места
    $('.admin-work-places-tab-content-controller .del-btn').click((e) => {
        var workPlaceId, token, workPlaceName = $(e.currentTarget).closest('.tab-content-wrapper__list-item-head').find('.tab-content-wrapper__list-item-name').text();

        if (confirm(`Вы действительно хотите удалить рабочее место "${workPlaceName}"?`)) {
            workPlaceId = $(e.currentTarget).closest('.tab-content-wrapper__list-item').attr('id');
            token = $('meta[name="csrf-token"]').attr('content');
            
            $.ajax({
                type: 'POST',
                url: '/admin/del-work-place',
                data: {
                    _token: token,
                    id: workPlaceId,
                },
                success: (response) => {
                    if (response) {
                        window.location.href = '/admin/tab/work-places';
                    }
                },
            });
        }
    });

    // Открываем блок модального окна управления комплектующими
    $('.admin-work-places-tab-content-controller .attach-component-parts-btn').click((e) => {
        var $window = $(e.currentTarget).closest('.admin-work-places-tab-content-controller').find('.attach-component-parts-modal-window');

        $window.attr('work-place-id', $(e.currentTarget).closest('.tab-content-wrapper__list-item').attr('id'));
        $window.attr('url-tab', 'work-places');
        $window.attr('loading', 'yes');
    });

    // Открываем модальное окно для прикрепления к рабочему месту сотрудника и обнуляем в нем сообщения об ошибках валидации
    $('.admin-work-places-tab-content-controller .attach-worker-btn').click((e) => {
        var workPlaceId = $(e.currentTarget).closest('.tab-content-wrapper__list-item').attr('id'), token = $('meta[name="csrf-token"]').attr('content');

        $('.admin-work-places-tab-content-controller .attach-worker-modal-window .form-content input[name="work_place_id"]').val(workPlaceId);
        $('.admin-work-places-tab-content-controller .attach-worker-modal-window .form-content__field').removeClass('form-content__field_error');
        $('.admin-work-places-tab-content-controller .attach-worker-modal-window .form-content__error').text('');

        $.ajax({
            type: 'POST',
            url: '/admin/get-free-workers',
            data: {
                _token: token,
            },
            dataType: 'json',
            success: (response) => {
                if (response) {
                    window.attachWorkerToWorkPlaceAngularController.workers = response;
                    window.attachWorkerToWorkPlaceAngularController.$apply();

                    $('.admin-work-places-tab-content-controller .attach-worker-modal-window__search-input').on('input', (e) => {
                        var inputText = $(e.currentTarget).val().toLowerCase().replace('ё', 'е');
                        
                        if (inputText !== '') {
                            window.attachWorkerToWorkPlaceAngularController.workers = [];
                            response.forEach(function(worker){
                                var name = worker.name.toLowerCase().replace('ё', 'е');
                
                                if (name.match(inputText)) {
                                    window.attachWorkerToWorkPlaceAngularController.workers.push(worker);
                                }
                            });
                        }
                        else {
                            window.attachWorkerToWorkPlaceAngularController.workers = response;
                        }
                
                        window.attachWorkerToWorkPlaceAngularController.$apply();
                    });
                    
                    $(e.currentTarget).closest('.admin-work-places-tab-content-controller').find('.attach-worker-modal-window').addClass('modal-window_show');
                    
                    setTimeout(() => {
                        $('.admin-work-places-tab-content-controller .attach-worker-modal-window__search-input').focus().val('');
                        $('.admin-work-places-tab-content-controller .attach-worker-modal-window .form-content__select').val('');
                    }, 0);
                }
            },
        });
    });

    // Валидация и прикрепление сотрудника к рабочему месту
    $('.admin-work-places-tab-content-controller .attach-worker-modal-window .form-content').on('submit', (e) => {
        var fields = $(e.currentTarget).serialize(), $formContentField;

        $(e.currentTarget).find('.form-content__field').removeClass('form-content__field_error');
        $(e.currentTarget).find('.form-content__error').text('');

        $.ajax({
            type: 'POST',
            url: '/admin/attach-worker-to-work-place',
            data: fields,
            success: (response) => {
                if (response) {
                    window.location.href = '/admin/tab/work-places';
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

    // Открепление сотрудника
    $('.admin-work-places-tab-content-controller .tab-content-wrapper__list').on('click', '.unattach-worker-btn', (e) => {
        var workPlaceId, workerId, token;

        if (confirm('Вы действительно хотите открепить сотрудника от рабочего места?')) {
            workPlaceId = $(e.currentTarget).closest('.tab-content-wrapper__list-item').attr('id');
            workerId = $(e.currentTarget).closest('.tab-content-wrapper__list-item').attr('worker_id');
            token = $('meta[name="csrf-token"]').attr('content');
            
            $.ajax({
                type: 'POST',
                url: '/admin/unattach-worker-from-work-place',
                data: {
                    _token: token,
                    work_place_id: workPlaceId,
                    worker_id: workerId,
                },
                success: (response) => {
                    if (response) {
                        window.location.href = '/admin/tab/work-places';
                    }
                },
            });
        }
    });
});