$(document).ready(() => {
    class adminDepartmentsTabContentController extends window.tabContentController {
        constructor($controllerElement) {
            super($controllerElement);

            // Открываем модальное окно добавления отдела
            this.controllerElement.find('.add-btn').click((e) => {
                this.showModalWindow(this.controllerElement.find('.add-department-modal-window'));
            });

            // Валидация и добавление отдела
            this.controllerElement.find('.add-department-modal-window .form-content').on('submit', (e) => {
                this.addEntity($(e.currentTarget), '/admin/add-department', '/admin/tab/departments');
                return false;
            });

            // Заполняем данными модальное окно для редактирования отдела и открываем его
            this.controllerElement.find('.edit-btn').click((e) => {
                this.writeEditEntityModalWindow($(e.currentTarget), '/admin/write-edit-department-form', this.controllerElement.find('.edit-department-modal-window'));
                this.showModalWindow(this.controllerElement.find('.edit-department-modal-window'));
            });

            // Валидация и редактирование отдела
            this.controllerElement.find('.edit-department-modal-window .form-content').on('submit', (e) => {
                this.editEntity($(e.currentTarget), '/admin/edit-department', '/admin/tab/departments');
                return false;
            });

            // Удаляем отдел
            this.controllerElement.find('.del-btn').click((e) => {
                this.delEntity($(e.currentTarget), '/admin/del-department', '/admin/tab/departments', 'отдел');
            });
        }
    }

    new adminDepartmentsTabContentController($('.admin-departments-tab-content-controller'));
});