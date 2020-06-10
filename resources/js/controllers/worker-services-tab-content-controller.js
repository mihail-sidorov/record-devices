$(document).ready(() => {
    class workerServicesTabContentController extends window.tabContentController {
        constructor($controllerElement) {
            super($controllerElement);

            // Открываем модальное окно добавления сервиса
            this.controllerElement.find('.add-btn').click((e) => {
                this.showModalWindow(this.controllerElement.find('.add-service-modal-window'));
            });

            // Валидация и добавление сервиса
            this.controllerElement.find('.add-service-modal-window .form-content').on('submit', (e) => {
                this.addEntity($(e.currentTarget), '/worker/add-service', '/worker/tab/services');
                return false;
            });

            // Заполняем данными модальное окно для редактирования сервиса и открываем его
            this.controllerElement.find('.edit-btn').click((e) => {
                this.writeEditEntityModalWindow($(e.currentTarget), '/worker/write-edit-service-form', this.controllerElement.find('.edit-service-modal-window'));
                this.showModalWindow(this.controllerElement.find('.edit-service-modal-window'));
            });

            // Валидация и редактирование сервиса
            this.controllerElement.find('.edit-service-modal-window .form-content').on('submit', (e) => {
                this.editEntity($(e.currentTarget), '/worker/edit-service', '/worker/tab/services');
                return false;
            });

            // Удаляем сервис
            this.controllerElement.find('.del-btn').click((e) => {
                this.delEntity($(e.currentTarget), '/worker/del-service', '/worker/tab/services', 'сервис');
            });
        }
    }

    new workerServicesTabContentController($('.worker-services-tab-content-controller'));
});