if (typeof ADMIN == 'undefined')
    ADMIN = {}

window.addEventListener('load', function(e){
	ADMIN.metaTags.title();
	ADMIN.metaTags.description();
});


ADMIN.metaTags = {
	description: function(){
		var description = document.getElementById('meta_description_input');

		description.onkeyup = function(){
			ADMIN.metaTags.descriptionLength(description);
		}

		description.onchange = function(){
			ADMIN.metaTags.descriptionLength(description);
		}
	},

	descriptionLength: function(_description){
		var num = document.getElementById('meta_description_num');

		if(_description.value.length < 50 || _description.value.length > 270){
			num.style.color = '#ff0000';
		} else {
			if(_description.value.length > 140) num.style.color = '#000000';
				else num.style.color = '#00a000';			
		}

		num.innerHTML = 270 - _description.value.length;
	},	

	title: function(){
		var title = document.getElementById('meta_title_input');

		title.onkeyup = function(){
			ADMIN.metaTags.titleLength(title);
		}

		title.onchange = function(){
			ADMIN.metaTags.titleLength(title);
		}
	},

	titleLength: function(_title){
		var num = document.getElementById('meta_title_num');

		if(_title.value.length < 20 || _title.value.length > 60){
			num.style.color = '#ff0000';
		} else {
			num.style.color = '#00a000';			
		}

		num.innerHTML = 60 - _title.value.length;
	}
}