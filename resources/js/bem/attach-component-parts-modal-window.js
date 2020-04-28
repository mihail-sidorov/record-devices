$(document).ready(() => {
    $('.attach-component-parts-modal-window').each((index, element) => {
        var observer = new MutationObserver((res) => {
            var self = res[0].target, token = $('meta[name="csrf-token"]').attr('content'), deviceId = $(self).attr('device-id');

            if (deviceId) {
                $.ajax({
                    type: 'POST',
                    url: '/admin/write-attach-component-parts-modal-window',
                    data: {
                        _token: token,
                        device_id: deviceId,
                    },
                    dataType: 'json',
                    success: (response) => {
                        $categories = $(self).find('.attach-component-parts-modal-window__categories');
                        $categories.html('');
                        response.forEach((item) => {
                            var componentParts = '', checkedArr = item.checked, openCategory = false, openCategoryHead, openCategoryBody;
                            item.component_parts.forEach((item, index) => {
                                var checked = '';
                                if (checkedArr[index]) {
                                    checked = ' checked';
                                    openCategory = true;
                                }
    
                                var componentPart = `
                                    <label class="attach-component-parts-modal-window__component-part"><input type="checkbox"${checked} name="component_part-${item.id}">${item.name}</label>`;
                                componentParts += componentPart;
                            });
    
                            if (openCategory) {
                                openCategoryHead = ' attach-component-parts-modal-window__category-head_show';
                                openCategoryBody = ' attach-component-parts-modal-window__category-body_show';
                            }
                            else {
                                openCategoryHead = '';
                                openCategoryBody = '';
                            }
    
                            var category = `
                                <div class="attach-component-parts-modal-window__category" id="${item.category.id}">
                                    <div class="attach-component-parts-modal-window__category-head${openCategoryHead}">${item.category.name}</div>
                                    <div class="attach-component-parts-modal-window__category-body${openCategoryBody}"><div class="attach-component-parts-modal-window__component-parts">${componentParts}</div></div>
                                </div>
                            `;
                            $categories.append(category);
                        });
    
                        $categories.find('.attach-component-parts-modal-window__category-head').click((e) => {
                            $(e.currentTarget).toggleClass('attach-component-parts-modal-window__category-head_show');
                            $(e.currentTarget).closest('.attach-component-parts-modal-window__category').find('.attach-component-parts-modal-window__category-body').slideToggle();
                        });
    
                        // Производим прикрепление\открепление комплектующих
                        $(self).find('.action-btn').off('click.attach-component-parts-modal-window');
                        $(self).find('.action-btn').on('click.attach-component-parts-modal-window', (e) => {
                            var componentParts = [], componentPartIds = [], componentPartCheckes = [];

                            $categories.find('.attach-component-parts-modal-window__component-part').each((index, element) => {
                                var $input = $(element).children('input');
                                componentPartIds.push($input.attr('name').split('-')[1]);
                                if ($input.prop('checked')) {
                                    componentPartCheckes.push(1);
                                }
                                else {
                                    componentPartCheckes.push(0);
                                }
                            });
                            componentParts.push(componentPartIds);
                            componentParts.push(componentPartCheckes);

                            $.ajax({
                                type: 'POST',
                                url: '/admin/attach-component-parts-to-device',
                                data: {
                                    _token: token,
                                    device_id: deviceId,
                                    component_parts: componentParts,
                                },
                                dataType: 'json',
                                success: () => {
                                    window.location.href = '/admin/tab/devices';
                                },
                            });
                        });
                        
                        $(self).addClass('modal-window_show');
                    },
                });
            }
        });
        observer.observe(element, {attributes: true, attributeFilter: ['loading']});
    });
});