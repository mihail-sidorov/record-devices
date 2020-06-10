$(document).ready(() => {
    class adminDevicesTabContentController extends window.tabContentController {
        constructor($controllerElement) {
            super($controllerElement);

            // Открываем модальное окно добавления устройства
            this.controllerElement.find('.add-btn').click((e) => {
                this.showModalWindow(this.controllerElement.find('.add-device-modal-window'));
            });

            // Валидация и добавление устройства
            this.controllerElement.find('.add-device-modal-window .form-content').on('submit', (e) => {
                this.addEntity($(e.currentTarget), '/admin/add-device', '/admin/tab/devices');
                return false;
            });

            // Заполняем данными модальное окно для редактирования устройства и открываем его
            this.controllerElement.find('.edit-btn').click((e) => {
                this.writeEditEntityModalWindow($(e.currentTarget), '/admin/write-edit-device-form', this.controllerElement.find('.edit-device-modal-window'));
                this.showModalWindow(this.controllerElement.find('.edit-device-modal-window'));
            });

            // Валидация и редактирование устройства
            this.controllerElement.find('.edit-device-modal-window .form-content').on('submit', (e) => {
                this.editEntity($(e.currentTarget), '/admin/edit-device', '/admin/tab/devices');
                return false;
            });

            // Открываем модальное окно для прикрепления к устройству сотрудника и обнуляем в нем сообщения об ошибках валидации
            this.controllerElement.find('.attach-worker-btn').click((e) => {
                this.writeAttachWorkerModalWindow(this.controllerElement, $(e.currentTarget), '/admin/get-free-workers-to-device', window.attachWorkerToDeviceAngularControllerScope);
            });

            // Валидация и прикрепление сотрудника к устройству
            this.controllerElement.find('.attach-worker-modal-window .form-content').on('submit', (e) => {
                this.attachWorker($(e.currentTarget), '/admin/attach-worker-to-device', '/admin/tab/devices');
                return false;
            });

            // Открепление сотрудника от устройства
            this.controllerElement.find('.unattach-worker-btn').click((e) => {
                this.unattachWorker($(e.currentTarget), '/admin/unattach-worker-from-device', '/admin/tab/devices');
            });

            // Удаление устройства
            this.controllerElement.find('.del-btn').click((e) => {
                this.delEntity($(e.currentTarget), '/admin/del-device', '/admin/tab/devices', 'устройство');
            });
        }
    }

    new adminDevicesTabContentController($('.admin-devices-tab-content-controller'));
});