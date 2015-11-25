var app = angular.module('clients', ['ui.bootstrap']);

app.config(['$interpolateProvider', function($interpolateProvider) {
	$interpolateProvider.startSymbol('{[');
	$interpolateProvider.endSymbol(']}');
}]);

app.controller('clients', ['$scope', '$http', function($scope, $http) {

    $http.get('/api/v1/client').success(function(data) {
    	angular.forEach(data, function(value, key) {
			data[key]['latest_backup_time'] = data[key]['latest_backup_time'] * 1000;
		});

        $scope.clients = data;
		// http 请求获取到 clients 信息后, ng-repeat 会 foreach

		//进行 latestBackupTime 更新
		$scope.refreshLatestBackupTime = function(index) {

			client = $scope.clients[index]
			client.latest_backup_time = '<i class="fa fa-spinner fa-spin"></i>';
			$http.get('/api/v1/client/refreshLatestBackupTime?id=' + client.id).success(function(data) {
				if (!data.error) {
					if (data.latest_backup_time > 0){
						client.latest_backup_time = data.latest_backup_time * 1000;
					}
					else {
						client.latest_backup_time = '暂无备份';
					}
				}
				else {
					client.latest_backup_time = '刷新失败!';
				}
        	});
    	}

    });

    $('#loading').hide();
}]);

app.filter('trustHtml', function ($sce) {
	return function (input) {
		return $sce.trustAsHtml(input);
	}
});

app.filter('trueOrFalse', function($sce) {
	return function(input) {
		return input != 0;
	}
});

app.filter('PRCTime', function($sce) {
    return function(input) {
        if ($.isNumeric(input)) {
            return input - 8 * 3600000;
        }
        else {
            return input;
        }
    }
});