"use strict";

(function ($) {
  class GridWidgetHandlerClass extends elementorModules.frontend.handlers.Base {
    getDefaultSettings() {
      return {
        selectors: {
          mainWrapper: '.pae-grids'
        }
      };
    }
    getDefaultElements() {
      const selectors = this.getSettings('selectors');
      return {
        $mainWrapper: this.$element.find(selectors.mainWrapper)
      };
    }
    bindEvents() {
      let $grid = this.elements.$mainWrapper;
      const isInfinite = $grid.data('infinite');
      const gridDependedScripts = function () {
        // Reset thumbnail height for grid layout.
        if ($grid.hasClass('pae-grid-container')) {
          $grid.find('.pae-grid-thumbnail a.grid-thumbnail').css('height', $grid.data('thumbnail-height'));
        }
      };
      if ($grid.hasClass('pae-masonry-container')) {
        // Init Isotope.
        $grid = this.elements.$mainWrapper.isotope({
          itemSelector: '.pae-grid-item',
          percentPosition: true,
          layoutMode: 'masonry'
        });

        // layout Isotope after each image loads
        $grid.imagesLoaded().progress(function () {
          $grid.isotope('layout');
        });
      }
      if ('yes' === isInfinite) {
        $grid.infiniteScroll({
          path: '.next',
          history: false,
          append: false,
          hideNav: '.pae-pagenavi',
          status: '.page-load-status',
          debug: false
        });
        $grid.on('load.infiniteScroll', function (event, response) {
          // Get posts from response.
          const $newItems = $(response).find('.pae-grid-item');

          // Append Items to Masonry Layout.
          if ($(this).hasClass('pae-masonry-container')) {
            // Append posts after images loaded.
            $grid.infiniteScroll('appendItems', $newItems).isotope('appended', $newItems);
            $grid.imagesLoaded().progress(function () {
              $grid.isotope('layout');
            });
          }

          // Append Items to Grid Layout.
          if ($grid.hasClass('pae-grid-container')) {
            $grid.infiniteScroll('appendItems', $newItems);
          }

          // Excute scripts after new item appended.
          gridDependedScripts();
        });
      }
      gridDependedScripts();
    }
  }
  jQuery(window).on('elementor/frontend/init', () => {
    const addGridWidgetHandler = $element => {
      elementorFrontend.elementsHandler.addHandler(GridWidgetHandlerClass, {
        $element
      });
    };
    elementorFrontend.hooks.addAction('frontend/element_ready/pae-woo-products.default', addGridWidgetHandler);
    elementorFrontend.hooks.addAction('frontend/element_ready/pae-edd-products.default', addGridWidgetHandler);
    elementorFrontend.hooks.addAction('frontend/element_ready/pae-lp-courses.default', addGridWidgetHandler);
    elementorFrontend.hooks.addAction('frontend/element_ready/pae-blog-masonry.default', addGridWidgetHandler);
  });
})(jQuery);