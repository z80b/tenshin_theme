class Test extends Backbone.View {
	constructor() {
		super();
		this.name = 'Ha-ha';
	}

	say(word) {
		alert(word);
	}
}

export default Test;