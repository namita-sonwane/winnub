/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


'use strict';

// Declare app level module which depends on views, and components
angular.module('winnub', [
  'ngRoute',
  'winnub.invoice'
]).
config(['$locationProvider', '$routeProvider', 
    function($locationProvider, $routeProvider){
        
  $locationProvider.hashPrefix('!');
  
  $routeProvider.otherwise({redirectTo: '/invoice'});
  
}]);




angular.module('winnub.invoice', ['ngRoute'])

    .config(['$routeProvider', function($routeProvider){

        $routeProvider
        .when('/invoice', {
            templateUrl: '/public/js/app/invoice/view/default.html',
            controller: 'InvoceCtrl'
        }).
        when("/invoice/:idCodice",
        {
            templateUrl: '/public/js/app/invoice/view/default.html',
            controller: 'InvoceCtrl'
        }).
        when("/invoice/all",
        {
            templateUrl: '/public/js/app/invoice/view/all.html',
            controller: 'invoceList'
        });
  
    }])


 .factory('InvoiceModel',function($http){

        function Invoice( json ) {
            angular.extend( this, json );
        }
        
        Invoice.prototype = {
            $save: function () {
              // TODO: strip irrelevant fields
                var scrubbedObject = {};//...
                return $http.put( '/widgets/'+this.id, scrubbedObject );
            }
        };

        function getInvoiceId ( id ) {
            return $http( '/invoice/'+id ).then(function ( json ) {
              return new Invoice( json );
            });
          }   
     })

    .controller('InvoceCtrl',['$scope',function($scope,$routeProvider,$http,InvoiceModel,$route){
        
        $scope.currentId = $route.idCodice;
        
        
        $scope.loadCurrent=function(){
           alert($scope.currentId);
           $scope.fattura=InvoiceModel.getInvoiceId($scope.currentId);
        };
        
       
        
        $scope.fattura={
          totale:0,
          totiva:0,
          impostetotale:0,
          esenzioni:0,
          sconto:0
        };
        

        $scope.items=[];
        $scope.codice="";
        $scope.descrizione="";
        $scope.qtn="";
        $scope.iva="";
        $scope.totaleitem="";
        $scope.addItem = function(){	
            $scope.items.push({
                'codice':$scope.codice, 
                'descrizione': $scope.descrizione, 
                'qtn':$scope.qtn,
                'iva':$scope.iva,
                'prezzo':$scope.totaleitem
            });
            $scope.fattura.totale=($scope.totaleitem*$scope.qtn);
            $scope.codice="";
            $scope.descrizione="";
            $scope.qtn="";
            $scope.iva="";
            $scope.totaleitem="";
        }; 
        
         
        if($scope.currentId>0){
           loadCurrent();
        }
        
}])

.controller('invocelist',['$scope',function($scope,$http,InvoiceModel){
        
}]);


