
if (typeof ADMIN == 'undefined')
	ADMIN = {}

ADMIN.administrators = {
	delete_modal(obj){
		let id = obj.dataset.id
		let content = 
		'<h2>Удалить пользователя</h2>' +
		'<div class="dan_flex_row a_modal_button_center">' + 
			'<input id="a_modal_delete" class="dan_button_green" type="submit" name="submit" value="Удалить"> ' + 
			'<input id="a_modal_cancel" class="dan_button_white" type="button" name="cancel" value="Отменить">' + 
		'</div>'
		DAN.modal.add(content, 400)
		DAN.$('a_modal_cancel').onclick = DAN.modal.del
		DAN.$('a_modal_delete').onclick = ()=>{	
			let form = new FormData()
			form.append('id', id)
			DAN.ajax('/admin/administrators/delete', form, function(data){
				if (data.answer == 'success')
					document.location.href = '/admin/administrators'
				else
					DAN.modal.add('Не хватает прав')
			})
		}
	}
}
