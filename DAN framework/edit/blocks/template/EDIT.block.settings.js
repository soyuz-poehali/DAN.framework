EDIT.block.settings = {
	container() {	
		DAN.$('e_block_modal_bg_type').onchange = set_type
		set_type()

		function set_type(){		
			let bg_type = DAN.$('e_block_modal_bg_type').value
			let bg_mannuale_container = DAN.$('e_block_modal_container_bg_color_mannuale')
			let bg_image_container = DAN.$('e_block_modal_container_bg_image')
			let bg_image_input = DAN.$('e_block_modal_container_bg_color_input')

			switch(bg_type){
				case '1': out = '<table class="e_table_admin"><tr>' + 
					'<td class="e_td_right">Цвет 1 из настроек сайта</td>' + 
					'<td><div id="e_block_modal_bg_color_var" style="background-color: var(--color-1)">&nbsp;</div></td>' + 
					'</tr></table>'
					bg_mannuale_container.style.display = 'none'
					bg_image_container.style.display = 'none'					
					EDIT.obj.style.backgroundImage = ''					
					EDIT.obj.style.backgroundSize = ''
					EDIT.obj.style.backgroundPosition = ''
					EDIT.obj.style.setProperty('background-color', 'var(--color-1)')
					break

				case '2': out = '<table class="e_table_admin"><tr>' + 
					'<td class="e_td_right">Цвет 2 из настроек сайта</td>' + 
					'<td><div id="e_block_modal_bg_color_var" style="background-color: var(--color-2)">&nbsp;</div></td>' + 
					'</tr></table>'
					bg_mannuale_container.style.display = 'none'
					bg_image_container.style.display = 'none'
					EDIT.obj.style.backgroundImage = ''					
					EDIT.obj.style.backgroundSize = ''
					EDIT.obj.style.backgroundPosition = ''
					EDIT.obj.style.setProperty('background-color', 'var(--color-2)')				
					break

				case '3': out = '<table class="e_table_admin"><tr>' + 
					'<td class="e_td_right">Цвет 3 из настроек сайта</td>' + 
					'<td><div id="e_block_modal_bg_color_var" style="background-color: var(--color-3)">&nbsp;</div></td>' + 
					'</tr></table>'
					bg_mannuale_container.style.display = 'none'
					bg_image_container.style.display = 'none'
					EDIT.obj.style.backgroundImage = ''					
					EDIT.obj.style.backgroundSize = ''
					EDIT.obj.style.backgroundPosition = ''
					EDIT.obj.style.setProperty('background-color', 'var(--color-3)')
					break

				case 'c': out = ''
					bg_mannuale_container.style.display = 'table'
					bg_image_container.style.display = 'none'
					EDIT.obj.style.backgroundImage = ''					
					EDIT.obj.style.backgroundSize = ''
					EDIT.obj.style.backgroundPosition = ''
					EDIT.obj.style.backgroundColor = bg_image_input.value
					break

				case 'i': out = ''
					bg_mannuale_container.style.display = 'none'
					bg_image_container.style.display = 'table'
					EDIT.obj.style.backgroundColor = ''
					if (EDIT.obj.style.backgroundSize == '' || EDIT.obj.style.backgroundSize == 'cover') 
						DAN.$('e_block_modal_bg_image_size_1').checked = 'checked'
					else 
						DAN.$('e_block_modal_bg_image_size_2').checked = 'checked'
					

					// Загружает и размещает изображение фона
					DAN.$('e_block_modal_bg_image_file').onchange = function(){
						var img_files = this.files
						var bg_img = img_files[0]
						
						if(bg_img.size > 500000){
							alert('Изображение слишком большое. Сайт будет грузиться долго.')
							return;
						}

						if (DAN.$('e_block_modal_bg_image_size_1').checked) 
							EDIT.obj.style.backgroundSize = 'cover'
						else 
							EDIT.obj.style.backgroundSize = ''
					
						var reader = new FileReader()
						reader.onload = function(_src){		
							EDIT.obj.style.backgroundImage = 'url(' + _src.target.result + ')';	
						}	
						reader.readAsDataURL(bg_img);
					}
					
					// Растянуть / повторить изображение
					DAN.$('e_block_modal_bg_image_size_1').onclick = function(){
						EDIT.obj.style.backgroundSize = 'cover'
						EDIT.obj.style.backgroundPosition = 'center'
					}

					DAN.$('e_block_modal_bg_image_size_2').onclick = function(){
						EDIT.obj.style.backgroundSize = ''
						EDIT.obj.style.backgroundPosition = 'center'
					}
					break

				default: out = ''
					bg_mannuale_container.style.display = 'none'
					bg_image_container.style.display = 'none'
					EDIT.obj.style.backgroundColor = ''						
					EDIT.obj.style.backgroundImage = ''					
					EDIT.obj.style.backgroundSize = ''
					EDIT.obj.style.backgroundPosition = ''
					break
			}

			// Изображение фона
			bg_image_input.oninput = ()=>{
				EDIT.obj.style.backgroundColor = bg_image_input.value
			}

			// Цвет фона - строка в модальном окне
			DAN.$('e_block_modal_container_bg_color').innerHTML = out			
		}
	},


	font(){
		let font_select = DAN.$('e_block_modal_font_select')
		let font_size = DAN.$('e_block_modal_font_size')
		let font_color = DAN.$('e_block_modal_font_color')
		let line_height = DAN.$('e_block_modal_line_height')

		// Переключение размер цвет - из настроек / свой
		font_select.onchange = set_type
		set_type()

		// Размер шрифта
		font_size.oninput = ()=>{
			EDIT.obj.style.fontSize = font_size.value + 'px'
		}

		// Цвет шрифта
		font_color.oninput = ()=>{
			EDIT.obj.style.color = font_color.value
		}

		// Оптображение значения ползунка межстрочного интервала

		line_height.onmousemove = function(){
			DAN.$('e_block_modal_line_height_out').innerHTML = line_height.value
			EDIT.obj.style.lineHeight = (+ line_height.value)
		}


		// Установка типа отображения - из настроек сайта или собственное значение
		function set_type() {
			if (font_select.value == 's') {
				DAN.$('e_block_modal_font_tr').style.display = 'none'
				EDIT.obj.style.fontSize = 'var(--font-size)'
				EDIT.obj.style.color= 'var(--font-color)'
			} else {
				DAN.$('e_block_modal_font_tr').style.display = 'table-row'
			}

			EDIT.obj.style.lineHeight = (+ line_height.value)
			DAN.$('e_block_modal_line_height_out').innerHTML = line_height.value
		} 
	},


	// Установка размера
	size(){
		let wrap_width = DAN.$('e_block_modal_max_width')
		let wrap_margin = DAN.$('e_block_modal_margin')
		let wrap_padding = DAN.$('e_block_modal_padding')

		wrap_width.oninput = () => {
			w = wrap_width.value == 100 ? '100%' : wrap_width.value + 'px'
			EDIT.obj.childNodes[1].style.maxWidth = w
		}

		wrap_margin.oninput = () => {
			EDIT.obj.childNodes[1].style.margin = wrap_margin.value + 'px auto'		
		}

		wrap_padding.oninput = () => {
			EDIT.obj.childNodes[1].style.padding = wrap_padding.value + 'px'	
		}
	},


	// Функция работы с подложкой
	wrap(){
		// Ползунок прозрачности
		let wrap_opacity = DAN.$('e_block_modal_wrap_opacity')
		DAN.$('e_block_modal_wrap_opacity_out').innerHTML = wrap_opacity.value

		// Вкл / выкл цвет подложки
		DAN.$('e_block_modal_wrap_bg_color_check').onclick = set_color
		set_color()

		function set_color() {
			if (DAN.$('e_block_modal_wrap_bg_color_check').checked) {
				DAN.$('e_block_modal_wrap_opacity_tr').style.display = 'table-row'
				DAN.$('e_block_modal_wrap_bg_color').style.display = 'inline-block'
				
				let opacity = wrap_opacity.value/100
				let hex = DAN.$('e_block_modal_wrap_bg_color').value

				EDIT.obj.childNodes[1].style.backgroundColor = DAN.hexToRGB(hex, opacity)
			} else {
				DAN.$('e_block_modal_wrap_bg_color').style.display = 'none'
				DAN.$('e_block_modal_wrap_opacity_tr').style.display = 'none'
				EDIT.obj.childNodes[1].style.backgroundColor = ''
			}
		}

		// Устанавливает цвет подложки
		DAN.$('e_block_modal_wrap_bg_color').oninput = () => {
			EDIT.obj.childNodes[1].style.backgroundColor = DAN.$('e_block_modal_wrap_bg_color').value
		}

		// Ползунок прозрачности
		wrap_opacity.onmousemove = () => {
			DAN.$('e_block_modal_wrap_opacity_out').innerHTML = wrap_opacity.value

			let opacity = wrap_opacity.value/100
			let hex = DAN.$('e_block_modal_wrap_bg_color').value

			EDIT.obj.childNodes[1].style.backgroundColor = DAN.hexToRGB(hex, opacity)
		}
	},


	// Инициализация функций
	init(){
		if (DAN.$('e_block_modal_container')) 
			EDIT.block.settings.container()

		if (DAN.$('e_block_modal_wrap')) 
			EDIT.block.settings.wrap()	

		if (DAN.$('e_block_modal_size')) 
			EDIT.block.settings.size()

		if (DAN.$('e_block_modal_font')) 
			EDIT.block.settings.font()
	},
}