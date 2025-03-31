<?php
use App\Models\Transactions;
?>

<script>
    app.controller('MainController', ['GenericDataService', 'messageservice', '$scope', '$http', '$sce', function (GenericDataService, messageservice, $scope, $http, $sce) {
        var vm = this;
        vm.scope = $scope;
        vm.scope.loading = false;
        vm.transactions = [];
        vm.document_name = '';
        vm.transaction_date = '';
        vm.transaction_type = '';
        vm.current_page = 1;
        vm.total_pages = 1;
        vm.total_data = [];
        vm.transactionTypes = <?php echo json_encode(Transactions::getResourceType()); ?>;
        vm.transactionStatuses = <?php echo json_encode(Transactions::getTransactionStatus()); ?>;
        vm.transaction_date_from = '';
        vm.transaction_date_to = '';
        vm.date_filters = {};
        vm.filter_applied = false;
        vm.filter_data = {};
        vm.transaction_details = {
            headers: [],
            content: []
        };
        vm.userGoogleConnection = false;
        vm.userGoogleConnectionStatus = false;
        vm.activeTab = 0;

        vm.switchTab = function(index) {
            vm.activeTab = index;
        };

        vm.toggleGoogleConnection = function() {
            vo = {
                'userGoogleConnection': vm.userGoogleConnection
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

        vm.fetchUserTransactions = function(page) {
            vo = {
                'filter_data': vm.filter_data,
                'page': page
            }

            GenericDataService.jx('/user/jxFetchUserTransactions', vo)
                .then(function(response) {
                    vm.transactions = response.data.gridData;
                    vm.current_page = response.data.current_page;
                    vm.total_pages = response.data.last_page;
                    vm.total_data = response.data.total;
                }).catch(function(error) {
                    messageservice.putError(error.data.message);
                });
        };

        vm.changePage = function(page) {
            if (page > 0 && page <= vm.total_pages) {
                vm.fetchUserTransactions(page);
            }
        };

        vm.openModal = function() {
            document.getElementById('filterModal').classList.remove('hidden');
        };
        
        vm.closeModal = function() {
            document.getElementById('filterModal').classList.add('hidden');
        };
        
        vm.resetFilters = function() {
            vm.document_name = '';
            vm.transaction_date_from = '';
            vm.transaction_date_to = '';
            vm.transaction_type = '';
            vm.status = '';
            vm.filter_data = {};
            vm.date_filters = {};
            if (vm.filter_applied) {
                vm.fetchUserTransactions(vm.current_page);
                vm.filter_applied = false;
            }
            vm.closeModal();
        };

        vm.applyFilters = function() {
            vm.filter_applied = true;
            vm.date_filters = {
                'transaction_date_from': vm.transaction_date_from,
                'transaction_date_to': vm.transaction_date_to,
            };
            vm.filter_data = {
                'document_name': vm.document_name,
                'date_filters': vm.date_filters,
                'transaction_type': vm.transaction_type,
                'status': vm.status
            };
            vm.fetchUserTransactions(vm.current_page);
            vm.closeModal();
        };

        vm.deleteRecord = function(transaction) {
            vo = {
                'transaction' : transaction
            }
            GenericDataService.jx('/user/jxDeleteTransaction', vo)
                .then(function(response) {
                    vm.fetchUserTransactions(vm.current_page);
                    if (response.data.success) {
                        messageservice.putSuccess(response.data.message);
                    } else {
                        messageservice.putError(response.data.message);
                    }
                })
        };

        vm.viewDetails = function(transaction) {
            // Update the modal details based on resource type
            if (transaction.resource_type === <?php echo Transactions::RESOURCE_PRESCRIPTION_TRANSLATION; ?>) {
                vm.transaction_details.headers = ['Original Content', 'Simplified Content', 'Salt Analysis'];
                vm.transaction_details.content = [
                    $sce.trustAsHtml(transaction.original_content),
                    $sce.trustAsHtml(transaction.simplified_content),
                    $sce.trustAsHtml(transaction.medication_content)
                ];
            } 
            else if (transaction.resource_type === <?php echo Transactions::RESOURCE_BILL_ANALYSIS; ?>) {
                vm.transaction_details.headers = ['Original Content', 'Simplified Bill Content'];
                vm.transaction_details.content = [
                    $sce.trustAsHtml(transaction.original_content),
                    $sce.trustAsHtml(transaction.simplified_content)
                ];
            } 
            else if (transaction.resource_type === <?php echo Transactions::RESOURCE_DOSAGE_ALERTS; ?>) {
                vm.transaction_details.headers = ['Original Content', 'Medication Data', 'Google Calendar Synced'];
                vm.transaction_details.content = [
                    $sce.trustAsHtml(transaction.original_content),
                    $sce.trustAsHtml(transaction.medication_content),
                    $sce.trustAsHtml(transaction.google_calendar_synced)
                ];
            } 
            else if (transaction.resource_type === <?php echo Transactions::RESOURCE_AUDIO_TRANSLATION; ?>) {
                vm.transaction_details.headers = ['Original Transcription', 'Simplified Transcription', 'Prescription Content'];
                vm.transaction_details.content = [
                    $sce.trustAsHtml(transaction.original_content),
                    $sce.trustAsHtml(transaction.simplified_content),
                    $sce.trustAsHtml(transaction.prescription_content)
                ];
            } 
            else {
                vm.transaction_details.headers = [];
                vm.transaction_details.content = [];
            }
            // Open the modal
            vm.openDetailsModal();
        }

        vm.openDetailsModal = function() {
            document.getElementById('prescriptionModal').classList.remove('hidden');
        }

        vm.closeDetailsModal = function() {
            document.getElementById('prescriptionModal').classList.add('hidden');
        }

        vm.checkGoogleConnection = function() {
            GenericDataService.jx('/user/jxCheckGoogleConnection')
                .then(function(response) {
                    vm.userGoogleConnection = response.data.userGoogleConnection;
                    vm.userGoogleConnectionStatus = response.data.userGoogleConnectionStatus;
                })
        }

        document.addEventListener('click', function() {
            vm.scope.$apply(function() {
                vm.transactions.forEach(function(transaction) {
                    if (transaction.showDropdown) {
                        transaction.showDropdown = false;
                    }
                });
            });
        });

        vm.activate = function() {
            vm.fetchUserTransactions(vm.current_page);
            vm.checkGoogleConnection();
        };

        vm.activate();
    }]);
</script>
