<script>
    app.controller('MainController', ['GenericDataService', 'messageservice', '$scope', '$http', '$sce', function (GenericDataService, messageservice, $scope, $http, $sce) {
        var vm = this;
        vm.scope = $scope;

        vm.isUserLoggedIn = <?php echo json_encode($isUserLoggedIn); ?>;
        vm.prescriptionTemplates = [];
        vm.scope.loading = false;
        vm.audioFile = null;
        vm.selectedPrescriptionTemplate = null;
        vm.translationResponse = null;
        vm.transaltion_file_name = null;
        vm.transaltion_processed_date = null;
        vm.gridData = [];
        vm.pagination = {
            currentPage: 1,
            perPage: 10,
            total: 0,
            lastPage: 1
        };

        vm.onFileChange = function(event) {
            var file = event.target.files[0];
            if (file) {
                // Accept only mp3, wav, m4a files
                if (file.type !== 'audio/mp3' && file.type !== 'audio/wav' && file.type !== 'audio/m4a') {
                    messageservice.putError('Please select a valid audio file to upload.');
                    return;
                }
                vm.audioFile = file;
                vm.scope.$apply();
            }
        };

        vm.clearAudioFile = function() {
            vm.audioFile = null;
            vm.scope.$apply();
        };

        vm.transcribeAudio = function() {
            vm.scope.loading = true;
            return new Promise((resolve, reject) => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const base64Audio = e.target.result.split(',')[1];
                    const vo = {
                        'audio_file': base64Audio,
                        'audio_filename': vm.audioFile.name,
                        'audio_type': vm.audioFile.type,
                    };

                    GenericDataService.jx('/audioTranslation/jxProcessUploadedAudio', vo)
                        .then(function(response) {
                            vm.scope.loading = false;
                            if (response.data.success) {
                                messageservice.putSuccess('Audio transcribed successfully');
                                vm.translationResponse = response.data.data.translation_response;
                                vm.transaltion_file_name = response.data.data.file_name;
                                vm.transaltion_processed_date = response.data.data.processed_date;
                                window.location.href = '/audioTranslation/view/' + response.data.data.transaction_id;
                            } else {
                                messageservice.putError('Failed to transcribe audio');
                            }
                        })
                        .catch(reject);
                };
                reader.onerror = reject;
                reader.readAsDataURL(vm.audioFile);
            });
        }

        vm.fetchGridData = function(page = 1) {
            vm.scope.loading = true;
            vm.pagination.currentPage = page;
            return GenericDataService.jx('/audioTranslation/jxfetchData', {
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
        
    }]);
</script>