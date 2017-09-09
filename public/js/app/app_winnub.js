/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


'use strict';

// Declare app level module which depends on views, and components
var app=angular.module('winnub', [
  'ngRoute',
  'winnub.messaggi'
]).
config(['$locationProvider', '$routeProvider', 
    function($locationProvider, $routeProvider){
        
  $locationProvider.hashPrefix('!');
  $routeProvider.otherwise({redirectTo: '/messaggi'});
  
}]);