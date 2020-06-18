$(document).ready((e) => {
    $('.settings-block').each((index, element) => {
        $(element).find('.settings-block__main-btn').on('click', (e) => {
            $(e.currentTarget).toggleClass('settings-block__main-btn_open');
            $(e.currentTarget).closest('.settings-block').find('.settings-block__btns').slideToggle();
        });
    });
});