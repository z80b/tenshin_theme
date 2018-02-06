import $ from 'jquery';
import Backbone from 'backbone';
import _ from 'underscore';

import PageView from './page-view';

$(document).ready(() => {
	window.page = new PageView({ el: '.js-lp-page' });	
})


