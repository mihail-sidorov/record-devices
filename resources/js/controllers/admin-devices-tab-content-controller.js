$(document).ready(() => {
    class adminDevicesTabContentController {
        constructor($controllerElement) {
            this.controllerElement = $controllerElement;

            // Открываем модальное окно добавления устройства
            this.controllerElement.find('.add-btn').click((e) => {
                this.showAddDeviceModalWindow(this.controllerElement);
            });

            // Валидация и добавление устройства
            this.controllerElement.find('.add-device-modal-window .form-content').on('submit', (e) => {
                this.addDevice($(e.currentTarget));
                return false;
            });

            // Обнуляем сообщения об ошибках валидации у текстовых полей
            this.controllerElement.find('.form-content__text').on('input', (e) => {
                this.clearValidateErrors($(e.currentTarget));
            });

            // Обнуляем сообщения об ошибках валидации у дат и выпадающих списков
            this.controllerElement.find('.form-content__select, .form-content__date').on('input', (e) => {
                this.clearValidateErrors($(e.currentTarget));
            });

            // Открываем модальное окно для редактирования устройства, обнуляем в нем сообщения об ошибках валидации и заполняем его данными
            this.controllerElement.find('.edit-btn').click((e) => {
                this.showEditDeviceModalWindow(this.controllerElement, $(e.currentTarget));
            });

            // Валидация и редактирование устройства
            this.controllerElement.find('.edit-device-modal-window .form-content').on('submit', (e) => {
                this.editDevice($(e.currentTarget));
                return false;
            });

            // Открываем модальное окно для прикрепления к устройству сотрудника и обнуляем в нем сообщения об ошибках валидации
            this.controllerElement.find('.attach-worker-btn').click((e) => {
                this.showAttachWorkerModalWindow(this.controllerElement, $(e.currentTarget), '/admin/get-free-workers-to-device', window.attachWorkerToDeviceAngularControllerScope);
            });

            // Валидация и прикрепление сотрудника к устройству
            this.controllerElement.find('.attach-worker-modal-window .form-content').on('submit', (e) => {
                this.attachWorker($(e.currentTarget), '/admin/attach-worker-to-device', '/admin/tab/devices');
                return false;
            });

            // Открепление сотрудника от устройства
            this.controllerElement.find('.unattach-worker-btn').click((e) => {
                this.unattachWorker($(e.currentTarget), '/admin/unattach-worker-from-device', '/admin/tab/devices');
            });

            // Удаление устройства
            this.controllerElement.find('.del-btn').click((e) => {
                this.delDevice($(e.currentTarget), '/admin/del-device', '/admin/tab/devices', 'устройство');
            });
        }

        showAddDeviceModalWindow($controllerElement) {
            $controllerElement.find('.add-device-modal-window .form-content__field').removeClass('form-content__field_error');
            $controllerElement.find('.add-device-modal-window .form-content__error').text('');
            $controllerElement.find('.add-device-modal-window').addClass('modal-window_show');
        }

        addDevice($eventElement) {
            var fields = $eventElement.serialize(), $formContentField;

            $eventElement.find('.form-content__field').removeClass('form-content__field_error');
            $eventElement.find('.form-content__error').text('');

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
                                    $formContentField = $eventElement.find(`.form-content__error[field-name="${key}"]`).closest('.form-content__field');
                                    $formContentField.addClass('form-content__field_error');
                                    $formContentField.find('.form-content__error').text(errors[key][0]);
                                }
                            }
                        }
                    }
                },
            });
        }

        clearValidateErrors($eventElement) {
            var $formContentField = $eventElement.closest('.form-content__field');
            $formContentField.removeClass('form-content__field_error');
            $formContentField.find('.form-content__error').text('');
        }

        showEditDeviceModalWindow($controllerElement, $eventElement) {
            var deviceId = $eventElement.closest('.tab-content-wrapper__list-item').attr('id'), token = $('meta[name="csrf-token"]').attr('content');

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
                        $controllerElement.find('.edit-device-modal-window .form-content__field').each((index, element) => {
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
                        });

                        $controllerElement.find('.edit-device-modal-window .form-content input[name="id"]').val(deviceId);
                        $controllerElement.find('.edit-device-modal-window .form-content__field').removeClass('form-content__field_error');
                        $controllerElement.find('.edit-device-modal-window .form-content__error').text('');

                        $controllerElement.find('.edit-device-modal-window').addClass('modal-window_show');
                    }
                },
            });
        }

        editDevice($eventElement) {
            var fields = $eventElement.serialize(), $formContentField;

            $eventElement.find('.form-content__field').removeClass('form-content__field_error');
            $eventElement.find('.form-content__error').text('');

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
                                    $formContentField = $eventElement.find(`.form-content__error[field-name="${key}"]`).closest('.form-content__field');
                                    $formContentField.addClass('form-content__field_error');
                                    $formContentField.find('.form-content__error').text(errors[key][0]);
                                }
                            }
                        }
                    }
                },
            });
        }

        showAttachWorkerModalWindow($controllerElement, $eventElement, route, scope) {
            var id = $eventElement.closest('.tab-content-wrapper__list-item').attr('id'), token = $('meta[name="csrf-token"]').attr('content');

            $controllerElement.find('.attach-worker-modal-window .form-content input[name="id"]').val(id);
            $controllerElement.find('.attach-worker-modal-window .form-content__field').removeClass('form-content__field_error');
            $controllerElement.find('.attach-worker-modal-window .form-content__error').text('');

            $.ajax({
                type: 'POST',
                url: route,
                data: {
                    _token: token,
                },
                dataType: 'json',
                success: (response) => {
                    if (response) {
                        scope.workers = response;
                        scope.$apply();

                        $controllerElement.find('.attach-worker-modal-window__search-input').off('input');
                        $controllerElement.find('.attach-worker-modal-window__search-input').on('input', (e) => {
                            var inputText = $(e.currentTarget).val().toLowerCase().replace('ё', 'е');
                            
                            if (inputText !== '') {
                                scope.workers = [];
                                response.forEach(function(worker){
                                    var name = worker.name.toLowerCase().replace('ё', 'е');
                    
                                    if (name.match(inputText)) {
                                        scope.workers.push(worker);
                                    }
                                });
                            }
                            else {
                                scope.workers = response;
                            }
                    
                            scope.$apply();
                        });
                        
                        $controllerElement.find('.attach-worker-modal-window').addClass('modal-window_show');
                        
                        setTimeout(() => {
                            $controllerElement.find('.attach-worker-modal-window__search-input').focus().val('');
                            $controllerElement.find('.attach-worker-modal-window .form-content__select').val('');
                        }, 0);
                    }
                },
            });
        }

        attachWorker($eventElement, route, tab) {
            var fields = $eventElement.serialize(), $formContentField;

            $eventElement.find('.form-content__field').removeClass('form-content__field_error');
            $eventElement.find('.form-content__error').text('');
    
            $.ajax({
                type: 'POST',
                url: route,
                data: fields,
                success: (response) => {
                    if (response) {
                        window.location.href = tab;
                    }
                },
                error:  (error) => {
                    var errors;
    
                    if (error.status === 422) {
                        errors = error.responseJSON.errors;
                        if (errors !== undefined) {
                            for (var key in errors) {
                                if (errors[key][0]) {
                                    $formContentField = $eventElement.find(`.form-content__error[field-name="${key}"]`).closest('.form-content__field');
                                    $formContentField.addClass('form-content__field_error');
                                    $formContentField.find('.form-content__error').text(errors[key][0]);
                                }
                            }
                        }
                    }
                },
            });  
        }

        unattachWorker($eventElement, route, tab) {
            var id, workerId, token;

            if (confirm('Вы действительно хотите открепить сотрудника?')) {
                id = $eventElement.closest('.tab-content-wrapper__list-item').attr('id');
                workerId = $eventElement.closest('.tab-content-wrapper__list-item').attr('worker_id');
                token = $('meta[name="csrf-token"]').attr('content');
                
                $.ajax({
                    type: 'POST',
                    url: route,
                    data: {
                        _token: token,
                        id: id,
                        worker_id: workerId,
                    },
                    success: (response) => {
                        if (response) {
                            window.location.href = tab;
                        }
                    },
                });
            }
        }

        delDevice($eventElement, route, tab, entityName) {
            var id, token, name = $eventElement.closest('.tab-content-wrapper__list-item-head').find('.tab-content-wrapper__list-item-name').text();

            if (confirm(`Вы действительно хотите удалить ${entityName} "${name}"?`)) {
                id = $eventElement.closest('.tab-content-wrapper__list-item').attr('id');
                token = $('meta[name="csrf-token"]').attr('content');
                
                $.ajax({
                    type: 'POST',
                    url: route,
                    data: {
                        _token: token,
                        id: id,
                    },
                    success: (response) => {
                        if (response) {
                            window.location.href = tab;
                        }
                    },
                });
            }
        }
    }

    window.adminDevicesTabContentController = new adminDevicesTabContentController($('.admin-devices-tab-content-controller'));
});