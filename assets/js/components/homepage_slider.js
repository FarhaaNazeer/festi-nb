import Swiper, { Navigation, Scrollbar, Lazy, Mousewheel} from "swiper";
Swiper.use([Navigation, Scrollbar, Mousewheel]);

import 'swiper/css';
import 'swiper/css/navigation';


let homepageSlider = () => {

    let self = {};
    let slider = document.querySelector('.js-homepage-slider');
    Swiper.use([Navigation]);

    self.init = () => {
        if (slider) {
            const swiper = new Swiper('.js-homepage-slider', {
                modules: [Navigation, Scrollbar, Lazy, Mousewheel],
                loop: true,
                speed: 600,
                direction: 'horizontal',
                slidesPerView: 1,
                mousewheel: {
                    forceToAxis: true,
                },
                lazy: {
                    loadPrevNext: true,
                    loadOnTransitionStart: true
                },
                // If we need pagination
                pagination: {
                    dynamicBullets: true,
                    el: '.swiper-pagination',
                },

                // Navigation arrows
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },

                // And if we need scrollbar
                scrollbar: {
                    el: '.swiper-scrollbar',
                },
            });
        }
    };

    return self;
}

homepageSlider().init();
