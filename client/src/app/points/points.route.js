(function () {
  'use strict';

  angular
    .module('app.points')
    .config(routeConfig);

  /** @ngInject */
  function routeConfig($stateProvider) {
    $stateProvider
      .state('home.points', {
        url: 'points',
        templateUrl: 'app/points/point-list/point-list.html',
        controller: 'PointsController',
        controllerAs: 'pointsCtrl',
        resolve: {
          Points: function (Restangular) {
            return Restangular.all('points').getList();
          }
        }
      });
  }

})();
