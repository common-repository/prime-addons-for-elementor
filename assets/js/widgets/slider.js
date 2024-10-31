"use strict";

const PAESlider = function ($wrapper) {
  const swiperLoader = (swiperElement, swiperConfig) => {
    if ('undefined' === typeof Swiper) {
      const asyncSwiper = elementorFrontend.utils.swiper;
      return new asyncSwiper(swiperElement, swiperConfig).then(newSwiperInstance => {
        return newSwiperInstance;
      });
    }
    return swiperPromise(swiperElement, swiperConfig);
  };
  const swiperPromise = (swiperElement, swiperConfig) => {
    return new Promise(resolve => {
      const swiperInstance = new Swiper(swiperElement, swiperConfig);
      resolve(swiperInstance);
    });
  };
  const autoplay = $wrapper.data('autoplay');
  const swiperConfig = {
    preloadImages: false,
    autoHeight: false,
    slidesPerView: 1,
    lazy: true,
    spaceBetween: 0,
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev'
    },
    pagination: {
      el: '.swiper-pagination',
      type: 'bullets',
      clickable: true
    },
    onLazyImageLoaded() {
      $wrapper.find('.swiper-lazy-preloader').hide();
    }
  };
  if ('yes' === autoplay) {
    swiperConfig.autoplay = {
      delay: 3000
    };
  }
  $wrapper.imagesLoaded(function () {
    $wrapper.fadeIn();
    swiperLoader($wrapper, swiperConfig);
  });
};
class SliderWidgetHandlerClass extends elementorModules.frontend.handlers.Base {
  getDefaultSettings() {
    return {
      selectors: {
        mainWrapper: '.pae-swiper-slider'
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
    PAESlider(this.elements.$mainWrapper);
  }
}
jQuery(window).on('elementor/frontend/init', () => {
  const addSliderWidgetHandler = $element => {
    elementorFrontend.elementsHandler.addHandler(SliderWidgetHandlerClass, {
      $element
    });
  };
  elementorFrontend.hooks.addAction('frontend/element_ready/pae-global-block-slider.default', addSliderWidgetHandler);
  elementorFrontend.hooks.addAction('frontend/element_ready/pae-post-slider.default', addSliderWidgetHandler);
  elementorFrontend.hooks.addAction('frontend/element_ready/pae-picture-slider.default', addSliderWidgetHandler);
});