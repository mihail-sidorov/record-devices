$(document).ready(() => {
    class uploadActController {
        constructor($uploadActController) {
            $uploadActController.find('input[type="file"]').on('change', (e) => {
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
        }
    }

    new uploadActController($('.upload-act-controller'));
});