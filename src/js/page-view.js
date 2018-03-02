import Backbone from 'backbone';
import VideoView from './video-view';
import HeadSlider from './head-slider';
import slick from './plugins/slick'

class PageView extends Backbone.View {
    constructor(props) {
        super(props);
    }

    get events() {
        return {
            'click .js-video-link': 'playVideo'
        }
    }

    initialize() {
        this.headSlider = new HeadSlider({ el: '.js-head-slider' });
        this.$('.js-video-slider').slick({
            infinite: true,
            slidesToShow: 5,
            slidesToScroll: 5,
            lazyLoad: 'ondemand',
            nextArrow: '.lp-videos__button--right',
            prevArrow: '.lp-videos__button--left'
        });

        this.popup = new VideoView({ el: '.js-popup' });
    }


    playVideo(event) {
        event.preventDefault();

        this.popup && this.popup.play({
            title: event.currentTarget.getAttribute('title'),
            url: event.currentTarget.getAttribute('data-embed-url')
        })
    }
}

export default PageView;