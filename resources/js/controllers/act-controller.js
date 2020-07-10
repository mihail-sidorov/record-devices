$(document).ready(() => {
    class ActController {
        constructor($ActController) {
            $ActController.find('input[type="file"]').on('change', (e) => {
                var data = new FormData(), token = $('meta[name="csrf-token"]').attr('content'), id = $(e.currentTarget).closest('.tab-content-wrapper__list-item').attr('id');

                data.append('img', e.currentTarget.files[0]);
                data.append('_token', token);
                data.append('id', id);

                $.ajax({
                    url: '/act/upload',
                    type: 'POST',
                    data: data,
                    cache: false,
                    dataType: 'json',
                    processData: false,
                    contentType: false, 
                    success: (res) => {
                        if (res) {
                            window.location.href = '/admin/tab/acts';
                        }
                    },
                    error: (error) => {
                        var errors;

                        if (error.status === 422) {
                            errors = error.responseJSON.errors;
                            alert(errors.img[0]);
                        }
                    }
                });
            });

            $('.admin-acts-tab-content-controller .del-btn').on('click', (e) => {
                this.delAct($(e.currentTarget), '/act/delete', '/admin/tab/acts', 'акт');
            });
        }

        createAct($eventElement, route, tab) {
            var fields = $eventElement.serialize();
    
            $.ajax({
                type: 'POST',
                url: route,
                data: fields,
                success: (response) => {
                    if (response) {
                        window.location.href = tab;
                    }
                },
            });
        }

        delAct($eventElement, route, tab, entityName) {
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
    }

    window.actController = new ActController($('.act-controller'));
});