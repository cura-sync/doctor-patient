app.controller('loadController',function($scope){
    var vm = this;
    vm.variable = 'Loading...';
    $scope.loading = false;
  });
  
  app.directive('loading', function(){
    return {
      restrict: 'E',
      templateUrl: '/js/loader/loader.html',
      link: function (scope, element, attr){
        scope.$watch('loading', function(val){
          if (val) {
            $(element).show();
          }
          else {
            $(element).hide();
          }
        });
      }
    };
  });
  