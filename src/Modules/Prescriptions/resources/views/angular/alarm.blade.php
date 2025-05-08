<script>
    // Range filter for calendar days
    app.filter('range', function() {
        return function(input, total) {
            total = parseInt(total);
            for (var i = 0; i < total; i++) {
                input.push(i);
            }
            return input;
        };
    });

    app.controller('AlarmController', ['GenericDataService', 'messageservice', '$scope', '$http', '$sce', function (GenericDataService, messageservice, $scope, $http, $sce) {
        var vm = this;
        vm.scope = $scope;

        vm.document = null;
        vm.highest_frequency = 0;
        vm.document_dosage = null;
        vm.transaction_id = null;
        vm.calendar_dosage = {};
        vm.daily_summary = null;

        // Add timezone property
        vm.userTimezone = Intl.DateTimeFormat().resolvedOptions().timeZone;

        // Calendar related properties
        vm.currentMonth = new Date();
        vm.selectedDate = null;
        vm.medicationDays = {};
        vm.selectedDayMedications = [];
        vm.gridData = [];
        vm.pagination = {
            currentPage: 1,
            perPage: 10,
            total: 0,
            lastPage: 1
        };
        vm.showCalendarModal = false;

        // Calendar Helper Functions
        vm.calendar = {
            // Get days in month
            getDaysInMonth: function(date) {
                return new Date(date.getFullYear(), date.getMonth() + 1, 0).getDate();
            },

            // Get first day of month (0-6, where 0 is Sunday)
            getFirstDayOfMonth: function(date) {
                return new Date(date.getFullYear(), date.getMonth(), 1).getDay();
            },

            // Format date to YYYY-MM-DD
            formatDateKey: function(year, month, day) {
                month = month + 1; // Adjust month to be 1-based
                return `${year}-${String(month).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
            },

            // Check if date is today
            isToday: function(year, month, day) {
                const today = new Date();
                return today.getDate() === day && 
                       today.getMonth() === month && 
                       today.getFullYear() === year;
            },

            // Parse datetime string to local time
            parseDateTime: function(datetimeStr) {
                const date = new Date(datetimeStr);
                return {
                    date: date.toISOString().split('T')[0],
                    time: date.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit', hour12: true})
                };
            }
        };

        // Calendar Navigation Functions
        vm.calendarNav = {
            previousMonth: function() {
                vm.currentMonth = new Date(vm.currentMonth.getFullYear(), vm.currentMonth.getMonth() - 1, 1);
                vm.updateCalendar();
            },

            nextMonth: function() {
                vm.currentMonth = new Date(vm.currentMonth.getFullYear(), vm.currentMonth.getMonth() + 1, 1);
                vm.updateCalendar();
            },

            goToToday: function() {
                vm.currentMonth = new Date();
                vm.updateCalendar();
            }
        };

        // Calendar Data Management
        vm.updateCalendar = function() {
            vm.medicationDays = {};
            if (vm.calendar_dosage) {
                Object.keys(vm.calendar_dosage).forEach(medicine => {
                    if (vm.calendar_dosage[medicine].schedule) {
                        vm.calendar_dosage[medicine].schedule.forEach(datetime => {
                            const { date } = vm.calendar.parseDateTime(datetime);
                            // Only add the medication if it's actually on this date
                            const [year, month, day] = date.split('-').map(Number);
                            const currentYear = vm.currentMonth.getFullYear();
                            const currentMonth = vm.currentMonth.getMonth() + 1;
                            
                            // Only process dates for the current month/year
                            if (year === currentYear && month === currentMonth) {
                                if (!vm.medicationDays[date]) {
                                    vm.medicationDays[date] = [];
                                }
                                // Always push even if same medicine is repeated — allow time separation
                                vm.medicationDays[date].push({
                                    name: medicine,
                                    time: vm.calendar.parseDateTime(datetime).time
                                });
                            }
                        });
                    }
                });
            }
        };

        vm.selectDate = function(year, month, day) {
            const dateKey = vm.calendar.formatDateKey(year, month, day);
            vm.selectedDate = new Date(year, month, day);
            vm.selectedDayMedications = [];

            if (vm.medicationDays[dateKey]) {
                vm.medicationDays[dateKey].forEach(entry => {
                    const medicine = entry.name;
                    const medicineDetails = vm.calendar_dosage[medicine];
                    const scheduleForDay = medicineDetails.schedule
                        .filter(datetime => datetime.startsWith(dateKey))
                        .map(datetime => {
                            const { time } = vm.calendar.parseDateTime(datetime);
                            return {
                                time: time,
                                taken: false,
                                originalDateTime: datetime
                            };
                        })
                        .sort((a, b) => new Date('1970/01/01 ' + a.time) - new Date('1970/01/01 ' + b.time));
                    
                    if (scheduleForDay.length > 0) {
                        vm.selectedDayMedications.push({
                            name: medicine,
                            schedule: scheduleForDay,
                            notes: medicineDetails.notes
                        });
                    }
                });

                vm.selectedDayMedications.sort((a, b) => {
                    const timeA = new Date('1970/01/01 ' + a.schedule[0].time);
                    const timeB = new Date('1970/01/01 ' + b.schedule[0].time);
                    return timeA - timeB;
                });
            }

            vm.showCalendarModal = true;
        };

        vm.closeCalendarModal = function() {
            vm.showCalendarModal = false;
            vm.selectedDate = null;
            vm.selectedDayMedications = [];
        };

        // Initialize calendar
        vm.updateCalendar();

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
                    };

                return GenericDataService.jx('/alarm/jxFetchDosage', vo) // Send the payload
                    .then(function(response) {
                        if (response.data.success) {
                            vm.document_dosage = response.data.dosage;
                            messageservice.putSuccess(response.data.message);
                            vm.highest_frequency = vm.fetchHighestFrequency(vm.document_dosage);
                            vm.transaction_id = response.data.transaction_id;
                            vm.scope.loading = false;
                        } else {
                            messageservice.putError(response.data.message);
                            vm.scope.loading = false;
                        }
                    });
            };

            reader.onerror = function(error) {
                vm.error = 'An error occurred while reading the document.';
                messageservice.putError(vm.error);
                vm.scope.loading = false;
            };

            reader.readAsDataURL(vm.document); // Read the file as a data URL
        };

        vm.setupConfigureData = function(transaction_id) {
            vm.scope.loading = true;
            vm.transaction_id = transaction_id;
            var vo = {
                'transaction_id': vm.transaction_id
            }

            return GenericDataService.jx('/alarm/jxFetchConfigureData', vo)
                .then(function(response) {
                    vm.document_dosage = response.data.document_dosage;
                    vm.highest_frequency = vm.fetchHighestFrequency(vm.document_dosage);
                    vm.scope.loading = false;
                });
        }

        vm.closeModal = function() {
            document.getElementById('dosage-modal').style.display = 'none';
        };

        vm.scope.range = function(n) {
            return new Array(n);
        };

        vm.saveMedicine = function(medicine) {
            if (!vm.document_dosage[medicine].schedule) {
                vm.document_dosage[medicine].schedule = [];
            }
            vm.document_dosage[medicine].saved = true;
            messageservice.putSuccess('Medicine schedule saved successfully');
            console.log(vm.document_dosage);
        };

        vm.removeMedicine = function(medicine) {
            delete vm.document_dosage[medicine];
            messageservice.putSuccess('Medicine removed successfully');
            console.log(vm.document_dosage);
        };

        vm.saveDosage = function() {
            var dosage_saved = true;
            Object.keys(vm.document_dosage).forEach(medicine => {
                if (!vm.document_dosage[medicine].saved) {
                    dosage_saved = false;
                }   
            });

            if (!dosage_saved) {
                messageservice.putError('Please finalize the dosage for all medicines before saving.');
                return;
            }

            var vo = {
                'document_dosage': vm.document_dosage,
                'transaction_id': vm.transaction_id,
                'timezone': vm.userTimezone  // Add timezone to the request
            };

            return GenericDataService.jx('/alarm/jxSaveDosage', vo)
                .then(function(response) {
                    if (response.data.success) {
                        messageservice.putSuccess('Dosage saved successfully');
                        window.location.href = '/alarm';
                    } else {
                        messageservice.putError(response.data.message);
                    }
                });
        };

        // Helper function for UI
        vm.fetchHighestFrequency = function(document_dosage) {
            var highestFrequency = 0;
            Object.keys(document_dosage).forEach(medicine => {
                if (document_dosage[medicine].frequency > highestFrequency) {
                    highestFrequency = document_dosage[medicine].frequency;
                }
            });
            return highestFrequency;
        }

        vm.getCalendarDosage = function() {
            return GenericDataService.jx('/alarm/jxGetCalendarDosage')
                .then(function(response) {
                    if (response.data.success) {
                        vm.calendar_dosage = response.data.dosage;
                        vm.daily_summary = response.data.daily_summary;
                        vm.updateCalendar();
                    } else {
                        messageservice.putError(response.data.message);
                    }
                });
        }
        vm.getCalendarDosage();

        vm.addDosageToGoogleCalendar = function() {
            vo = {
                'timezone': vm.userTimezone
            }
            vm.scope.loading = true;
            return GenericDataService.jx('/alarm/jxAddDosageToGoogleCalendar', vo)
                .then(function(response) {
                    if (response.data.success) {
                        messageservice.putSuccess(response.data.message);
                    } else {
                        messageservice.putError(response.data.message);
                    }
                    vm.scope.loading = false;
                });
        }

        vm.fetchGridData = function(page = 1) {
            vm.scope.loading = true;
            vm.pagination.currentPage = page;
            return GenericDataService.jx('/alarm/jxfetchData', {
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
  
        vm.getMonthName = function(index) {
            const date = new Date(2000, index, 1);
            return date.toLocaleString('default', { month: 'long' });
        };
}]);
</script>
