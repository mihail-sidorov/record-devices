$(document).ready(() => {
    $('.attach-component-parts-modal-window__categories').on('click', '.attach-component-parts-modal-window__category-head', (e) => {
        $(e.currentTarget).toggleClass('attach-component-parts-modal-window__category-head_show');
        $(e.currentTarget).closest('.attach-component-parts-modal-window__category').find('.attach-component-parts-modal-window__category-body').slideToggle();
    });
});