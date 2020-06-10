$(document).ready(() => {
    class adminProvidersTabContentController extends window.tabContentController {
        constructor($controllerElement) {
            super($controllerElement);

            // Открываем модальное окно добавления поставщика
            this.controllerElement.find('.add-btn').click((e) => {
                this.showModalWindow(this.controllerElement.find('.add-provider-modal-window'));
            });

            // Валидация и добавление поставщика
            this.controllerElement.find('.add-provider-modal-window .form-content').on('submit', (e) => {
                this.addEntity($(e.currentTarget), '/admin/add-provider', '/admin/tab/providers');
                return false;
            });

            // Заполняем данными модальное окно для редактирования поставщика и открываем его
            this.controllerElement.find('.edit-btn').click((e) => {
                this.writeEditEntityModalWindow($(e.currentTarget), '/admin/write-edit-provider-form', this.controllerElement.find('.edit-provider-modal-window'));
                this.showModalWindow(this.controllerElement.find('.edit-provider-modal-window'));
            });

            // Валидация и редактирование поставщика
            this.controllerElement.find('.edit-provider-modal-window .form-content').on('submit', (e) => {
                this.editEntity($(e.currentTarget), '/admin/edit-provider', '/admin/tab/providers');
                return false;
            });

            // Удаляем поставщика
            this.controllerElement.find('.del-btn').click((e) => {
                this.delEntity($(e.currentTarget), '/admin/del-provider', '/admin/tab/providers', 'поставщика');
            });
        }
    }

    new adminProvidersTabContentController($('.admin-providers-tab-content-controller'));
});