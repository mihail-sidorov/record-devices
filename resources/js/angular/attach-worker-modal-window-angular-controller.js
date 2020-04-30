window.devicesApp.controller('attachWorkerModalWindowAngularController', ($scope, $http) => {
    window.attachWorkerModalWindowAngularControllerScope = $scope;

    window.attachWorkerModalWindowAngularControllerScope.workers = [];

    $('.attach-worker-modal-window__search-input').on('input', (e) => {
        var inputText = $(e.currentTarget).val().toLowerCase().replace('ё', 'е');
        
        if (inputText !== '') {
            window.attachWorkerModalWindowAngularControllerScope.workers = [];
            window.workers.forEach(function(worker){
                var name = worker.name.toLowerCase().replace('ё', 'е');

                if (name.match(inputText)) {
                    window.attachWorkerModalWindowAngularControllerScope.workers.push(worker);
                }
            });
        }
        else {
            window.attachWorkerModalWindowAngularControllerScope.workers = window.workers;
        }

        window.attachWorkerModalWindowAngularControllerScope.$apply();
    });
});