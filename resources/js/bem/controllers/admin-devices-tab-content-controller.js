// admin-devices-tab-content-controller

$(document).ready(() => {
    $('.admin-devices-tab-content-controller').find('.add-btn').click((e) => {
        $(e.currentTarget).closest('.admin-devices-tab-content-controller').find('.modal-window').addClass('modal-window_show');
    });
});