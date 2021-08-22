
if (typeof ADMIN == 'undefined')
	ADMIN = {}

ADMIN.pages = {
	page_edit(obj) {
		document.location.href = '/admin/pages/page_edit/' + obj.dataset.page_id
	},

	page_delete_modal(obj){
		let id = obj.dataset.id
		let content = 
		'<h2>Удалить страницу</h2>' +
		'<div class="a_modal_button_center">' + 
			'<a href="/admin/pages/page_delete/' + id + '" class="dan_button_green">Удалить</a>' + 
			'<input id="a_modal_cancel" class="dan_button_white" type="button" name="cancel" value="Отменить">' + 
		'</div>'
		DAN.modal.add(content, 400)
		DAN.$('a_modal_cancel').onclick = DAN.modal.del
	},

	menu_delete_modal(obj){
		let id = obj.dataset.id
		let content = 
		'<h2>Удалить menu</h2>' +
		'<div class="a_modal_button_center">' + 
			'<a href="/admin/pages/menu_delete/' + id + '" class="dan_button_green">Удалить</a>' + 
			'<input id="a_modal_cancel" class="dan_button_white" type="button" name="cancel" value="Отменить">' + 
		'</div>'
		DAN.modal.add(content, 400)
		DAN.$('a_modal_cancel').onclick = DAN.modal.del
	}
}
