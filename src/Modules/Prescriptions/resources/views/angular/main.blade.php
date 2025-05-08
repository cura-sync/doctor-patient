<script>
    app.controller('MainController', ['GenericDataService', 'messageservice', '$scope', '$http', '$sce', function (GenericDataService, messageservice, $scope, $http, $sce) {
        var vm = this;
        vm.scope = $scope;

        // Define the variables
        vm.isUserLoggedIn = <?php echo json_encode($isUserLoggedIn); ?>;
        vm.document = null;
        vm.scope.loading = false;
        vm.error = null;
        vm.document_translation = '';
        vm.document_medicine = '';
        vm.saltAnalysis = false;
        vm.showMedicineProfile = false;
        vm.showLoginModal = false;
        vm.gridData = [];
        vm.pagination = {
            currentPage: 1,
            perPage: 10,
            total: 0,
            lastPage: 1
        };

        // Handle file change
        vm.onFileChange = function(event) {
            var file = event.target.files[0];
            if (file) {
                // Update to only accept PNG and JPEG files
                if (file.type !== 'image/jpeg' && file.type !== 'image/png' && file.type !== 'image/jpg') {
                    messageservice.putError('Please select a valid image to upload.');
                    return;
                }
                vm.document = file;
                vm.scope.$apply();
            }
        };

        vm.clearDocument = function() {
            vm.document = null;
        };

        // Translate document
        vm.translateDocument = function() {
            if (!vm.document) {
                messageservice.putError('Please select a document to upload.');
                return;
            }
            vm.scope.loading = true;

            // Create a FileReader to read the file as a base64 string
            var reader = new FileReader();
            reader.onload = function(event) {
                var base64String = event.target.result.split(',')[1]; // Get the base64 string

                // Prepare the payload with the base64 encoded document
                    var vo = {
                        'document': base64String,
                        'document_name': vm.document.name,
                        'document_type': vm.document.type,
                        'salt_analysis': vm.saltAnalysis
                    };

                return GenericDataService.jx('/prescriptions/translate', vo) // Send the payload
                    .then(function(response) {
                        vm.successMessage = response.data.success;
                        vm.document_name = response.data.data.document_name;
                        vm.document_translation = response.data.data.document_translation;
                        vm.document_medicine = response.data.data.document_medicine;
                        messageservice.putSuccess(vm.successMessage);
                        vm.scope.loading = false;
                        window.location.href = '/prescriptions/view/' + response.data.data.transaction_id;
                    }).catch(function(error) {
                        vm.error = error.data.message;
                        messageservice.putError(vm.error);
                        vm.scope.loading = false;
                    });
            };

            reader.onerror = function(error) {
                console.error('Error reading file:', error);
                vm.error = 'An error occurred while reading the document.';
                vm.scope.loading = false;
            };

            reader.readAsDataURL(vm.document); // Read the file as a data URL
        };

        vm.resetTranslation = function() {
            vm.document = null;
            vm.document_translation = '';
            vm.scope.$apply();
        };

        // Function to render markdown
        vm.renderMarkdown = function(markdown) {
            var html = marked(markdown); // Convert markdown to HTML
            return $sce.trustAsHtml(html); // Trust the HTML for rendering
        };

        // Function to copy text to clipboard
        vm.copyToClipboard = function() {
            var text = '';
            
            if (vm.showMedicineProfile) {
                text = vm.document_medicine;
            } else {
                text = vm.document_translation;
            }

            navigator.clipboard.writeText(text).then(function() {
                messageservice.putSuccess('Text copied to clipboard!');
            }, function(err) {
                messageservice.putError('Failed to copy text.');
            });
        };

        vm.downloadTranslation = function() {
            var text = '';

            if (vm.showMedicineProfile) {
                text = vm.document_medicine;
            } else {
                text = vm.document_translation;
            }

            var doc = new window.jspdf.jsPDF();
            var textContent = text.replace(/[#*]/g, ''); // Strip markdown symbols if needed
            var pageWidth = doc.internal.pageSize.getWidth() - 20; // 10 margin on each side
            var splitText = doc.splitTextToSize(textContent, pageWidth);
            doc.text(splitText, 10, 10);
            var filename = 'translation_' + new Date().toISOString().slice(0, 10) + '.pdf';
            doc.save(filename);
        };

        // New function to toggle the visibility of the medicine profile
        vm.toggleMedicineProfile = function() {
            vm.showMedicineProfile = !vm.showMedicineProfile; // Toggle the visibility
        };

        // Function to close the login modal
        vm.closeLoginModal = function() {
            vm.showLoginModal = false; // Hide the modal
        };

        vm.fetchGridData = function(page = 1) {
            vm.scope.loading = true;
            vm.pagination.currentPage = page;
            return GenericDataService.jx('/prescriptions/jxfetchData', {
                page: vm.pagination.currentPage,
                per_page: vm.pagination.perPage
            })
            .then(function(response) {
                vm.gridData = response.data.data;
                if (response.data.pagination) {
                    vm.pagination = {
                        total: response.data.pagination.total,
                        perPage: response.data.pagination.per_page,
                        currentPage: response.data.pagination.current_page,
                        lastPage: response.data.pagination.last_page,
                        from: response.data.pagination.from,
                        to: response.data.pagination.to
                    };
                }
                vm.scope.loading = false;
            }).catch(function(error) {
                vm.error = error.data.message;
                messageservice.putError(vm.error);
                vm.scope.loading = false;
            });
        };

        vm.changePage = function(page) {
            if (page >= 1 && page <= vm.pagination.lastPage) {
                vm.fetchGridData(page);
            }
        };

        vm.fetchGridData();

        // Add event listener for file input click
        document.getElementById('fileInput').addEventListener('click', function(event) {
            if (!vm.isUserLoggedIn) { // If user is not logged in
                event.preventDefault(); // Prevent the file input from opening
                console.log('User is not logged in');
                vm.showLoginModal = true; // Show the modal
                vm.scope.$apply();
                return;
            }
        });
    }]);
</script>