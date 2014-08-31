app.controller('ChannelCtrl', ['$scope', 'googleService', 'shareProperty', '$http',
    function($scope, googleService, shareProperty, $http) {

        $scope.user = {};
        $scope.network = {};
        $scope.error = {};
        $scope.url = 'server.php';
        $scope.loading = false;

        $scope.login = function () {
            googleService.handleAuthResult().then(function (data) {
                $scope.user.connect = true;
                $scope.user.name = data.fullName;
                $scope.user.YouTube = "http://youtube.com/channel/" + data.id;
                $scope.user.email = data.email;
                $scope.user.analytics = data.analytics;
                $scope.user.view = data.view;
                $scope.user.subscriber = data.subs;
                $scope.step.one = true;   
            }, function (error) {
                console.log('Failed: ' + error)
            });
        };

        var reciepInfosNetwork = shareProperty.getNetwork();
        reciepInfosNetwork.then(function(result) {  
            $scope.user.contract = result.data.contract;
            $scope.network.name = result.data.name;
            $scope.network.analytics = result.data.analytics;
            $scope.network.email = result.data.email;
        });

        $scope.valideAnalytics = function () {
            if($scope.network.analytics <= $scope.user.analytics)
                return true;
            return false;
        };  
        
        $scope.$watch(function () {
            $scope.user.contract = shareProperty.getContract().contract;
        });
            
        $scope.saveUser = function () {
            $scope.user.contract = true;
            $scope.loading = true;

            $http.post($scope.url, { "data" : $scope.user }).success(function(data, status) {
                $scope.step.three = true;
                $scope.loading = false
            }).error(function(data, status) {
                $scope.error.mysql = true;
                $scope.error.message = data;
                $scope.loading = false  
            });
        };

    }
]);
