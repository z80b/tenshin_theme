import $ from 'jquery';
import Backbone from 'backbone'

class HeadSlider extends Backbone.View {
    constructor(props) {
        super(props);
    }

    initialize() {
        this.maxIndex = this.$el.find('.lp-slider__item').length - 1;
        this.$prevButton = this.$el.find('.lp-slider__button-prev');
        this.$nextButton = this.$el.find('.lp-slider__button-next');
        this.$el.find('.js-slider-button').on('click', this.buttonCLick.bind(this));
        this.timer = setInterval(this.switchToNext.bind(this), 5000);
    }

    buttonCLick(event) {
        let index = $(event.target).data('slide');
        this.switchByIndex(index);
    }

    switchToNext() {
        let index = this.$nextButton.data('slide');
        this.switchByIndex(index);
    }

    switchByIndex(index) {
        this.$(`.lp-slider__body .lp-slider__item:eq(${index})`)
            .addClass('lp-slider__item--active')
            .siblings()
            .removeClass('lp-slider__item--active');

        this.$(`.lp-slider__controls .lp-slider__button:eq(${index})`)
            .addClass('lp-slider__button--active')
            .siblings()
            .removeClass('lp-slider__button--active');

        this.$nextButton.data('slide', index >= this.maxIndex ? 0 : index + 1);
        this.$prevButton.data('slide', index <= 0 ? this.maxIndex : index - 1);
    }
}

export default HeadSlider;