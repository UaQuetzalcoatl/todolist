'use strict';

var MainPage = function() {
  this.homeButton = element(by.css('.home-btn'));
  this.pointButton = element(by.css('.points-btn'));
};

module.exports = new MainPage();
