<script>
    app.controller('MainController', ['GenericDataService', 'messageservice', '$scope', '$http', '$sce', function (GenericDataService, messageservice, $scope, $http, $sce) {
        var vm = this;
        vm.scope = $scope;
        vm.scope.loading = false;
        console.log('Bills module loaded');
        
    }]);
</script>
