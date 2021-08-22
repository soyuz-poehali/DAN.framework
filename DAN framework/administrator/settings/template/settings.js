document.addEventListener("DOMContentLoaded", function(event) {
	DAN.$('favicon_button').onclick = ADMIN.favicon_form
});

ADMIN = {
	favicon_form () {
		let content =
		'<h2>Загрузить favicon.ico</h2>' +
		'<div class="dan_flex_row">' + 
			'<div class="modal_left">Файл favicon</div>' + 
			'<div class="modal_right"><input id="modal_file" type="file" name="file"></div>' + 
		'</div>' +
		'<div class="dan_flex_row">' + 
			'<div class="modal_left"><input id="modal_submit" class="dan_button_green" type="submit" name="submit" value="Сохранить"></div>' + 
			'<div class="modal_right"><input id="modal_cancel" class="dan_button_white" type="submit" value="Отменить"></div>' + 
		'</div>'
		DAN.modal.add(content)

		// Отправить данные методом POST
		DAN.$('modal_submit').onclick = ADMIN.favicon_update
		DAN.$('modal_cancel').onclick = DAN.modal.del
		DAN.$('modal_file').onchange = (e) => ADMIN.check_file(e.target)
	},

	// отправляем данные на IMAGE_RESIZE
	check_file(obj){
		favicon_file = obj.files[0]

		if (favicon_file.name != 'favicon.ico'){
			alert('Должен быть выбран файл favicon.ico')
			return false
		}

		return true
	},

	favicon_update() {
		let modal_file = DAN.$('modal_file')

		if (!ADMIN.check_file(modal_file))
			return

		favicon_file = modal_file.files[0]

		let form = new FormData()
		form.append('favicon_file', favicon_file)

		DAN.ajax('/admin/settings/favicon_update', form, function(data){
			let html = ''
			if (data.message = 'success') {
				html = 
				'<h2>Файл сохранён</h2>' +
				'<div style="text-align:center;">Для просмотра обновите кеш - CTRL + F5</div>'
			} else
				html = '<h2>Ошибка загрузки</h2>'

			DAN.modal.add(html)
		})
	}
}