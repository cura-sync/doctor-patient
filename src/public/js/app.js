// Initialize AngularJS App
const app = angular.module("myApp", ["ngSanitize"]); // Include ngSanitize for HTML sanitization

// Sanitize HTML Filter
app.filter("sanitizeHtml", [
    "$sce",
    function ($sce) {
        return function (input) {
            return $sce.trustAsHtml(input);
        };
    },
]);

// Directive for Highlight.js Integration
app.directive("onRenderFinish", function () {
    return {
        link: function (scope, element, attrs) {
            if (scope.$last === true) {
                // Apply syntax highlighting to all code blocks in the DOM
                document.querySelectorAll("pre code").forEach((block) => {
                    hljs.highlightElement(block);
                });
            }
        },
    };
});

// Run Block for Global Variables
app.run(function ($rootScope) {
    $rootScope.disableButton = false;
    $rootScope.urlsCalled = [];
    $rootScope.urlsReceived = [];
    $rootScope.urlsFailed = [];
});

// API Interceptor for Request Tracking
app.service("APIInterceptor", function ($rootScope) {
    const service = this;

    // Request Interceptor
    service.request = function (config) {
        $rootScope.urlsCalled.push(
            config.url.substring(config.url.lastIndexOf("/") + 1)
        );
        $rootScope.disableButton = true;
        return config;
    };

    // Response Interceptor
    service.response = function (response) {
        $rootScope.urlsReceived.push(
            response.config.url.substring(
                response.config.url.lastIndexOf("/") + 1
            )
        );
        $rootScope.disableButton = false;
        return response;
    };

    // Error Response Interceptor
    service.responseError = function (response) {
        $rootScope.urlsFailed.push(
            response.config.url.substring(
                response.config.url.lastIndexOf("/") + 1
            )
        );
        $rootScope.disableButton = false;
        return response;
    };
});

// Configure HTTP Provider to Use the Interceptor
app.config(function ($httpProvider) {
    $httpProvider.interceptors.push("APIInterceptor");
});

// Generic Data Service
app.factory("GenericDataService", function ($http) {
    return {
        jx: jx,
    };

    // Post Request Function
    function jx(router, vo) {
        return $http
            .post(router, vo)
            .then(function (response) {
                if (response.status == 200) {
                    return response;
                }
            });
    }
});

app.factory("messageservice", function () {
    return {
        processResponseError: processResponseError,
        processError: processError,
        putSuccess: putSuccess,
        putError: putError,
    };
  
    function processResponseError(response) {
        if (!response || typeof response !== "object") {
            return 1;
        }
        var url = "";
        if (
            response.hasOwnProperty("config") &&
            response.config.hasOwnProperty("url")
        ) {
            url = response.config.url;
        }
        if (response.status == 0) {
            showNotification("Internet is Disconnected, please check. (" + url + ")", "error", "Error");
            return 1;
        }
        if (response.status == 404) {
            showNotification("Server Error : 404 (" + url + ")", "error", "Error");
            return 1;
        }
        if (response.status == 500) {
            showNotification("Server Error : 500 (" + url + ")", "error", "Error");
            return 1;
        }
        return processError(response.data);
    }
  
    function processError(data) {
        if (!data || typeof data !== "object") {
            showNotification("no data OR data not object", "error", "Error");
            return 1;
        }
        if (
            data.hasOwnProperty("errors") &&
            Object.keys(data.errors).length > 0
        ) {
            if (data.errors.system) {
            putError(data.errors.system);
            }
            const { system, ...nonSystemErrors } = data.errors;
            handleLeftOverErrorKeys(nonSystemErrors);
            return 1;
        }
        return 0;
    }
  
    function handleLeftOverErrorKeys(errors) {
        const errorList = [];
        if (Object.entries(errors).length == 0) return;
        for (const [key, value] of Object.entries(errors)) {
            errorList.push(`<li><strong>${key}</strong><br>${value}</li>`);
        }
        Swal.fire({
            type: "error",
            title: "Unexpected Error",
            html: `<ol class="swal-ul">${errorList.join("")}</ol>`,
            confirmButtonText: "Ok",
            onOpen: function() {
            const event = new CustomEvent('swal-fired');
            window.dispatchEvent(event);
            }
        });
    }
  
    function putSuccess(msg) {
        if (typeof theme !== "undefined" && theme == "metronic") {
            toastr.success(msg);
            return;
        }
        showNotification(msg, "success", "Success");
    }
  
    function putError(msg) {
        if (typeof theme !== "undefined" && theme == "metronic") {
            toastr.error(msg);
            return;
        }
        showNotification(msg, "error", "Error");
    }
  
    function showNotification(message, type, title) {
        const notification = document.createElement("div");
        notification.className = `notification ${type}`;
        
        // Create header div
        const header = document.createElement("div");
        header.className = "notification-header";
        
        // Add icon based on type
        const icon = document.createElement("span");
        icon.className = "notification-icon";
        icon.innerHTML = type === "success" ? "✓" : "✕";
        header.appendChild(icon);
        
        // Add title
        const titleSpan = document.createElement("span");
        titleSpan.className = "notification-title";
        titleSpan.textContent = title;
        header.appendChild(titleSpan);
        
        // Add message
        const messageDiv = document.createElement("div");
        messageDiv.className = "notification-message";
        messageDiv.textContent = message;
        
        // Assemble notification
        notification.appendChild(header);
        notification.appendChild(messageDiv);
        
        document.body.appendChild(notification);
        
        // Remove notification after 3 seconds
        setTimeout(() => {
            notification.remove();
        }, 3000);
    }
});