$(document).ready(() => {
    class adminResponsiblesTabContentController extends window.tabContentController {
        constructor($controllerElement) {
            super($controllerElement);

            // Открываем модальное окно добавления ответственного
            this.controllerElement.find('.add-btn').click((e) => {
                this.showModalWindow(this.controllerElement.find('.add-responsible-modal-window'));
            });

            // Валидация и добавление ответственного
            this.controllerElement.find('.add-responsible-modal-window .form-content').on('submit', (e) => {
                this.addEntity($(e.currentTarget), '/admin/add-responsible', '/admin/tab/responsibles');
                return false;
            });

            // Заполняем данными модальное окно для редактирования ответственного и открываем его
            this.controllerElement.find('.edit-btn').click((e) => {
                this.writeEditEntityModalWindow($(e.currentTarget), '/admin/write-edit-responsible-form', this.controllerElement.find('.edit-responsible-modal-window'));
                this.showModalWindow(this.controllerElement.find('.edit-responsible-modal-window'));
            });

            // Валидация и редактирование ответственного
            this.controllerElement.find('.edit-responsible-modal-window .form-content').on('submit', (e) => {
                this.editEntity($(e.currentTarget), '/admin/edit-responsible', '/admin/tab/responsibles');
                return false;
            });

            // Удаляем ответственного
            this.controllerElement.find('.del-btn').click((e) => {
                this.delEntity($(e.currentTarget), '/admin/del-responsible', '/admin/tab/responsibles', 'ответственного');
            });
        }
    }

    new adminResponsiblesTabContentController($('.admin-responsibles-tab-content-controller'));
});