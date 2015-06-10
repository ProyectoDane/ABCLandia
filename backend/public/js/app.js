var abclandiaApp = angular
            
.module('abclandia', ['ngAnimate', 'mgcrea.ngStrap', 'localytics.directives'])

.config(['$interpolateProvider', function($interpolateProvider) {
    $interpolateProvider.startSymbol('{(').endSymbol(')}');
}])
.config(['$httpProvider', function($httpProvider) {
    $httpProvider.defaults.headers.common["X-Requested-With"] = 'XMLHttpRequest';
    $httpProvider.defaults.headers.common['X-Csrf-Token'] = "{{ Session::token() }}";

    $httpProvider.interceptors.push(function($q) {
        return {
            responseError: function(rejection) {
                window.location = "{{ route('auth.login') }}";
            },
        };
    });
}])

.filter('capitalize', function() {
    return function(input, scope) {
        return input.substring(0,1).toUpperCase() + input.substring(1).toLowerCase();
    }
})
.filter('sexo', function() {
    return function(input, scope) {
        return input == 1 ? 'Femenino' : 'Masculino';
    }
})
.filter('nombreCompleto', ['$filter', function($filter) {
    return function(input, scope) {
        return $filter('capitalize')(input.apellido) + ', ' + $filter('capitalize')(input.nombre);
    }
}])

.service('$flash', ['$alert', function($alert) {
    this.show = function (msg) {
        $alert({
            title: '',
            content: msg,
            placement: 'bottom',
            type: 'success',
            show: true,
            dismissable: false,
            duration: 2,
            container: '#alert-container'
        });
    }
}])
.service('$http_file', ['$http', function ($http) {
    this.http = function(url, form, method) {
        var fd = new FormData();

        for (attr in form)
        {
            if (Object.prototype.toString.call(form[attr]) === '[object Array]')
            {
                for (var i = 0; i < form[attr].length; i++)
                {
                    fd.append(attr+'['+i+']', form[attr][i]);
                }
            }
            else
            {
                fd.append(attr, form[attr]);
            }
        }

        return $http({
            method: method,
            url: url,
            data: fd,
            headers: {'Content-Type':undefined},
            transformRequest: function(data){return data;}
        });
        /*
        return $.ajax({
            url: url,
            type: "POST",
            data: fd,
            processData: false,  // tell jQuery not to process the data
            contentType: false   // tell jQuery not to set contentType
        });
        */
    };

    this.post = function(url, form) {
        return this.http(url, form, 'POST');
    };

    this.put = function(url, form) {
        form._method = 'PUT';
        return this.http(url, form, 'POST');
    }
}])

.directive('fileModel', ['$parse', function ($parse) {
    return {
        restrict: 'A',
        link: function(scope, element, attrs) {
            var model = $parse(attrs.fileModel);
            var modelSetter = model.assign;

            element.bind('change', function(){
                scope.$apply(function(){
                    modelSetter(scope, element[0].files[0]);
                });
            });
        }
    };
}])
.directive("clockSrc", ['$filter', function($filter) {
    return {
        link: function(scope, element, attrs) {
            var img, loadImage;
            img = null;

            loadImage = function() {
                element[0].src = "data:image/gif;base64,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";
                img = new Image();

                if (attrs.clockSrc === '')
                {
                    img.src = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAJYAAACWCAIAAACzY+a1AAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAAFYSURBVHhe7dEBDQAADMOg+7c1Y9dBUixwC65CXoW8CnkV8irkVcirkFchr0JehbwKeRXyKuRVyKuQVyGvQl6FvAp5FfIq5FXIq5BXIa9CXoW8CnkV8irkVcirkFchr0JehbwKeRXyKuRVyKuQVyGvQl6FvAp5FfIq5FXIq5BXIa9CXoW8CnkV8irkVcirkFchr0JehbwKeRXyKuRVyKuQVyGvQl6FvAp5FfIq5FXIq5BXIa9CXoW8CnkV8irkVcirkFchr0JehbwKeRXyKuRVyKuQVyGvQl6FvAp5FfIq5FXIq5BXIa9CXoW8CnkV8irkVcirkFchr0JehbwKeRXyKuRVyKuQVyGvQl6FvAp5FfIq5FXIq5BXIa9CXoW8CnkV8irkVcirkFchr0JehbwKeRXyKuRVyKuQVyGvQl6FvAp5FfIq5FXIq5BXIa9CXoW8CnkV8irEbQ83DOO9PjdCVAAAAABJRU5ErkJggg==';
                }
                else
                {
                    img.src = "http" == attrs.clockSrc.substring(0,4)
                        ? attrs.clockSrc + '?time='+ $filter('date')(new Date(), 'medium')
                        : attrs.clockSrc;
                }

                img.onload = function() {
                    element[0].src = img.src;
                };
            };
            loadImage();
            /*
            scope.$watch(function() {
                return attrs.clockSrc;
            }, function(newVal, oldVal) {
                oldVal == newVal || loadImage();
            });
            */
        }
    };
}]);