$(document).ready(() => {
    class adminWorkersTabContentController extends window.tabContentController {
        constructor($controllerElement) {
            super($controllerElement);

            // Открываем модальное окно добавления сотрудника
            this.controllerElement.find('.add-btn').click((e) => {
                this.showModalWindow(this.controllerElement.find('.add-worker-modal-window'));
            });

            // Валидация и добавление сотрудника
            this.controllerElement.find('.add-worker-modal-window .form-content').on('submit', (e) => {
                this.addEntity($(e.currentTarget), '/admin/add-worker', '/admin/tab/workers');
                return false;
            });

            // Заполняем данными модальное окно для редактирования сотрудника и открываем его
            this.controllerElement.find('.edit-worker-btn .edit-btn').click((e) => {
                this.writeEditEntityModalWindow($(e.currentTarget), '/admin/write-edit-worker-form', this.controllerElement.find('.edit-worker-modal-window'));
                this.showModalWindow(this.controllerElement.find('.edit-worker-modal-window'));
            });

            // Валидация и редактирование сотрудника
            this.controllerElement.find('.edit-worker-modal-window .form-content').on('submit', (e) => {
                this.editEntity($(e.currentTarget), '/admin/edit-worker', '/admin/tab/workers');
                return false;
            });

            // Заполняем данными и открываем модальное окно прикрепления устройств
            this.controllerElement.find('.attach-devices-btn').click((e) => {
                this.writeMultiAttachModalWindow($(e.currentTarget), '/admin/write-attach-devices-modal-window', this.controllerElement.find('.attach-devices-modal-window'));
            });

            // Прикрепляем к сотруднику устройства
            this.controllerElement.find('.attach-devices-modal-window .action-btn').click((e) => {
                this.multiAttach('/admin/attach-devices-to-worker', '/admin/tab/workers', this.controllerElement.find('.attach-devices-modal-window'));
            });

            // Удаляем сотрудника
            this.controllerElement.find('.del-btn').click((e) => {
                this.delEntity($(e.currentTarget), '/admin/del-worker', '/admin/tab/workers', 'сотрудника');
            });

            // Заполняем модальное окно прикрепления комплектующих и открываем его
            this.controllerElement.find('.attach-component-parts-btn').click((e) => {
                this.writeMultiAttachModalWindow($(e.currentTarget), '/admin/write-attach-component-parts-modal-window', this.controllerElement.find('.attach-component-parts-modal-window'));
            });

            // Прикрепляем к рабочему месту комплектующие
            this.controllerElement.find('.attach-component-parts-modal-window .action-btn').click((e) => {
                this.multiAttach('/admin/attach-component-parts-to-work-place', '/admin/tab/workers', this.controllerElement.find('.attach-component-parts-modal-window'));
            });

            // Открепление сотрудника от рабочего места
            this.controllerElement.find('.unattach-worker-from-work-place-btn .unattach-worker-btn').click((e) => {
                this.unattachWorker($(e.currentTarget), '/admin/unattach-worker-from-work-place', '/admin/tab/workers');
            });

            // Заполняем данными модальное окно для редактирования рабочего места и открываем его
            this.controllerElement.find('.edit-work-place-btn .edit-btn').click((e) => {
                this.writeEditEntityModalWindow($(e.currentTarget), '/admin/write-edit-work-place-form', this.controllerElement.find('.edit-work-place-modal-window'));
                this.showModalWindow(this.controllerElement.find('.edit-work-place-modal-window'));
            });

            // Валидация и редактирование рабочего места
            this.controllerElement.find('.edit-work-place-modal-window .form-content').on('submit', (e) => {
                this.editEntity($(e.currentTarget), '/admin/edit-work-place', '/admin/tab/workers');
                return false;
            });

            // Заполняем данными модальное окно для редактирования устройства и открываем его
            this.controllerElement.find('.edit-device-btn .edit-btn').click((e) => {
                this.writeEditEntityModalWindow($(e.currentTarget), '/admin/write-edit-device-form', this.controllerElement.find('.edit-device-modal-window'));
                this.showModalWindow(this.controllerElement.find('.edit-device-modal-window'));
            });

            // Валидация и редактирование устройства
            this.controllerElement.find('.edit-device-modal-window .form-content').on('submit', (e) => {
                this.editEntity($(e.currentTarget), '/admin/edit-device', '/admin/tab/workers');
                return false;
            });

            // Открепление сотрудника от устройства
            this.controllerElement.find('.unattach-worker-from-device-btn .unattach-worker-btn').click((e) => {
                this.unattachWorker($(e.currentTarget), '/admin/unattach-worker-from-device', '/admin/tab/workers');
            });

            // Заполняем данными модальное окно для редактирования комплектующего и открываем его
            this.controllerElement.find('.edit-component-part-btn .edit-btn').click((e) => {
                this.writeEditEntityModalWindow($(e.currentTarget), '/admin/write-edit-component-part-form', this.controllerElement.find('.edit-component-part-modal-window'));
                this.showModalWindow(this.controllerElement.find('.edit-component-part-modal-window'));
            });

            // Валидация и редактирование комплектующего
            this.controllerElement.find('.edit-component-part-modal-window .form-content').on('submit', (e) => {
                this.editEntity($(e.currentTarget), '/admin/edit-component-part', '/admin/tab/workers');
                return false;
            });

            // Открываем модальное окно редактирования пароля
            this.controllerElement.find('.change-password-btn').click((e) => {
                $changePasswordModalWindow = this.controllerElement.find('.change-password-modal-window');
                $changePasswordModalWindow.find('.form-content [name="id"]').val($(e.currentTarget).closest('.tab-content-wrapper__list-item').attr('id'));
                this.showModalWindow($changePasswordModalWindow);
            });

            // Валидация и редактирование пароля
            this.controllerElement.find('.change-password-modal-window .form-content').on('submit', (e) => {
                this.editEntity($(e.currentTarget), '/admin/change-password', '/admin/tab/workers');
                return false;
            });

            // Открываем модальное окно создания акта
            this.controllerElement.find('.create-act-btn').click((e) => {
                $createActModalWindow = this.controllerElement.find('.create-act-modal-window');
                $createActModalWindow.find('.form-content [name="id"]').val($(e.currentTarget).closest('.tab-content-wrapper__list-item').attr('id'));
                this.showModalWindow($createActModalWindow);
            });

            // Создаем новый акт
            this.controllerElement.find('.create-act-modal-window .form-content').on('submit', (e) => {
                this.createAct($(e.currentTarget), '/admin/create-act', '/admin/tab/acts');
            });
        }
    }

    new adminWorkersTabContentController($('.admin-workers-tab-content-controller'));
});