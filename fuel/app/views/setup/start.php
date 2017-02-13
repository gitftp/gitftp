<div class="container" ng-app="setupApp" ng-controller="mainController">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="navbar">
                <div class="navbar-brand m-t-lg text-center">
                    <?php echo Asset::img('logo.png', ['width' => '100px']); ?>
                </div>
            </div>
            <div class="p-lg panel shadow-x2 text-color m" ng-show="step == 1">
                <div class="m-b text-sm text-center">
                    <h4 class="no-margin-top">Setup</h4>
                    <span>1 of 3: dependency check</span>
                </div>
                <table class="table">
                    <tr>
                        <td style="width: 50px">
                            <div ng-if="step1Loading" class="loader" style="width: 19px">
                                <svg class="circular" viewBox="25 25 50 50">
                                    <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="5"
                                            stroke-miterlimit="10"/>
                                </svg>
                            </div>
                            <i ng-if="step1Php == 2 && !step1Loading" class="zmdi zmdi-close-circle red"
                               style="font-size: 21px;text-align: center;"></i>
                            <i ng-if="step1Php == 1 && !step1Loading" class="zmdi zmdi-check-circle green"
                               style="font-size: 21px;text-align: center;"></i>
                        </td>
                        <td>
                            PHP version
                            <div ng-if="step1PhpVersion" class="text-muted" style="font-size: 10px">{{step1PhpVersion}}</div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div ng-if="step1Loading" class="loader" style="width: 19px">
                                <svg class="circular" viewBox="25 25 50 50">
                                    <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="5"
                                            stroke-miterlimit="10"/>
                                </svg>
                            </div>
                            <i ng-if="step1Git == 2 && !step1Loading" class="zmdi zmdi-close-circle red"
                               style="font-size: 21px;text-align: center;"></i>
                            <i ng-if="step1Git == 1 && !step1Loading" class="zmdi zmdi-check-circle green"
                               style="font-size: 21px;text-align: center;"></i>
                        </td>
                        <td>
                            Git
                            <div ng-if="step1GitVersion" class="text-muted" style="font-size: 10px">{{step1GitVersion}}</div>
                        </td>
                    </tr>
                </table>
                <div ng-show="!step1Loading">
                    <div class="space20"></div>
                    <div class="text-center">
                        <button type="button" class="md-btn md-raised white blue-bg p-h-md waves-effect"
                                ng-click="start1()">Start
                        </button>
                    </div>
                </div>
                <div ng-show="!step1Loading && step1Go">
                    <div class="space20"></div>
                    <div class="text-center">
                        <button type="button" class="md-btn md-raised white blue-bg p-h-md waves-effect"
                                ng-click="step2()">Continue
                        </button>
                    </div>
                </div>
            </div>
            <div class="p-lg panel shadow-x2 text-color m" ng-show="step == 2">
                <div class="m-b text-sm text-center">
                    Welcome to the Gitftp setup <br>
                    lets start with setting up the database
                </div>
                <form name="form" class="no-margin" ng-submit="test_database()">
                    <div class="md-form-group float-label">
                        <input type="text" class="md-input" ng-model="db.host" required>
                        <label>Host (localhost)</label>
                    </div>
                    <div class="md-form-group float-label">
                        <input type="text" class="md-input" required ng-model="db.username">
                        <label>Username</label>
                    </div>
                    <div class="md-form-group float-label">
                        <input type="password" class="md-input" required ng-model="db.password">
                        <label>Password</label>
                    </div>
                    <div class="md-form-group float-label">
                        <input type="text" class="md-input" required ng-model="db.dbname">
                        <label>Database name</label>
                    </div>
                    <button type="button" ng-disabled="form.$invalid"
                            class="md-btn md-raised white blue-bg p-h-md waves-effect pull-right">
                        next <i class="zmdi zmdi-arrow-right"></i>
                    </button>
                    <div class="clearfix"></div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    angular.module('setupApp', [])
        .controller('mainController', [
            '$scope',
            '$http',
            function ($scope, $http) {
                $scope.step = 1;
                $scope.tests = [];
                $scope.step1Loading = false;
                $scope.step1Go = false;
                var current = '<?php echo \Fuel\Core\Uri::base() ?>setup/api';
                $scope.step1Php = false;
                $scope.step1PhpVersion = false;
                $scope.step1Git = false;
                $scope.step1GitVersion = false;

                $scope.start1 = function () {
                    $scope.step1Loading = true;
                    $http.post(current + '/dep_test.json', {}).then(function (res) {
                        if (res.data.status) {
                            $scope.step1Php = res.data.data.php[0];
                            $scope.step1PhpVersion = res.data.data.php[1];
                            $scope.step1Git = res.data.data.git[0];
                            $scope.step1GitVersion = res.data.data.git[1];
                        }
                        else {
                            n();
                        }
                        $scope.step1Loading = false;
                    }, function () {
                        $scope.step1Loading = false;
                        n('Could not connect', 'error');
                    })
                };

                $scope.db = {};
                $scope.test_database = function () {
                    $http.post(current + '/db_test', {
                        db: $scope.db
                    }).then(function () {

                    }, function () {
                        n('Could not connect', 'error');
                    });
                };
            }
        ])
</script>