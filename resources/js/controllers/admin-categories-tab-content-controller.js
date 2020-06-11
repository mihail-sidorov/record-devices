$(document).ready(() => {
    class adminCategoriesTabContentController extends window.tabContentController {
        constructor($controllerElement) {
            super($controllerElement);

            // Открываем модальное окно добавления категории
            this.controllerElement.find('.add-btn').click((e) => {
                this.showModalWindow(this.controllerElement.find('.add-category-modal-window'));
            });

            // Валидация и добавление категории
            this.controllerElement.find('.add-category-modal-window .form-content').on('submit', (e) => {
                this.addEntity($(e.currentTarget), '/admin/add-category', '/admin/tab/categories');
                return false;
            });

            // Заполняем данными модальное окно для редактирования категории и открываем его
            this.controllerElement.find('.edit-btn').click((e) => {
                this.writeEditEntityModalWindow($(e.currentTarget), '/admin/write-edit-category-form', this.controllerElement.find('.edit-category-modal-window'));
                this.showModalWindow(this.controllerElement.find('.edit-category-modal-window'));
            });

            // Валидация и редактирование категории
            this.controllerElement.find('.edit-category-modal-window .form-content').on('submit', (e) => {
                this.editEntity($(e.currentTarget), '/admin/edit-category', '/admin/tab/categories');
                return false;
            });

            // Удаляем категорию
            this.controllerElement.find('.del-btn').click((e) => {
                this.delEntity($(e.currentTarget), '/admin/del-category', '/admin/tab/categories', 'категорию');
            });
        }
    }

    new adminCategoriesTabContentController($('.admin-categories-tab-content-controller'));
});