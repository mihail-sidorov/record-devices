$(document).ready(() => {
    $('.tab-content-wrapper__list-item-name').click((e) => {
        $(e.currentTarget).toggleClass('tab-content-wrapper__list-item-name_show');
        $(e.currentTarget).closest('.tab-content-wrapper__list-item').find('.tab-content-wrapper__list-item-body').slideToggle();
    });
});