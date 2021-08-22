window.addEventListener('DOMContentLoaded', function(){
	DAN.$('page_url').oninput = ADMIN.page.check_url
});

if (typeof ADMIN == 'undefined')
	ADMIN = {}

ADMIN.page = {
	check_url(e){
		id = e.target.dataset.id
		url = e.target.value

		if (url.length == 0)
			return

		let form = new FormData()
		form.append('id', id)	
		form.append('url', url)
		DAN.ajax('/admin/pages/page_check_url', form, function(data){
			DAN.$('a_page_url_message').innerHTML = data.message
		})
	}
}