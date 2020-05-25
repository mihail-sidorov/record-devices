$(document).ready(() => {
    $('.attach-devices-modal-window').each((index, element) => {
        var observer = new MutationObserver((res) => {
            var self = res[0].target, token = $('meta[name="csrf-token"]').attr('content'), workerId = $(self).attr('worker-id');

            if (workerId) {
                $.ajax({
                    type: 'POST',
                    url: '/admin/write-attach-devices-modal-window',
                    data: {
                        _token: token,
                        worker_id: workerId,
                    },
                    dataType: 'json',
                    success: (response) => {
                        $categories = $(self).find('.attach-devices-modal-window__categories');
                        $categories.html('');
                        response.forEach((item) => {
                            var devices = '', checkedArr = item.checked, openCategory = false, openCategoryHead, openCategoryBody;
                            item.devices.forEach((item, index) => {
                                var checked = '';
                                if (checkedArr[index]) {
                                    checked = ' checked';
                                    openCategory = true;
                                }
    
                                var device = `
                                    <label class="attach-devices-modal-window__device"><input type="checkbox"${checked} name="device-${item.id}">${item.name}</label>`;
                                    devices += device;
                            });
    
                            if (openCategory) {
                                openCategoryHead = ' attach-devices-modal-window__category-head_show';
                                openCategoryBody = ' attach-devices-modal-window__category-body_show';
                            }
                            else {
                                openCategoryHead = '';
                                openCategoryBody = '';
                            }
    
                            var category = `
                                <div class="attach-devices-modal-window__category" id="${item.category.id}">
                                    <div class="attach-devices-modal-window__category-head${openCategoryHead}">${item.category.name}</div>
                                    <div class="attach-devices-modal-window__category-body${openCategoryBody}"><div class="attach-devices-modal-window__devices">${devices}</div></div>
                                </div>
                            `;
                            $categories.append(category);
                        });
    
                        $categories.find('.attach-devices-modal-window__category-head').click((e) => {
                            $(e.currentTarget).toggleClass('attach-devices-modal-window__category-head_show');
                            $(e.currentTarget).closest('.attach-devices-modal-window__category').find('.attach-devices-modal-window__category-body').slideToggle();
                        });

                        // Производим прикрепление\открепление устройств
                        $(self).find('.action-btn').off('click.attach-devices-modal-window');
                        $(self).find('.action-btn').on('click.attach-devices-modal-window', (e) => {
                            var devices = [], deviceIds = [], deviceCheckes = [];

                            $categories.find('.attach-devices-modal-window__device').each((index, element) => {
                                var $input = $(element).children('input');
                                deviceIds.push($input.attr('name').split('-')[1]);
                                if ($input.prop('checked')) {
                                    deviceCheckes.push(1);
                                }
                                else {
                                    deviceCheckes.push(0);
                                }
                            });
                            devices.push(deviceIds);
                            devices.push(deviceCheckes);

                            $.ajax({
                                type: 'POST',
                                url: '/admin/attach-devices-to-worker',
                                data: {
                                    _token: token,
                                    worker_id: workerId,
                                    devices: devices,
                                },
                                dataType: 'json',
                                success: () => {
                                    window.location.href = '/admin/tab/workers';
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