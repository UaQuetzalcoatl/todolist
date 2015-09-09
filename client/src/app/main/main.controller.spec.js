(function() {
  'use strict';

  describe('controllers', function(){

    beforeEach(module('app'));

    it('should define title property', inject(function($controller) {
      var vm = $controller('MainController');

      expect(vm.title === 'test application').toBeTruthy();
    }));
  });
})();
