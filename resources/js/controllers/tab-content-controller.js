window.tabContentController = class tabContentController {
    constructor($controllerElement) {
        this.controllerElement = $controllerElement;

        // Обнуляем сообщения об ошибках валидации у текстовых полей
        this.controllerElement.find('.form-content__text').on('keydown input', (e) => {
            this.clearValidateErrors($(e.currentTarget));
        });

        // Обнуляем сообщения об ошибках валидации у дат и выпадающих списков
        this.controllerElement.find('.form-content__select, .form-content__date').on('input', (e) => {
            this.clearValidateErrors($(e.currentTarget));
        });
    }

    showModalWindow($modalWindow) {
        $modalWindow.find('.form-content__field').removeClass('form-content__field_error');
        $modalWindow.find('.form-content__error').text('');
        $modalWindow.attr('show', 'yes');
    }

    addEntity($eventElement, route, tab) {
        var fields = $eventElement.serialize(), $formContentField, id = $eventElement.closest('.modal-window').attr('id');

        if (id !== '') {
            fields += `&id=${id}`;
        }

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

                                if (key === 'password') {
                                    $formContentField.find('input').val('');
                                    $formContentField.closest('.form-content').find('input[name="password_confirmation"]').val('');
                                }
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

    writeEditEntityModalWindow($eventElement, route, $editEntityModalWindow, id) {
        var token = $('meta[name="csrf-token"]').attr('content');

        if (!id) {
            id = $eventElement.closest('.tab-content-wrapper__list-item').attr('id');
        }

        $editEntityModalWindow.find('.form-content__field [name]').val('');
        
        $.ajax({
            type: 'POST',
            url: route,
            data: {
                _token: token,
                id: id,
            },
            dataType: 'json',
            success: (response) => {
                if (response) {
                    $editEntityModalWindow.find('.form-content__field').each((index, element) => {
                        var $fieldNameElement = $(element).find('[name]'), fieldName = $fieldNameElement.attr('name'), date, year, month, day;

                        if (fieldName === 'receipt_date' || fieldName === 'warranty' || fieldName === 'placement_date') {
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

                    $editEntityModalWindow.find('.form-content input[name="id"]').val(id);
                }
            },
        });
    }

    editEntity($eventElement, route, tab) {
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

                                if (key === 'current_password' || key === 'password') {
                                    $formContentField.find('input').val('');
                                }
                                if (key === 'password') {
                                    $formContentField.closest('.form-content').find('input[name="password_confirmation"]').val('');
                                }
                            }
                        }
                    }
                }
            },
        });
    }

    writeAttachWorkerModalWindow($controllerElement, $eventElement, route, scope) {
        var id = $eventElement.closest('.tab-content-wrapper__list-item').attr('id'), token = $('meta[name="csrf-token"]').attr('content');

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
                    
                    $controllerElement.find('.attach-worker-modal-window .form-content input[name="id"]').val(id);
                    
                    $controllerElement.find('.attach-worker-modal-window .form-content__select').val('');
                    this.showModalWindow(this.controllerElement.find('.attach-worker-modal-window'));
                    setTimeout(() => {
                        $controllerElement.find('.attach-worker-modal-window__search-input').focus().val('');
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
            workerId = $eventElement.closest('.tab-content-wrapper__list-item').attr('worker-id');
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

    delEntity($eventElement, route, tab, entityName) {
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
                error: (error) => {
                    if (error.status === 422) {
                        alert(error.responseJSON.error);
                    }
                },
            });
        }
    }

    writeMultiAttachModalWindow($eventElement, route, $modalWindow) {
        token = $('meta[name="csrf-token"]').attr('content'), id = $eventElement.closest('.tab-content-wrapper__list-item').attr('id');
        $.ajax({
            type: 'POST',
            url: route,
            data: {
                _token: token,
                id: id,
            },
            dataType: 'json',
            success: (response) => {
                $categories = $modalWindow.find('.multi-attach-modal-window__categories');
                $categories.html('');
                response.forEach((item) => {
                    var elements = '', checkedArr = item.checked, openCategory = false, openCategoryHead, openCategoryBody;
                    item.elements.forEach((item, index) => {
                        var checked = '';
                        if (checkedArr[index]) {
                            checked = ' checked';
                            openCategory = true;
                        }

                        var element = `
                            <label class="multi-attach-modal-window__element"><input type="checkbox"${checked} name="element-${item.id}">${item.name}</label>`;
                            elements += element;
                    });

                    if (openCategory) {
                        openCategoryHead = ' multi-attach-modal-window__category-head_show';
                        openCategoryBody = ' multi-attach-modal-window__category-body_show';
                    }
                    else {
                        openCategoryHead = '';
                        openCategoryBody = '';
                    }

                    var category = `
                        <div class="multi-attach-modal-window__category" id="${item.category.id}">
                            <div class="multi-attach-modal-window__category-head${openCategoryHead}">${item.category.name}</div>
                            <div class="multi-attach-modal-window__category-body${openCategoryBody}"><div class="multi-attach-modal-window__elements">${elements}</div></div>
                        </div>
                    `;
                    $categories.append(category);
                });

                $categories.find('.multi-attach-modal-window__category-head').click((e) => {
                    $(e.currentTarget).toggleClass('multi-attach-modal-window__category-head_show');
                    $(e.currentTarget).closest('.multi-attach-modal-window__category').find('.multi-attach-modal-window__category-body').slideToggle();
                });

                $modalWindow.attr('id', id);

                this.showModalWindow($modalWindow);
            },
        });
    }

    multiAttach(route, tab, $modalWindow) {
        var elements = [], elementIds = [], elementCheckes = [], $categories = $modalWindow.find('.multi-attach-modal-window__categories'), token = $('meta[name="csrf-token"]').attr('content');

        $categories.find('.multi-attach-modal-window__element').each((index, element) => {
            var $input = $(element).children('input');
            elementIds.push($input.attr('name').split('-')[1]);
            if ($input.prop('checked')) {
                elementCheckes.push(1);
            }
            else {
                elementCheckes.push(0);
            }
        });
        elements.push(elementIds);
        elements.push(elementCheckes);

        $.ajax({
            type: 'POST',
            url: route,
            data: {
                _token: token,
                id: $modalWindow.attr('id'),
                elements: elements,
            },
            dataType: 'json',
            success: () => {
                window.location.href = tab;
            },
            error: (error) => {
                if (error.status === 422) {
                    alert(error.responseJSON.error);
                    $modalWindow.attr('show', 'no');
                }
            },
        });
    }
}