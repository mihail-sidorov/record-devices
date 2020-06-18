$(document).ready(() => {
    class workerSettingsController extends window.tabContentController {
        constructor($controllerElement) {
            super($controllerElement);

            // Заполняем данными модальное окно для редактирования сотрудника и открываем его
            this.controllerElement.find('.edit-btn').click((e) => {
                this.writeEditEntityModalWindow($(e.currentTarget), '/admin/write-edit-worker-form', this.controllerElement.find('.edit-worker-modal-window'), $('.content.worker').attr('id'));
                this.showModalWindow(this.controllerElement.find('.edit-worker-modal-window'));
            });

            // Валидация и редактирование сотрудника
            this.controllerElement.find('.edit-worker-modal-window .form-content').on('submit', (e) => {
                this.editEntity($(e.currentTarget), '/admin/edit-worker', '/worker/tab/services');
                return false;
            });

            // Открываем модальное окно редактирования пароля
            this.controllerElement.find('.change-password-btn').click((e) => {
                $changePasswordModalWindow = this.controllerElement.find('.change-password-modal-window');
                $changePasswordModalWindow.find('.form-content [name="id"]').val($('.content.worker').attr('id'));
                this.showModalWindow($changePasswordModalWindow);
            });

            // Валидация и редактирование пароля
            this.controllerElement.find('.change-password-modal-window .form-content').on('submit', (e) => {
                this.editEntity($(e.currentTarget), '/admin/change-password', '/worker/tab/services');
                return false;
            });
        }
    }

    new workerSettingsController($('.worker-settings-controller'));
});