// admin-workers-tab-content-controller

$(document).ready(() => {
    $('.admin-workers-tab-content-controller').find('.add-btn').click((e) => {
        $(e.currentTarget).closest('.admin-workers-tab-content-controller').find('.modal-window').addClass('modal-window_show');
    });
});