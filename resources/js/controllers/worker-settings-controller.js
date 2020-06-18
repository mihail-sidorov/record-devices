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
        }
    }

    new workerSettingsController($('.worker-settings-controller'));
});