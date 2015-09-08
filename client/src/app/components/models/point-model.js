(function () {
  'use strict';

  angular
    .module('app.points')
    .factory('PointModel', PointModel);

  PointModel.$inject = ['Restangular'];

  /* @ngInject */
  function PointModel(Restangular) {
    Restangular.extendModel('points', function(model) {
      model.due_date = new Date(model.due_date);

      return model;
    });

    return Restangular.service('points');
  }
})();
