$(document).ready(() => {
    class adminWorkPlacesTabContentController extends window.tabContentController{
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

            // Обнуляем сообщения об ошибках валидации у выпадающих списков
            this.controllerElement.find('.form-content__select').on('input', (e) => {
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
                this.writeMultiAttachModalWindow(this.controllerElement, $(e.currentTarget), '/admin/write-attach-component-parts-modal-window');
            });

            this.controllerElement.find('.multi-attach-modal-window .action-btn').click((e) => {
                this.multiAttach(this.controllerElement, '/admin/attach-component-parts-to-work-place', '/admin/tab/work-places');
            });
        }
    }

    new adminWorkPlacesTabContentController($('.admin-work-places-tab-content-controller'));
});