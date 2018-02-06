import $ from 'jquery';
import Backbone from 'backbone';

class VideoView extends Backbone.View {
    constructor(props) {
        super(props);
    }

    get events() { return {
        'click': 'stop'
    }}

    play(props) {
        let $frame = $('<iframe/>')
            .addClass('lp-popup__frame')
            .attr({
                width: '640',
                height: '480',
                frameborder: 0,
                allowfullscreen: 0,
                src: props.url
            });

        this.$('.lp-popup__head').text(props.title);
        this.$('.lp-popup__body').html($frame);
        this.$el.css('display', 'block').removeClass('lp-popup--hidden');
    }

    stop(event) {
        event.preventDefault();
        this.$el.css('display', 'none').addClass('lp-popup--hidden');
        this.$('.lp-popup__head').text('');
        this.$('.lp-popup__body').empty();
    }
}

export default VideoView;