window.addEventListener('load', ()=>{
	EDIT.block.initialize()
	// Для перехода к блоку после загрузки страницы
	let anchor = localStorage.getItem('anchor')
	if (anchor) {
		localStorage.removeItem('anchor')
		DAN.jumpTo(anchor, 500)
	}
});

EDIT.block = {
	settings: {},
	settings_old: {},

	// Отслеживает события на иконках с указанным классом и вызывает функцию по типу
	ico(class_name) {
		let obj = document.getElementsByClassName(class_name)

		for (let i = 0; i < obj.length; i++) {
			obj[i].onclick = (event)=>{
				event.preventDefault()
				event.stopPropagation()

				if (EDIT.obj) 
					EDIT.editorDestroy()

				objClick = EDIT.getElement(event, class_name); // получаем узел с указанным классом по которому был вызван контекстный клик

				let block_action = objClick.getAttribute("data-action")

				// Редактируемым объектом является ближайший родительский узел с атрибутом 'data-block'
				EDIT.obj = EDIT.block.get_edit_obj(objClick)
				let block_type = EDIT.obj.getAttribute('data-block')
				let id = EDIT.obj.getAttribute('data-id')

				console.log(block_type + ' ' + block_action + ' ' + id)

				if(block_action == 'up' || block_action == 'down') 
					EDIT.block[block_action](id)		
				else 
					EDIT.block[block_type][block_action](id) // Обращается к методу через квадратные скобки
			}
		}
	},
	
	
	get_edit_obj(obj) {
		while (obj) {
			if (obj.getAttribute('data-block')) 
				return obj;
			obj = obj.parentElement;
		}
		return false;		
	},	


	down(id) {
		let next = EDIT.obj.nextElementSibling
		if (!next || next.id == 'e_cpanel') {
			alert('Ниже опустить блок уже некуда.\nКапитан, мы на самом дне!')
			EDIT.obj = false
			return
		}

		next.insertAdjacentElement('afterend', EDIT.obj)
		EDIT.obj = false
		DAN.jumpTo('block_' + id, 500)

		let form = new FormData()
		form.append('id', id)
		form.append('p', EDIT.p)

		EDIT.ajax('/edit/block/down', form, EDIT.status)
	},


	// Инициализация функции
	initialize() {
		EDIT.block.ico('e_block_panel_ico')
		DRAG_DROP()
	},


	// Выбирает страницу или блок
	link_select() {
		// Выбрать страницу
		let but_pages = DAN.$('e_block_modal_ico_but_pages')
		but_pages.onclick = ()=>{
			let pages_out = DAN.$('e_block_modal_pages_out')
			pages_out.style.display = 'block'

			let pages_arr = pages_out.getElementsByClassName('e_block_modal_pages_item')

			for (i = 0; i < pages_arr.length; i++) {
				pages_arr[i].onclick = (e)=>{
					let page_url = e.target.getAttribute('data-url')
					DAN.$('e_block_modal_link').value = '/' + page_url
					pages_out.style.display = 'none'
				}
			}
		}
		
		// Выбрать блок
		let but_block = DAN.$('e_block_modal_ico_but_blocks')
		but_block.onclick = (e)=>{
			e.stopPropagation()
			DAN.$('dan_modal_black').style.display = 'none'
			window.addEventListener('click', EDIT.block.link_block);
		}
	},


	// Ставим ссылку на блок #block_id
	link_block(e) {
		e.stopPropagation
		e.preventDefault
		let block = EDIT.getElement(e, 'block')

		window.removeEventListener('click', EDIT.block.video.link_block)
		
		// Перебираем все блоки, находим на каком месте стоит наш блок, получаем цвет его фона
		let block_arr = document.getElementsByClassName('block')

		for (i = 0; i < block_arr.length; i++) {
			if (block_arr[i].id == block.id) {
				DAN.$('dan_modal_black').style.display = 'flex'
				DAN.$('e_block_modal_link').value = '#' + block.id
				return
			}
		}
	},


	// Обновляет позицию вывода блоков, где r = {target_id, object_id, ordering}
	update_ordering(r){
		let items = document.getElementsByClassName('block')
		let ids = []

		// На сайте есть блоки обратный звонок, наверх - они сквозные и не должны участвовать в расчёте ordering
		for (var i = 0; i < items.length; i++) {
			if (items[i].classList.contains('block_menu') || items[i].classList.contains('block_callback') ||  items[i].classList.contains('block_buttonup'))
				continue
			ids.push(items[i].dataset.id)
		}

		let form = new FormData()
		form.append('ids', ids)
		form.append('p', EDIT.p)

		EDIT.ajax('/edit/block/update_ordering', form, function(data){
			if (data.answer == 'success'){
				EDIT.status(true)
			}
			else{
				EDIT.errLog('Ошибка')
				alert('Ошибка сохранения данных')						
			}
		})
	},


	up(id) {
		let previous = EDIT.obj.previousElementSibling
		if (!previous || EDIT.obj.previousElementSibling.dataset.block == 'menu') {
			alert('Выше поднять блок уже некуда.\nВыше - только звёзды и меню сайта!')
			EDIT.obj = false
			return
		}

		previous.insertAdjacentElement('beforebegin', EDIT.obj)
		EDIT.obj = false
		DAN.jumpTo('block_' + id, 500)

		let form = new FormData()
		form.append('id', id)
		form.append('p', EDIT.p)

		EDIT.ajax('/edit/block/up', form, EDIT.status)
	}
}