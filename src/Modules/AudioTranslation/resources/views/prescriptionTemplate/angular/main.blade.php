<script>
    app.controller('MainController', ['GenericDataService', 'messageservice', '$scope', '$http', '$sce', function (GenericDataService, messageservice, $scope, $http, $sce) {
        var vm = this;
        vm.scope = $scope;

        vm.isUserLoggedIn = <?php echo json_encode($isUserLoggedIn); ?>;
        vm.scope.loading = false;
    }]);
</script>