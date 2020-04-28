$(document).ready(() => {
    $('.attach-component-parts-modal-window').each((index, element) => {
        var observer = new MutationObserver((res) => {
            var self = res[0].target, token = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                type: 'POST',
                url: '/admin/write-attach-component-parts-modal-window',
                data: {
                    _token: token,
                    device_id: $(self).attr('device-id'),
                },
                dataType: 'json',
                success: (response) => {
                    $categories = $(self).find('.attach-component-parts-modal-window__categories');
                    $categories.html('');
                    response.forEach((item) => {
                        var componentParts = '', checkedArr = item.checked;
                        item.component_parts.forEach((item, index) => {
                            var checked = '';
                            if (checkedArr[index]) {
                                checked = ' checked';
                            }

                            var componentPart = `
                                <label class="attach-component-parts-modal-window__component-part"><input type="checkbox"${checked} name="component_part${item.id}">${item.name}</label>`;
                            componentParts += componentPart;
                        });
                        var category = `
                            <div class="attach-component-parts-modal-window__category" id="${item.category.id}">
                                <div class="attach-component-parts-modal-window__category-head">${item.category.name}</div>
                                <div class="attach-component-parts-modal-window__category-body"><div class="attach-component-parts-modal-window__component-parts">${componentParts}</div></div>
                            </div>
                        `;
                        $categories.append(category);
                    });

                    $categories.find('.attach-component-parts-modal-window__category-head').click((e) => {
                        $(e.currentTarget).toggleClass('attach-component-parts-modal-window__category-head_show');
                        $(e.currentTarget).closest('.attach-component-parts-modal-window__category').find('.attach-component-parts-modal-window__category-body').slideToggle();
                    });

                    $(self).addClass('modal-window_show');
                },
            });
        });
        observer.observe(element, {attributes: true, attributeFilter: ['loading']});
    });
});