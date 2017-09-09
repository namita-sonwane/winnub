/* 
 *
 *
 *
 */
'use strict';

var WApp=angular.module('winnub', ['ngRoute']);

WApp.config(function($routeProvider) {
        $routeProvider.
          when('/', {
            templateUrl: '/public/template/message-all.html',
            controller: 'CtrlMessage'
          }).
          when('/send', {
            templateUrl: '/public/template/message-all.html',
            controller: 'CtrlMessage'
          }).
          
          when('/trash', {
            templateUrl: '/public/template/message-all.html',
            controller: 'CtrlMessage'
          }).     
          when('/:messageId', {
            templateUrl: '/public/template/message-detail.html',
            controller: 'CtrlMessageDetails'
          }).
          otherwise({
            redirectTo: '/'
          });
});

WApp.factory('AuthService', function ($http, Session){
    
    var authService = {};

    authService.login = function (credentials) {
      return $http
        .post('/login', credentials)
        .then(function (res) {
          Session.create(res.data.id, res.data.user.id,
                         res.data.user.role);
          return res.data.user;
        });
    };
    
    authService.verifica = function() {
      return $http
        .post('/oauth')
        .then(function (res) {
          Session.create(res.data.id, res.data.user.id,
                         res.data.user.role);
          return res.data.user;
        });
    };
    

    authService.isAuthenticated = function () {
      return !!Session.userId;
    };

    authService.isAuthorized = function (authorizedRoles) {
      if (!angular.isArray(authorizedRoles)) {
        authorizedRoles = [authorizedRoles];
      }
      return (authService.isAuthenticated() &&
        authorizedRoles.indexOf(Session.userRole) !== -1);
    };

    return authService;
  
}).service('Session', function () {
    
    this.create = function (sessionId, userId, userRole) {
      this.id = sessionId;
      this.userId = userId;
      this.userRole = userRole;
    };
    
    this.destroy = function () {
      this.id = null;
      this.userId = null;
      this.userRole = null;
    };
});




WApp.factory('Messaggi', function($http){
        return {
          list: function (callback){
            $http({
              method: 'GET',
              url: '/'+language+"/message/all",
              cache: true
            }).success(callback);
          },
          find: function(id, callback){
            $http({
              method: 'GET',
              url: '/'+language+"/message/get/"+id,
              cache: true
            }).success(callback);
          }
        };
});

WApp.factory('Contatti', function($http){
        return {
          list: function (callback){
            $http({
              method: 'GET',
              url: '/'+language+"/message/contact",
              cache: true
            }).success(callback);
          },
          find: function(id, callback){
            $http({
              method: 'GET',
              url: '/'+language+"/message/contact/"+id,
              cache: true
            }).success(callback);
          },
          send: function(id, callback){
            $http({
              method: 'GET',
              url: '/'+language+"/message/send/",
              cache: true
            }).success(callback);
          },
          trash: function(id, callback){
            $http({
              method: 'GET',
              url: '/'+language+"/message/trash/",
              cache: true
            }).success(callback);
          }
        };
});

 WApp.controller('CtrlMessage', function ($scope,$routeParams, Messaggi,AuthService){
       
       
       
        if($routeParams==="send"){
            
            
             Messaggi.send(function(mess) {
                $scope.listamessaggi = mess;
            });
            
        }else if($routeParams==="trash"){
            Messaggi.trash(function(mess) {
                $scope.listamessaggi = mess;
            });
        }else{
           
        }
        
        
        $scope.filtroModel = function(messaggio){
            
             if( $scope.status=="send"){
                    
             }

             return true;
        };
        
        Messaggi.list(function(mess) {
               $scope.listamessaggi = mess;
        });
        
        
 });

 WApp.controller('CtrlMessageDetails', function ($scope,$routeParams, Messaggi){
        
        Messaggi.find($routeParams.messageId, function(messaggio) {
          $scope.messaggio = messaggio;
        });
        
        
 });



