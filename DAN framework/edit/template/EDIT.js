var BLOCK = {}

var EDIT = {
	block: {},
	obj: false,
	url: document.location.pathname.slice(1),


	ajax(url, form = false, callback) {
		let req = new XMLHttpRequest()
		req.open('post', url, true);
		req.send(form)
	
		req.onreadystatechange = () => {
			if (req.readyState == 4 && req.status == 200) {
				DAN.modal.del();
				console.log(req.responseText)
				var data = JSON.parse(req.responseText)

				if (data.answer == 'success') {
					callback(data)
				} else if (data.answer == 'error') {
					DAN.modal.add(data.message)
				} else if (data.answer == 'reload') {
					if (data.url || data.url == '') 
						EDIT.url = data.url
					if (data.id) 
						localStorage.setItem('anchor', 'block_' + data.id)
					if(EDIT.url) 
						document.location.href = '/' + EDIT.url
					else 
						document.location.href = '/'
				} else {
					EDIT.errLog('Ошибка EDIT.ajax => ' + req.responseText)
				}
			}
		}		
	},


	// Получаем элемент на котором отслеживаем клик
	getElement(event, class_name) {
		let objParent = event.target
		while (objParent) {
			if (objParent == document) 
				return false;
			if (objParent.classList.contains(class_name))
				return objParent
			objParent = objParent.parentNode
		}
		return false
	},


	editor() {
		EDIT.obj.contentEditable = 'true'
		EDIT.obj.id = 'e_editor'
		EDIT.obj.content_old = EDIT.obj.innerHTML

		// Подключаем визуальный редактор
		CKEDITOR.disableAutoInline = true
		EDIT.obj.focus()

		EDIT.ckeditor = CKEDITOR.inline('e_editor', {
			toolbarGroups: [
			    {name: 'clipboard', groups: ['clipboard', 'undo']},
			    {name: 'links'},
			    {name: 'insert'},
			    '/',
			    { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
			    { name: 'paragraph',   groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ] },
			    '/',
			    {name: 'styles'},
			    {name: 'colors'},
			],

			startupFocus: true,
			
			on: {instanceReady: function (event) {
					EDIT.content_old = CKEDITOR.instances.e_editor.getData()
				}
			}
		})
	},


	editorDestroy() {
		// Удаляем с таймаутом, т.к. ещё какие-то события могут прослушиваться
		//setTimeout(function(){EDIT.ckeditor.destroy();}, 100);
		if(EDIT.ckeditor) EDIT.ckeditor.destroy();

		EDIT.obj.contentEditable = 'false';
		EDIT.obj.id = '';
		EDIT.obj = false;	
	},


	errLog(err){
		console.log('ОШИБКА: ' + err)
	},


	status(type = true){
		let class_panel = type ? 'e_save_ok' : 'e_save_err'
		DAN.$('e_cpanel_open').classList.add(class_panel);
		setTimeout(function (){
			DAN.$('e_cpanel_open').classList.remove(class_panel
		)}, 1000);		
	},


	status_line(message = 'off'){
		if (message == 'off') {
			if (DAN.$('e_status_line')) 
				document.body.removeChild(DAN.$('e_status_line'))
		} else {
			var status_line = document.createElement('div');
			status_line.id = 'e_status_line';
			if (!DAN.$('e_status_line')) 
				document.body.insertBefore(status_line, document.body.children[0]);
			status_line.innerHTML = message;			
		}
	},	
}