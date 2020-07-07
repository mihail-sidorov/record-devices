$(document).ready(() => {
    class phoneMaskController {
        constructor($phones) {
            $phones.mask("+7(999)999-99-99", {autoclear: false});
        }
    }

    new phoneMaskController($('.admin-workers-tab-content-controller .form-content__field input[name="phone"]'));
});