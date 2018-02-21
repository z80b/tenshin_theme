import $ from 'jquery';
import Backbone from 'backbone';

class VideoView extends Backbone.View {
    constructor(props) {
        super(props);
    }

    initialize() {
        this.$head = this.$el.find('.lp-popup__head');
        this.$body = this.$el.find('.lp-popup__body');
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

        this.$head.text(props.title);
        this.$body.html($frame);
        this.$el.css('display', 'block');
        setTimeout(() => this.$el.removeClass('lp-popup--hidden'), 100);
    }

    stop(event) {
        event.preventDefault();
        this.$el.addClass('lp-popup--hidden');
        setTimeout(() => this.$el.css('display', 'none'), 500);
        this.$head.text('');
        this.$body.empty();
    }
}

export default VideoView;