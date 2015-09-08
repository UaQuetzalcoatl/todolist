(function() {
  'use strict';

  angular
    .module('app')
    .config(config)
    .config(restangularConfig);

  /** @ngInject */
  function config($logProvider) {
    // Enable log
    $logProvider.debugEnabled(true);
  }

  /** @ngInject */
  function restangularConfig(RestangularProvider) {
    RestangularProvider.setBaseUrl('http://127.0.0.1:8000/app_dev.php/');
    RestangularProvider.setRequestSuffix('.json');
  }
})();
