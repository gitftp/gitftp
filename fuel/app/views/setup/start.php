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
                            <div ng-if="step1.loading" class="loader" style="width: 19px">
                                <svg class="circular" viewBox="25 25 50 50">
                                    <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="5"
                                            stroke-miterlimit="10"/>
                                </svg>
                            </div>
                            <i ng-if="step1.dep.php == 2 && !step1.loading" class="zmdi zmdi-close-circle red"
                               style="font-size: 21px;text-align: center;"></i>
                            <i ng-if="step1.dep.php == 1 && !step1.loading" class="zmdi zmdi-check-circle green"
                               style="font-size: 21px;text-align: center;"></i>
                        </td>
                        <td>
                            PHP version
                            <div ng-if="step1.dep.phpVersion" class="text-muted" style="font-size: 12px">
                                {{step1.dep.phpVersion}}
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div ng-if="step1.loading" class="loader" style="width: 19px">
                                <svg class="circular" viewBox="25 25 50 50">
                                    <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="5"
                                            stroke-miterlimit="10"/>
                                </svg>
                            </div>
                            <i ng-if="step1.dep.git == 2 && !step1.loading" class="zmdi zmdi-close-circle red"
                               style="font-size: 21px;text-align: center;"></i>
                            <i ng-if="step1.dep.git == 1 && !step1.loading" class="zmdi zmdi-check-circle green"
                               style="font-size: 21px;text-align: center;"></i>
                        </td>
                        <td>
                            Git
                            <div ng-if="step1.dep.gitVersion" class="text-muted" style="font-size: 12px">
                                {{step1.dep.gitVersion}}
                            </div>
                        </td>
                    </tr>
                </table>
                <div ng-show="!step1.loading && !step1.go">
                    <div class="space20"></div>
                    <div class="text-center">
                        <button type="button" class="md-btn md-raised white blue-bg p-h-md waves-effect"
                                ng-click="step1.start()">Start
                        </button>
                    </div>
                </div>
                <div ng-show="!step1.loading && step1.go">
                    <div class="space20"></div>
                    <p ng-if="step1.os_name" class="text-center">
                        Operating System: {{step1.os_name}} <br>
                        Everything looks good.
                    </p>
                    <div class="text-center">
                        <button type="button" class="md-btn md-raised white blue-bg p-h-md waves-effect"
                                ng-click="step2()">Continue
                        </button>
                    </div>
                </div>
            </div>
            <div class="p-lg panel shadow-x2 text-color m" ng-show="step == 2">
                <div class="m-b text-sm text-center">
                    <h4 class="no-margin-top">Setup</h4>
                    <span>2 of 3: Database</span>
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
                    <button type="submit" ng-disabled="form.$invalid"
                            class="md-btn md-raised white blue-bg p-h-md waves-effect pull-right">
                        next <i class="zmdi zmdi-arrow-right"></i>
                    </button>
                    <div class="clearfix"></div>
                </form>
            </div>
            <div class="p-lg panel shadow-x2 text-color m" ng-show="step == 3">
                <div class="m-b text-sm text-center">
                    <h4 class="no-margin-top">Finsihed</h4>
                    <span>Thanks for installing Gitftp</span>
                </div>
                <button type="button" ng-disabled="form.$invalid"
                        class="md-btn md-raised white blue-bg p-h-md waves-effect btn-block">
                    Goto dashboartd
                </button>
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
                var current = '<?php echo \Fuel\Core\Uri::base() ?>setup/api';

                // step1
                var s1 = $scope.step1 = {};
                s1.loading = false;
                s1.go = false;
                s1.dep = {
                    php: false,
                    phpVersion: false,
                    git: false,
                    gitVersion: false,
                };

                s1.start = function () {
                    s1.loading = true;
                    $http.post(current + '/dep_test.json', {}).then(function (res) {
                        if (res.data.status) {
                            s1.dep.php = res.data.data.php[0];
                            s1.dep.phpVersion = res.data.data.php[1];
                            s1.dep.git = res.data.data.git[0];
                            s1.dep.gitVersion = res.data.data.git[1];
                            s1.go = res.data.data.allOk;
                            s1.os_name = res.data.data.os;
                        }
                        else {
                            n(res.data.reason, 'error');
                        }
                        s1.loading = false;
                    }, function () {
                        s1.loading = false;
                        n('Could not connect', 'error');
                    })
                };
                $scope.step2 = function () {
                    if (s1.go) {
                        $scope.step = 2;
                    }
                };


                // step2
                $scope.db = {};
                $scope.test_database = function () {
                    $http.post(current + '/db_test', {
                        db: $scope.db
                    }).then(function (res) {
                        if (res.data.status) {
                            $scope.step = 3;
                        } else {
                            n(res.data.reason);
                        }
                    }, function () {
                        n('Could not connect', 'error');
                    });
                };
            }
        ])
</script>