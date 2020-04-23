$(document).ready(() => {
    $('.tab-content-wrapper').on('click', '.tab-content-wrapper__list-item-name', (e) => {
        $(e.currentTarget).toggleClass('tab-content-wrapper__list-item-name_show');
        $(e.currentTarget).closest('.tab-content-wrapper__list-item').children('.tab-content-wrapper__list-item-body').slideToggle();
    });
});