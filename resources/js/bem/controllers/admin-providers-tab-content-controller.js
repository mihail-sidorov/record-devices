// admin-providers-tab-content-controller

$(document).ready(() => {
    $('.admin-providers-tab-content-controller').find('.add-btn').click((e) => {
        $(e.currentTarget).closest('.admin-providers-tab-content-controller').find('.modal-window').addClass('modal-window_show');
    });
});