<script>
 
   var app = angular.module('liveApp', ['datatables']);

    app.controller('liveController2', function($scope,$http){
		$scope.fetchData = function(){
			$http.get('reporte_rs.php').success(function(data, status, headers, config){
      $scope.namesData2 = data;
			})
		};
		
		$scope.formData2 = {};
		
		$scope.getTemplate2 = function(data){
			if(data.numero == $scope.formData2.numero)
			{
				return 'edit2';
			}
			else
			{
				return 'display2';
			}
		}
		
		
		$scope.showEdit = function(data) {
        $scope.formData2 = angular.copy(data);
    };
		
		
	
		
	

		
		
	});
	  
</script>