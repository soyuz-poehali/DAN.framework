/*
window.addEventListener('DOMContentLoaded', function(){
	DAN.popup.init()
});
*/


DAN.popup = {
	init(class_name, content, width=200, height=300, position='align_right'){
		let items = document.getElementsByClassName(class_name);
		for (var i = 0; i < items.length; i++) {
			if (type_click == 'right') {
				items[i].oncontextmenu = function(e){
					DAN.popup.out(e, class_name, content);
				}
			}
			if (type_click == 'left'){
				items[i].onclick = function(e){
					DAN.popup.out(e, class_name, content);
				}
			}
		}		
	},

	out(obj_click, content, width=300, height=400, position='align_right'){
		// e.stopPropagation();

		// Защита от повторного контекстного окна, при повторном контекстном клике - удаляем это контекстное меню и создаём новое.
		if (DAN.$('dan_popup') != null)
			return

		// Получаем узел с указанным классом по которому был вызван контекстный клик
		let obj_click_position = obj_click.getBoundingClientRect()	

		// Считаем в какой позиции вывести окно
		var popup_position_top = 0;
		var popup_position_left = 0;


		switch (position) {
			case 'align_right':
				popup_position_top = obj_click_position.bottom;
				popup_position_left = obj_click_position.right - width;
				break
			default:
				popup_position_top = obj_click_position.bottom;
				popup_position_left = obj_click_position.right;
		}

		// Создаем popup
		let popup = document.createElement('div');
		popup.id = 'dan_popup';

		if (height > 0)
			popup.style.height = height + "px"

		popup.style.width = width + "px"
		popup.style.top = popup_position_top + "px"
		popup.style.left = popup_position_left + "px"

		document.body.insertAdjacentElement('afterbegin', popup);
		popup.innerHTML = content

		popup.onclick = (e) => {
			e.stopPropagation()
		}


		// Создаем слой для закрытия
		let svg = '<svg id="dan_popup_close"><use xlink:href="/lib/svg/sprite.svg#delete"></use></svg>'

		popup.insertAdjacentHTML('afterbegin', svg);
		let dan_popup_close = DAN.$("dan_popup_close");

		dan_popup_close.onclick = DAN.popup.del

		// Навешиваем закрытие на window
		window.addEventListener('click', () => {
			DAN.popup.del()
		});

	},


	// Получаем элемент на котором отслеживаем клик
	get_element(e, class_name){
		var obj_parent = e.target;

		while (obj_parent) {
			if (obj_parent.classList.contains(class_name))
				return obj_parent
			obj_parent = obj_parent.parentNode;
		}
		return false;
	},


	// Удаляем попап
	del() {
		var node = document.getElementById('dan_popup');
		if (node)
			document.body.removeChild(node);
	},
}