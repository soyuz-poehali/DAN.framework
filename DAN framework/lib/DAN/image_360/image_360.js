// Copyright Domnenko A. N. (DAN), domnenko@gmail.com, http://63s.ru
// Для вращения в одной плоскости - изображения должны иметь наименования от 0.jpg до n.jpg, где n - номер последнего изображения
// Для вращения в 2 плоскостях - изображения должны иметь такую нумерацию от 0_0.jpg до n_m.jpg, где n, m - номера последних изображений в соответстующих плоскостях
if (typeof DAN == 'undefined') {
    DAN = {}
}

window.addEventListener('DOMContentLoaded', function(){
	/*
	DAN.image_360.init()
	window.addEventListener('resize', function(){
		DAN.image_360.get_container_size()
	});
	window.addEventListener('scroll', function(){
		DAN.image_360.get_container_size()
	});
	*/
});


class DAN_image_360 {
	constructor(container_id=false, image_id=false, path=false, n_count=false, m_count=false){
		this.options = {
			container_id: container_id || 'dan_image_360',  // #Id контейнера в html
			image_id: image_id || 'dan_image_360_img',  // Изображение
			path: path || '/files/image_360/',  // Путь до файлов
			type: '3',  // type: 2x | 2у | 3. Вращение в 2 или 3x осях
			n_start: false,  // Начало позиции n, по умолчанию - берётся с середины
			m_start: false,  // Начало позиции m
			n_count: n_count || 9,  // Количество изображений в n плоскости
			m_count: m_count || 18,  // Количество изображений в m плоскости
			mode: 'play',  // Режим работы play (автоматически) / over (при наведении) / drag (перетащить)
			mobile: false,  // Если мобильное устройство - деактивируем меню
			direction: 'normal',  // normal / x-reverse - направление вращения
			play_direction: 'all',  // all / x - направление вращение all - по всем осям / x - только по x
		}
		this.container = false  // Главный контейнер
		this.container_width = 0  // Ширина контейнера 
		this.container_height = 0  // Высота контейнера
		this.container_left = 0  // Позиция слева
		this.container_top = 0  // Позиция сверху
		this.image = false // Изображение вывода
		this.image_wrap = false  // Слой, в котором выводится изображение
		this.image_arr = []  // Массив изображений
		this.current = {  // Текущее изображение
			n: 0,  // Номер ячейки в строке
			m: 0  // Номер ямейки в колонке
		},
		this.indicator = false  // Индикатор
		this.indicator_value = false  // Узел вывода значения индиватора
		this.image_loading_completed = false
		this.center = false  // Кнопка play, move, stop
		this.zoom = 1  // Размер увеличения
		this.fullscreen = false  // Обычный экран / полный экран
		this.animation_interval = 120  // Интервал анимации в микросекундах
		this.timer = false  // Номер счётчика анимации
		this.touch_dist_start = false  // Начальное расстояние щипка

		// Создадим двумерный массив изображений
		if (this.options.type == '3') {
			for (let i = 0; i < this.options.n_count; i++) {
				this.image_arr[i] = []
			}
		}

		this.m_move = this.mousemove.bind(this)  // bind(this) - указывает на контекст this класса. 
		this.m_down = this.mousedown.bind(this)	 // нельзя напрямую вызвать и удалить в обработчике, потому что fn.bind(this) != fh.bind(this)
		this.m_up = this.mouseup.bind(this)
	}

	// Инициализация
	start(){
		window.addEventListener('resize', ()=>this.get_container_size());
		window.addEventListener('scroll', ()=>this.get_container_size());

		// Запоминаем размеры контейнера
		this.container = DAN.$(this.options.container_id)
		if (!this.container) {
			console.log('Контейнер', this.options.container_id, ' не найден')
			return			
		}
		this.container.className = 'dan_image_360'

		this.image = DAN.$(this.options.image_id)
		if (!this.image) {
			console.log('Изображение не найдено')
			return			
		}
		this.image.className = 'dan_image_360_img'

		// Создаём слой вывода изображений
		this.image_wrap = document.createElement('div')
		this.image_wrap.className = 'dan_image_360_wrap_img'
		this.container.appendChild(this.image_wrap)
	
		// Проверка типа
		let type_arr = ['2x', '2y', '3'];
		if (!type_arr.includes(this.options.type)) {
			alert('Неверно указан тип')
			return
		}

		if (this.image_loading_completed) {
			this.get_container_size()
			if (!this.options.mobile)  // На мобильных устройствах не показываем меню
				this.control()
			this.touch()  // На мобильнике
			this.mode_over()  // Режим 'over' при загрузке
		} else {
			// Загрузка изображений
			this.indicator_create()  // Создаём индикатор
			this.load_images(true, ()=>{
				// ЗАГРУЗКА ЗАВЕРШЕНА
				// Устанавливаем начальные значения
				this.current.n = this.options.n_start ? this.options.n_start : Math.round(this.options.n_count/2) - 1
				this.current.m = this.options.m_start ? this.options.m_start : Math.round(this.options.m_count/2) - 1

				// Удаляем индикатор загрузки
				this.indicator.remove()

				// Скрываем фоновую фотографию
				this.image.style.opacity = 0

				this.container.addEventListener('mouseenter', ()=>this.mouseenter())  // Попадание курсора в пределы поля (отменяется при действии в меню)
				if (!this.options.mobile) {  // На мобильных устройствах не показываем меню
					let control_wrap = document.getElementsByClassName('dan_image_360_control_wrap')
					let indicator_div = document.getElementsByClassName('dan_image_360_indicator')
					if (control_wrap.length == 0 && indicator_div.length == 0) {  // Меню ещё не выведено и индикатор удалён (2 экземпляр класса не запущен)
						this.control()
					}
				}

				this.get_container_size()  // Вычисляем размеры контейнера после загрузки всех изображений. К этому моменту - загрузится основное
				this.touch()  // Обработка сенсорного экрана

				// Вывод изображения на случай работы в режиме 'over' или 'drag'
				this.image_wrap.innerHTML = ''
				this.image_wrap.appendChild(this.image_arr[this.current.n][this.current.m])

				if (this.options.mode == 'over')
					this.mode_over()

				if (this.options.mode == 'drag')
					this.mode_drag()

				if (this.options.mode == 'play')
					this.mode_play()
			})			
		}
		// f_name = 'load_images_' + this.options.type
		// this[f_name]()
	}

	// Создаём индикатор`
	indicator_create(){
		this.indicator = document.createElement('div')
		this.indicator.className = 'dan_image_360_indicator'

		let indicator_cube_wrap = document.createElement('div')
		indicator_cube_wrap.className = 'dan_image_360_indicator_cube_wrap'

		let indicator_cube = document.createElement('div')
		indicator_cube.className = 'dan_image_360_indicator_cube'

		let indicator_cube_front = document.createElement('div')
		indicator_cube_front.className = 'dan_image_360_indicator_cube_front'
		indicator_cube_front.innerHTML = '360°'

		let indicator_cube_top = document.createElement('div')
		indicator_cube_top.className = 'dan_image_360_indicator_cube_top'
		indicator_cube_top.innerHTML = '360°'

		let indicator_cube_back = document.createElement('div')
		indicator_cube_back.className = 'dan_image_360_indicator_cube_back'
		indicator_cube_back.innerHTML = '360°'

		let indicator_cube_bottom = document.createElement('div')
		indicator_cube_bottom.className = 'dan_image_360_indicator_cube_bottom'
		indicator_cube_bottom.innerHTML = '360°'

		let indicator_cube_left = document.createElement('div')
		indicator_cube_left.className = 'dan_image_360_indicator_cube_left'
		indicator_cube_left.innerHTML = '360°'

		let indicator_cube_right = document.createElement('div')
		indicator_cube_right.className = 'dan_image_360_indicator_cube_right'
		indicator_cube_right.innerHTML = '360°'

		this.indicator_value = document.createElement('div')
		this.indicator_value.className = 'dan_image_360_indicator_value'

		indicator_cube.appendChild(indicator_cube_front)
		indicator_cube.appendChild(indicator_cube_back)
		indicator_cube.appendChild(indicator_cube_top)
		indicator_cube.appendChild(indicator_cube_bottom)
		indicator_cube.appendChild(indicator_cube_left)
		indicator_cube.appendChild(indicator_cube_right)
		indicator_cube_wrap.appendChild(indicator_cube)
		this.indicator.appendChild(indicator_cube_wrap)
		this.indicator.appendChild(this.indicator_value)

		if (this.container) {
			this.container.appendChild(this.indicator)
		}		
	}

	// Счётчик загрузки изображений
	indicator_counter(){
		let num = this.current.n * this.options.m_count + this.current.m + 1
		let count = this.options.n_count * this.options.m_count
		let percent = Math.round(100*num/count)
		this.indicator_value.innerHTML = percent
	}

	// Загрузка изображений
	load_images(indicator=false, callback_f=false){
		if (this.current.n >= this.options.n_count) {
			if (callback_f)
				callback_f()
			return			
		}

		let image = document.createElement('img');
		let image_name = this.current.n + '_' + this.current.m + '.jpg'

		image.src = this.options.path + image_name
		image.graggable = 'false'

		// console.log(image.src)

		if (this.options.direction == 'normal')
			this.image_arr[this.current.n][this.options.m_count - 1 - this.current.m] = image

		if (this.options.direction == 'x-reverse')
			this.image_arr[this.current.n][this.current.m] = image

		if (indicator)
			this.indicator_counter()

		image.onload = ()=>{
			this.current.m++
			if (this.current.m < this.options.m_count) {
				this.count++
				this.load_images(indicator, callback_f)
			} else {
				this.current.m = 0  // Переводим на новую строку - начинаем с нуля
				this.current.n++
				if (this.current.n < this.options.n_count) {
					this.load_images(indicator, callback_f)				
				} else {
					// Загрузка завершена
					this.image_loading_completed = true
					if (callback_f)
						callback_f()
				}
			}
		}

		image.onerror = ()=>{
			alert('Ошибка загрузки изображения')
			return
		}
	}	

	// Расчёт размера контейнера для расчёта матрицы
	get_container_size(){
		this.container_width = this.container.getBoundingClientRect().width
		this.container_height = this.container.getBoundingClientRect().height
		this.container_left = this.container.getBoundingClientRect().left
		this.container_top = this.container.getBoundingClientRect().top
	}

	// Создаём панель контроля навигации
	control(){
		let control_wrap = document.createElement('div')
		control_wrap.className = 'dan_image_360_control_wrap'

		// Главная кнопка панели
		let main = document.createElement('div')
		main.className = 'dan_image_360_control_main'
		control_wrap.appendChild(main)

		// Открывающаяся панель
		let open_panel = document.createElement('div')
		open_panel.className = 'dan_image_360_control_open_panel'
		control_wrap.appendChild(open_panel)

		// Кнопка наверх
		let up = document.createElement('div')
		up.className = 'dan_image_360_control_up'
		open_panel.appendChild(up)	

		// Кнопка налево
		let left = document.createElement('div')
		left.className = 'dan_image_360_control_left'
		open_panel.appendChild(left)

		// Кнопка play, move, stop
		this.center = document.createElement('div')
		this.center.className = 'dan_image_360_control_center play'
		open_panel.appendChild(this.center)

		// Кнопка направо
		let right = document.createElement('div')
		right.className = 'dan_image_360_control_right'
		open_panel.appendChild(right)

		// Кнопка вниз
		let down = document.createElement('div')
		down.className = 'dan_image_360_control_down'
		open_panel.appendChild(down)

		// Кнопка увеличения
		let plus = document.createElement('div')
		plus.className = 'dan_image_360_control_plus'
		open_panel.appendChild(plus)

		// Кнопка уменьшения
		let minus = document.createElement('div')
		minus.className = 'dan_image_360_control_minus'
		open_panel.appendChild(minus)

		// Кнопка полный экран
		let full = document.createElement('div')
		full.className = 'dan_image_360_control_full'
		open_panel.appendChild(full)

		if (this.container) {
			this.container.appendChild(control_wrap)
		}

		main.onclick = ()=>{
			this.container.removeEventListener('mouseenter', ()=>this.mouseenter())
			this.set_mode('drag')
			main.classList.toggle('active')
			open_panel.classList.toggle('active')
		}

		this.center.onclick = ()=>{
			if (this.options.mode == 'play') {
				this.set_mode('drag')
				return
			}

			if (this.options.mode == 'drag') {
				this.set_mode('over')
				return
			}

			if (this.options.mode == 'over') {
				this.set_mode('play')
				return
			}
		}
		
		up.onclick = ()=>{
			let n = this.current.n - 1
			let m = this.current.m
			this.control_check(n, m)
		}
		
		down.onclick = ()=>{
			let n = this.current.n + 1
			let m = this.current.m
			this.control_check(n, m)
		}
		
		left.onclick = ()=>{
			let n = this.current.n
			let m = this.current.m - 1
			this.control_check(n, m)	
		}
		
		right.onclick = ()=>{
			let n = this.current.n
			let m = this.current.m + 1
			this.control_check(n, m)	
		}

		plus.onclick = ()=>{
			this.zoom += 0.2
			this.set_zoom()
		}

		minus.onclick = ()=>{
			this.zoom -= 0.1
			this.set_zoom()
		}

		full.onclick = ()=>{		
			if (!this.container.fullscreen) {
				// Режим полного экрана
				this.container.fullscreen = true
				if (this.container.requestFullscreen) {
					this.container.requestFullscreen();
				} else if (this.container.mozRequestFullScreen) { /* Firefox */
					this.container.mozRequestFullScreen();
				} else if (this.container.webkitRequestFullscreen) { /* Chrome, Safari and Opera */
					this.container.webkitRequestFullscreen();
				} else if (this.container.msRequestFullscreen) { /* IE/Edge */
					this.container.msRequestFullscreen();
				}
			} else {
				// Режим обычного экрана
				this.container.fullscreen = false
				if (document.exitFullscreen) {
					document.exitFullscreen();
				} else if (document.mozCancelFullScreen) { /* Firefox */
					document.mozCancelFullScreen();
				} else if (document.webkitExitFullscreen) { /* Chrome, Safari and Opera */
					document.webkitExitFullscreen();
				} else if (document.msExitFullscreen) { /* IE/Edge */
					document.msExitFullscreen();
				}			
			}
		}
	}

	// Проверка выхода за диапазон и зацикливание переходов
	control_check(n, m){
		if (n < 0)
			n = this.options.n_count - 1
		if (m < 0)
			m = this.options.m_count - 1
		if (n >= this.options.n_count)
			n = 0
		if (m >= this.options.m_count)
			m = 0
		this.set_mode('drag')
		this.output(n, m)
	}

	// Установка масштаба увеличения
	set_zoom(){
		this.set_mode('drag')
		if (this.zoom > 2)
			this.zoom = 2
		if (this.zoom < 0.7)
			this.zoom = 0.7
		this.image_wrap.style.transform = 'scale(' + this.zoom + ')'
	}

	// Установка режима работы
	set_mode(type){
		if (!this.center)
			return

		this.options.mode = type
		if (type == 'play') {
			this.center.classList.remove('pause')
			this.center.classList.remove('over')
			this.center.classList.add('play')
			this.mode_play()
			return
		}		
		
		if (type == 'drag') {
			this.center.classList.remove('play')
			this.center.classList.remove('over')
			this.center.classList.add('pause')
			this.mode_drag()
			return
		}

		if (type == 'over' ) {
			this.center.classList.remove('play')
			this.center.classList.remove('pause')
			this.center.classList.add('over')
			this.mode_over()
			return
		}
	}

	// Режим работы - при наведении
	mode_over() {
		this.container.removeEventListener('mousedown', this.m_down)
		this.container.removeEventListener('mouseup', this.m_up)	
		this.container.addEventListener('mousemove', this.m_move)  // Перетаскивание
	}

	// Режим работы - перетаскивание
	mode_drag() {
		this.container.removeEventListener('mousemove', this.m_move)
		this.container.addEventListener('mousedown', this.m_down.bind(this))
		this.container.addEventListener('mouseup', this.m_up.bind(this))	
	}

	// Автоматическое проигрывание анимации
	mode_play() {
		this.container.removeEventListener('mousemove', this.m_move)
		clearTimeout(this.timer)  // Очищаем таймер, что бы не было двойного наложения

		this.timer = setTimeout(()=>{
			this.current.m++

			// Направление вращения по всем осям
			if (this.options.play_direction == 'all') {
				// Если выходим за границу строки - начинаем с 0-й позиции следующей строки
				if (this.current.m >= this.options.m_count) {
					this.current.m = 0
					this.current.n++
				}
			}

			if (this.options.play_direction == 'x') {
				// Если выходим за границу строки - начинаем с 0-й позиции текущей строки
				if (this.current.m >= this.options.m_count)
					this.current.m = 0
				this.current.n = Math.round(this.options.n_count/2) - 1
			}

			// Если выходим за последнюю строку - нечинаем с нулевой строки
			if (this.current.n >= this.options.n_count) {
				this.current.n = 0
			}

			this.image_wrap.innerHTML = ''
			this.image_wrap.appendChild(this.image_arr[this.current.n][this.current.m])

			requestAnimationFrame(()=>{
				if (this.options.mode == 'play') {
					this.mode_play()
				}
			})
		}, this.animation_interval)
	}

	// Попадание курсора в пределы поля
	mouseenter(){
		if (this.options.mode == 'play') // Только для режима автоматического проигрывания мы ставим переход в режим 'over'
			this.set_mode('over')
	}

	mousedown(e){
		e.preventDefault()
		this.container.addEventListener('mousemove', this.m_move)		
	}

	mouseup(e){
		e.preventDefault()
		this.container.removeEventListener('mousemove', this.m_move)
	}

	mousemove(e){
		// console.log('MOVE, e.pageY = ', e.pageY, '; container_top = ', this.container_top, '; window.pageYOffset = ', window.pageYOffset, ';')
		let x = e.pageX - this.container_left - window.pageXOffset
		let y = e.pageY - this.container_top - window.pageYOffset
		if (x < 0)
			x = 0
		if (x > this.container_width)
			x = this.container_width
		if (y < 0)
			y = 0
		if (y > this.container_height)
			y = this.container_height

		// Находим квадрат матрицы
		this.calculation(x, y)
	}

	// Обработка нажатий сенсорного устройства
	touch(){
		this.container.addEventListener('touchstart', (e)=>{
			this.set_mode('drag')
			var tt = e.targetTouches;
			if (tt.length >= 2) {
				this.touch_dist_start = this.touch_pinch_distance(tt[0], tt[1]);
			}
		})

		this.container.addEventListener('touchmove', (e)=>{
			var tt = e.targetTouches;
			if (tt.length >= 2) {
				// Если есть щипотка - режим увеличения
				let zoom = this.touch_pinch_distance(tt[0], tt[1]) / this.touch_dist_start
				this.zoom *= zoom
				this.set_zoom()
			} else {
				// Режим вращения
				let x = e.touches[0].pageX - this.container_left - window.pageXOffset
				let y = e.touches[0].clientY - this.container_top - window.pageYOffset
				this.calculation(x, y)
			}
		})
	}

	// Рачёт растояния между точками щипка
	touch_pinch_distance(t_1, t_2){
		return (Math.sqrt(Math.pow((t_1.clientX - t_2.clientX), 2) + Math.pow((t_1.clientY - t_2.clientY), 2)));
	}

	// Расчёт`
	calculation(x, y){
		// console.log('x, y', x, y)
		let k_m = this.container_width/this.options.m_count
		let k_n = this.container_height/this.options.n_count
		let m = Math.floor(x/k_m)
		let n = Math.floor(y/k_n)
		this.output(n, m)
	}

	// Вывод изображения
	output(n, m){
		if (n < 0)
			n = 0
		if (m < 0)
			m = 0
		if (n >= this.options.n_count)
			n = this.options.n_count - 1
		if (m >= this.options.m_count)
			m = this.options.m_count - 1

		// console.log('n, m', n, m)

		this.current.n = n
		this.current.m = m
		this.image_wrap.innerHTML = ''
		this.image_wrap.appendChild(this.image_arr[n][m])
	}
}
