$('.modal-window').each((index, element) => {
    var observer = new MutationObserver((res) => {
        var self = res[0].target;
        
        if ($(self).attr('class').indexOf('modal-window_show') + 1) {
            $(self).find('.modal-window__cover').stop().animate(
                {
                    opacity: '0.6'
                },
                {
                    duration: 300,
                    easing: 'easeInOut',
                    queue: false,
                    start: () => {
                        $(self).css('display', 'block');
                        $(self).css('width');
                        $(self).addClass('modal-window_animate');
                    },
                },
            );
        }
        else {
            $(self).find('.modal-window__cover').stop().animate(
                {
                    opacity: 0
                },
                {
                    duration: 300,
                    easing: 'easeInOut',
                    queue: false,
                    start: () => {
                        $(self).removeClass('modal-window_animate');
                    },
                    complete: () => {
                        $(self).css('display', 'none');
                    },
                }
            );
        }
    });
    observer.observe(element, {attributes: true, attributeFilter: ['class']});
});

$('.modal-window__wrapper').click((e) => {
    if (e.target === e.currentTarget) {
        $(e.currentTarget).parent().removeClass('modal-window_show');
    }
});

$('.modal-window__close').click((e) => {
    $(e.currentTarget).closest('.modal-window').removeClass('modal-window_show');
});