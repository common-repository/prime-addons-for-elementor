"use strict";

(function ($) {
  /**
   * In viewport helper.
   *
   * @param {number} buffer Buffer offset.
   * @return {boolean} Return true if in view.
   */
  $.fn.inView = function (buffer) {
    buffer = typeof buffer !== 'undefined' ? buffer : 100;
    const win = $(window);
    const viewport = {
      top: win.scrollTop(),
      left: win.scrollLeft()
    };
    viewport.right = viewport.left + win.width() - buffer;
    viewport.bottom = viewport.top + win.height() - buffer;
    const bounds = this.offset();
    bounds.right = bounds.left + this.outerWidth();
    bounds.bottom = bounds.top + this.outerHeight();
    return !(viewport.right < bounds.left || viewport.left > bounds.right || viewport.bottom < bounds.top || viewport.top > bounds.bottom);
  };

  /**
   * Parallax function for elements.
   *
   * @param {number} momentum Momentum.
   * @param {string} axis Axis.
   */
  $.fn.parallax = function (momentum, axis) {
    momentum = typeof momentum !== 'undefined' ? momentum : '0.5';
    axis = typeof axis !== 'undefined' ? axis : 'y';
    const scrollTop = $(window).scrollTop();
    const offset = this.parent().offset();
    const moveValue = 0 - Math.round((offset.top - scrollTop) * momentum);
    if (axis === 'x') {
      this.velocity({
        translateX: moveValue + 'px'
      }, {
        queue: false,
        duration: 0
      });
    } else {
      this.velocity({
        translateY: moveValue + 'px'
      }, {
        queue: false,
        duration: 0
      });
    }
  };
  const PAEMoveParallaxLayers = function () {
    $('.parallax-layer').each(function () {
      if ($(this).inView(0)) {
        const momentum = $(this).data('parallax-momentum');
        const axis = $(this).data('parallax-axis');
        $(this).parallax(momentum, axis);
      }
    });
  };
  const PAEInitParallaxLayers = function () {
    PAEMoveParallaxLayers();
    $('.parallax-layer').velocity({
      opacity: 1
    }, {
      duration: 300
    });
    $(window).on('scroll', function () {
      PAEMoveParallaxLayers();
    });
  };

  // Make sure you run this code under Elementor.
  $(window).on('elementor/frontend/init', function () {
    // Initialize parallax.
    PAEInitParallaxLayers();
  });
})(jQuery);