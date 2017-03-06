<div class="app">
    <div class="container" ng-app="loginApp" ng-controller="mainController" ng-cloak>
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="navbar">
                    <div class="navbar-brand m-t-lg text-center">
                        <?php echo Asset::img('logo.png', ['width' => '100px']); ?>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-md-offset-4">
                <div class="p-lg panel shadow-x2 text-color m">
                    <div class="m-b text-sm">
                        <h4 class="no-margin-top text-center">
                            Login
                        </h4>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <form name="form" class="no-margin" ng-submit="login()">
                                <div class="md-form-group float-label">
                                    <input type="text" class="md-input" ng-model="email" required>
                                    <label>E-mail / Username</label>
                                </div>
                                <div class="md-form-group float-label">
                                    <input type="password" class="md-input" ng-model="password" required>
                                    <label>Password</label>
                                </div>
                                <p class="red" ng-show="error">
                                    {{error}}
                                </p>
                                <div ng-if="loading" class="loader" style="width: 50px">
                                    <svg class="circular" viewBox="25 25 50 50">
                                        <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2"
                                                stroke-miterlimit="10"/>
                                    </svg>
                                </div>
                                <div class="text-center">
                                    <button type="submit" ng-disabled="form.$invalid"
                                            ng-if="!loading"
                                            class="md-btn md-raised white blue-bg p-h-md waves-effect btn-block">
                                        Login
                                    </button>
                                </div>
                                <div class="clearfix"></div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    angular.module('loginApp', [])
        .controller('mainController', [
            '$scope',
            '$http',
            '$window',
            function ($scope, $http, $window) {
                var current = '<?php echo \Fuel\Core\Uri::current(); ?>';
                var base = '<?php echo \Fuel\Core\Uri::base(); ?>';

                $scope.error = false;
                $scope.login = function () {
                    $scope.error = false;
                    $scope.loading = true;

                    $http.post(current, {
                        email: $scope.email,
                        password: $scope.password
                    }).then(function (res) {
                        if (res.data.status) {
                            $window.location.href = base;
                        } else {
                            console.log(res.data.reason);
                            $scope.error = res.data.reason;
                            $scope.loading = false;
                        }
                    }, function () {
                        $scope.error = 'Could not connect';
                        $scope.loading = false;
                    })
                }
            }
        ])
</script>