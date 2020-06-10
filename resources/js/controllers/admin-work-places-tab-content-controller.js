$(document).ready(() => {
    class adminWorkPlacesTabContentController extends window.tabContentController {
        constructor($controllerElement) {
            super($controllerElement);

            // Открываем модальное окно добавления рабочего места
            this.controllerElement.find('.add-btn').click((e) => {
                this.showModalWindow(this.controllerElement.find('.add-work-place-modal-window'));
            });

            // Валидация и добавление рабочего места
            this.controllerElement.find('.add-work-place-modal-window .form-content').on('submit', (e) => {
                this.addEntity($(e.currentTarget), '/admin/add-work-place', '/admin/tab/work-places');
                return false;
            });

            // Обнуляем сообщения об ошибках валидации у текстовых полей
            this.controllerElement.find('.form-content__text').on('input', (e) => {
                this.clearValidateErrors($(e.currentTarget));
            });

            // Обнуляем сообщения об ошибках валидации у дат и выпадающих списков
            this.controllerElement.find('.form-content__select, .form-content__date').on('input', (e) => {
                this.clearValidateErrors($(e.currentTarget));
            });

            // Заполняем данными модальное окно для редактирования рабочего места и открываем его
            this.controllerElement.find('.edit-work-place-btn .edit-btn').click((e) => {
                this.writeEditEntityModalWindow($(e.currentTarget), '/admin/write-edit-work-place-form', this.controllerElement.find('.edit-work-place-modal-window'));
                this.showModalWindow(this.controllerElement.find('.edit-work-place-modal-window'));
            });

            // Валидация и редактирование рабочего места
            this.controllerElement.find('.edit-work-place-modal-window .form-content').on('submit', (e) => {
                this.editEntity($(e.currentTarget), '/admin/edit-work-place', '/admin/tab/work-places');
                return false;
            });

            // Заполняем модальное окно прикрепления комплектующих и открываем его
            this.controllerElement.find('.attach-component-parts-btn').click((e) => {
                this.writeMultiAttachModalWindow($(e.currentTarget), '/admin/write-attach-component-parts-modal-window', this.controllerElement.find('.attach-component-parts-modal-window'));
            });

            // Прикрепляем к рабочему месту комплектующие
            this.controllerElement.find('.attach-component-parts-modal-window .action-btn').click((e) => {
                this.multiAttach('/admin/attach-component-parts-to-work-place', '/admin/tab/work-places', this.controllerElement.find('.attach-component-parts-modal-window'));
            });
            
            // Заполняем и открываем модальное окно прикрепления сотрудника к рабочему месту
            this.controllerElement.find('.attach-worker-btn').click((e) => {
                this.writeAttachWorkerModalWindow(this.controllerElement, $(e.currentTarget), '/admin/get-free-workers-to-work-place', window.attachWorkerToWorkPlaceAngularControllerScope);
            });

            // Валидация и прикрепление сотрудника к устройству
            this.controllerElement.find('.attach-worker-modal-window .form-content').on('submit', (e) => {
                this.attachWorker($(e.currentTarget), '/admin/attach-worker-to-work-place', '/admin/tab/work-places');
                return false;
            })

            // Открепляем сотрудника от рабочего места
            this.controllerElement.find('.unattach-worker-btn').click((e) => {
                this.unattachWorker($(e.currentTarget), '/admin/unattach-worker-from-work-place', '/admin/tab/work-places');
            });

            // Удаляем рабочее место
            this.controllerElement.find('.del-btn').click((e) => {
                this.delEntity($(e.currentTarget), '/admin/del-work-place', '/admin/tab/work-places', 'рабочее место');
            });

            // Заполняем данными модальное окно для редактирования комплектующего и открываем его
            this.controllerElement.find('.edit-component-part-btn .edit-btn').click((e) => {
                this.writeEditEntityModalWindow($(e.currentTarget), '/admin/write-edit-component-part-form', this.controllerElement.find('.edit-component-part-modal-window'));
                this.showModalWindow(this.controllerElement.find('.edit-component-part-modal-window'));
            });

            // Валидация и редактирование комплектующего
            this.controllerElement.find('.edit-component-part-modal-window .form-content').on('submit', (e) => {
                this.editEntity($(e.currentTarget), '/admin/edit-component-part', '/admin/tab/work-places');
                return false;
            });
        }
    }

    new adminWorkPlacesTabContentController($('.admin-work-places-tab-content-controller'));
});