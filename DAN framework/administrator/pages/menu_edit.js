window.addEventListener('DOMContentLoaded', ()=>{
	DAN.$('menu_link_type').onchange = ADMIN.pages.select_type
	ADMIN.pages.select_type()
})

if (typeof ADMIN == 'undefined')
	ADMIN = {}

ADMIN.pages = {
	select_type(e){
		let type = DAN.$('menu_link_type').value
		if (type == 'page' || type == 'catalog') {
			DAN.$('menu_pages_container').style.display = 'flex'
			DAN.$('menu_link_container').style.display = 'none'
		} else if (type == 'link') {
			DAN.$('menu_link_container').style.display = 'flex'
			DAN.$('menu_pages_container').style.display = 'none'	
		}
	}
}