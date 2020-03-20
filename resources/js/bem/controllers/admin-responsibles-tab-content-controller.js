// admin-responsibles-tab-content-controller

$(document).ready(() => {
    $('.admin-responsibles-tab-content-controller').find('.add-btn').click((e) => {
        $(e.currentTarget).closest('.admin-responsibles-tab-content-controller').find('.modal-window').addClass('modal-window_show');
    });
});