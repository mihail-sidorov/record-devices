$(document).ready(() => {
    class adminComponentPartsTabContentController extends window.tabContentController {
        constructor($controllerElement) {
            super($controllerElement);

            // Открываем модальное окно добавления комплектующего
            this.controllerElement.find('.add-btn').click((e) => {
                this.showModalWindow(this.controllerElement.find('.add-component-part-modal-window'));
            });

            // Валидация и добавление комплектующего
            this.controllerElement.find('.add-component-part-modal-window .form-content').on('submit', (e) => {
                this.addEntity($(e.currentTarget), '/admin/add-component-part', '/admin/tab/component-parts');
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

            // Заполняем данными модальное окно для редактирования комплектующего и открываем его
            this.controllerElement.find('.edit-btn').click((e) => {
                this.writeEditEntityModalWindow($(e.currentTarget), '/admin/write-edit-component-part-form', this.controllerElement.find('.edit-component-part-modal-window'));
                this.showModalWindow(this.controllerElement.find('.edit-component-part-modal-window'));
            });

            // Валидация и редактирование комплектующего
            this.controllerElement.find('.edit-component-part-modal-window .form-content').on('submit', (e) => {
                this.editEntity($(e.currentTarget), '/admin/edit-component-part', '/admin/tab/component-parts');
                return false;
            });

            // Удаляем комплектующее
            this.controllerElement.find('.del-btn').click((e) => {
                this.delEntity($(e.currentTarget), '/admin/del-component-part', '/admin/tab/component-parts', 'комплектующее');
            });
        }
    }

    new adminComponentPartsTabContentController($('.admin-component-parts-tab-content-controller'));
});