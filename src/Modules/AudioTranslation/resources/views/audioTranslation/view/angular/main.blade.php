<script>
    app.controller('MainController', ['$scope', '$http', '$sce', function ($scope, $http, $sce) {
        var vm = this;
        vm.scope = $scope;
        var rawData = @json($data);
        // Trust the text as HTML
        vm.data = {
            ...rawData,
            original_text: $sce.trustAsHtml(rawData.original_text || ''),
            simplified_text: $sce.trustAsHtml(rawData.simplified_text || '')
        };

        // Section toggling
        vm.activeSection = 'translated';
        vm.activeSidebar = 'translated';

        vm.showSection = function(section) {
            vm.activeSection = section;
            vm.activeSidebar = section;
        };

        vm.copyText = function(text) {
            if (!text) return;
            var textarea = document.createElement('textarea');
            // If text is trusted HTML, get the string value
            textarea.value = (typeof text === 'object' && text.toString) ? text.toString() : text;
            document.body.appendChild(textarea);
            textarea.select();
            document.execCommand('copy');
            document.body.removeChild(textarea);
        };

        vm.downloadPrescription = function() {
            // Implement download logic here if needed
        };
    }]);
</script>