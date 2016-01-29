/**
 * @file
 * materialize-init.js
 *
 * Init materialize components.
 */

var Drupal = Drupal || {};

(function ($, Drupal, drupalSettings) {
  "use strict";

  Drupal.behaviors.initMobileMenu = {
    attach: function (context) {
      $('.button-collapse').once().sideNav();
    }
  };

})(jQuery, Drupal, drupalSettings);
