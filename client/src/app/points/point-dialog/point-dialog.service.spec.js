(function () {
  'use strict';

  describe('point dialog service', function () {
    var service;

    beforeEach(function () {
      module('app');
      module('app.points');
    });

    beforeEach(inject(function (PointDialogSrv) {
      service = PointDialogSrv;
    }));

    it('should have open method', function () {
      expect(service.open).toBeDefined();
      expect(angular.isFunction(service.open)).toBeTruthy();
    });
  });
})();
