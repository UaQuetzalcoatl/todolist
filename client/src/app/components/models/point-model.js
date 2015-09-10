(function () {
  'use strict';

  angular
    .module('app.points')
    .factory('PointModel', PointModel);

  PointModel.$inject = ['Restangular'];

  /* @ngInject */
  function PointModel(Restangular) {
    Restangular.extendModel('points', function(model) {
      model.dueDate = new Date(model.dueDate);

      return model;
    });

    return Restangular.service('points');
  }
})();
