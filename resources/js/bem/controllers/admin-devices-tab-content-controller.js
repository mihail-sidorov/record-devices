// admin-devices-tab-content-controller

$(document).ready(() => {
    $('.admin-devices-tab-content-controller .add-btn').click((e) => {
        $('.admin-devices-tab-content-controller .add-device-modal-window .form-content__field').removeClass('form-content__field_error');
        $('.admin-devices-tab-content-controller .add-device-modal-window .form-content__error').text('');

        $(e.currentTarget).closest('.admin-devices-tab-content-controller').find('.add-device-modal-window').addClass('modal-window_show');
    });

    $('.admin-devices-tab-content-controller .add-device-modal-window .form-content__text').on('input', (e) => {
        var $formContentField = $(e.currentTarget).closest('.form-content__field');
        $formContentField.removeClass('form-content__field_error');
        $formContentField.find('.form-content__error').text('');
    });

    $('.admin-devices-tab-content-controller .add-device-modal-window .form-content__select, .admin-devices-tab-content-controller .add-device-modal-window .form-content__date').on('change', (e) => {
        var $formContentField = $(e.currentTarget).closest('.form-content__field');
        $formContentField.removeClass('form-content__field_error');
        $formContentField.find('.form-content__error').text('');
    });

    $('.admin-devices-tab-content-controller .add-device-modal-window .form-content').on('submit', (e) => {
        var fields = $(e.currentTarget).serialize(), $formContentField;

        $(e.currentTarget).find('.form-content__field').removeClass('form-content__field_error');
        $(e.currentTarget).find('.form-content__error').text('');

        $.ajax({
            type: 'POST',
            url: 'admin/add-device',
            data: fields,
            success: (response) => {
                if (response === '403') {
                    window.location.href = '/';
                }

                if (response === 'addDevice') {
                    window.location.href = '/admin';
                }
            },
            error:  (error) => {
                if (error.responseJSON.errors.name !== undefined) {
                    if (error.responseJSON.errors.name[0]) {
                        $formContentField = $(e.currentTarget).find('.form-content__error[field-name="name"]').closest('.form-content__field');
                        $formContentField.addClass('form-content__field_error');
                        $formContentField.find('.form-content__error').text(error.responseJSON.errors.name[0]);
                    }
                }

                if (error.responseJSON.errors.model !== undefined) {
                    if (error.responseJSON.errors.model[0]) {
                        $formContentField = $(e.currentTarget).find('.form-content__error[field-name="model"]').closest('.form-content__field');
                        $formContentField.addClass('form-content__field_error');
                        $formContentField.find('.form-content__error').text(error.responseJSON.errors.model[0]);
                    }
                }

                if (error.responseJSON.errors.serial_number !== undefined) {
                    if (error.responseJSON.errors.serial_number[0]) {
                        $formContentField = $(e.currentTarget).find('.form-content__error[field-name="serial_number"]').closest('.form-content__field');
                        $formContentField.addClass('form-content__field_error');
                        $formContentField.find('.form-content__error').text(error.responseJSON.errors.serial_number[0]);
                    }
                }

                if (error.responseJSON.errors.type_device_id !== undefined) {
                    if (error.responseJSON.errors.type_device_id[0]) {
                        $formContentField = $(e.currentTarget).find('.form-content__error[field-name="type_device_id"]').closest('.form-content__field');
                        $formContentField.addClass('form-content__field_error');
                        $formContentField.find('.form-content__error').text(error.responseJSON.errors.type_device_id[0]);
                    }
                }

                if (error.responseJSON.errors.purchase_price !== undefined) {
                    if (error.responseJSON.errors.purchase_price[0]) {
                        $formContentField = $(e.currentTarget).find('.form-content__error[field-name="purchase_price"]').closest('.form-content__field');
                        $formContentField.addClass('form-content__field_error');
                        $formContentField.find('.form-content__error').text(error.responseJSON.errors.purchase_price[0]);
                    }
                }

                if (error.responseJSON.errors.warranty !== undefined) {
                    if (error.responseJSON.errors.warranty[0]) {
                        $formContentField = $(e.currentTarget).find('.form-content__error[field-name="warranty"]').closest('.form-content__field');
                        $formContentField.addClass('form-content__field_error');
                        $formContentField.find('.form-content__error').text(error.responseJSON.errors.warranty[0]);
                    }
                }

                if (error.responseJSON.errors.receipt_date !== undefined) {
                    if (error.responseJSON.errors.receipt_date[0]) {
                        $formContentField = $(e.currentTarget).find('.form-content__error[field-name="receipt_date"]').closest('.form-content__field');
                        $formContentField.addClass('form-content__field_error');
                        $formContentField.find('.form-content__error').text(error.responseJSON.errors.receipt_date[0]);
                    }
                }
            },
        });

        return false;
    });
});