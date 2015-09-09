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
  function restangularConfig(RestangularProvider, apiUrl) {
    //RestangularProvider.setBaseUrl('http://127.0.0.1:8000/app_dev.php/');
    RestangularProvider.setBaseUrl(apiUrl);
    RestangularProvider.setRequestSuffix('.json');
    /**
     * In order to add form type name to request body
     */
    RestangularProvider.addRequestInterceptor(function (element, httpMethod, what) {
      if ('post' === httpMethod || 'put' === httpMethod) {
        var data = {};
        data[what] = element;

        return data;
      }

      return element;
    });
  }
})();
