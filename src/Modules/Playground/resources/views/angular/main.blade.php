<script>
    app.controller('MainController', ['GenericDataService', 'messageservice', '$scope', '$http', '$sce', function (GenericDataService, messageservice, $scope, $http, $sce) {
        var vm = this;
        vm.scope = $scope;
        vm.scope.loading = false;
        vm.googleCalendarConnected = {{ $googleCalendarConnectionStatus }};
        vm.googleCalendarConnectionStatus = {{ $googleCalendarConnectionStatus }};
        console.log(vm.googleCalendarConnected);
        console.log(vm.googleCalendarConnectionStatus);
        vm.toggleGoogleConnection = function() {
            vo = {
                'googleCalendarConnectionStatus': vm.googleCalendarConnectionStatus
            }
            vm.scope.loading = true;
            GenericDataService.jx('/user/jxToggleGoogleConnection', vo)
                .then(function(response) {
                    vm.scope.loading = false;
                    if (response.data.error) {
                        messageservice.putError(response.data.message);
                    } else {
                        messageservice.putSuccess(response.data.message);
                    }
                })
        }
    }]);
</script>