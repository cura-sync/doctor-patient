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
        vm.activeTab = 'translated';
        vm.transaltion_file_name = null;
        vm.transaltion_processed_date = null;

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
                                vm.translationResponse = response.data.translation_response;
                                vm.transaltion_file_name = response.data.file_name;
                                vm.transaltion_processed_date = response.data.processed_date;
                                vm.toggleOriginalTranslatedText('translated');
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

        vm.toggleOriginalTranslatedText = function(type) {
            vm.activeTab = type;
            if (type === 'original') {
                document.getElementById('response-header').innerHTML = 'Original Transcription';
                document.getElementById('response-subheader').innerHTML = 'Original transcription of the audio file';
                document.getElementById('response-text').innerHTML = vm.translationResponse.original_text;
            } else {
                document.getElementById('response-header').innerHTML = 'Translated Text';
                document.getElementById('response-subheader').innerHTML = 'Translated text of the audio file';
                document.getElementById('response-text').innerHTML = vm.translationResponse.summary;
            }
        };
    }]);
</script>