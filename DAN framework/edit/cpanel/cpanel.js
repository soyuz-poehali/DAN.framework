window.addEventListener('DOMContentLoaded', function(e){
	DAN.$('e_cpanel_open').onclick = EDIT.cpanel.open
	DAN.$('e_cpanel_close').onclick = EDIT.cpanel.close
	DAN.$('e_cpanel_blocks_code').onclick = ()=> EDIT.block.code.form()
	DAN.$('e_cpanel_blocks_php_code').onclick = ()=> EDIT.block.php_code.form()
	DAN.$('e_cpanel_css').onclick = EDIT.cpanel.css
	DAN.$('e_cpanel_help').onclick = EDIT.cpanel.help

	let icons = document.getElementsByClassName('e_cpanel_additional_add')
	for (i = 0; i < icons.length; ++i){
		icons[i].onclick = function(){
			let type = this.dataset.type
			EDIT.cpanel.additional(type)
		}
	}	
})


EDIT.cpanel = {
	additional(type){
		let form = new FormData()
		DAN.$('e_cpanel_additional').classList.add('expand')
		EDIT.ajax('/edit/block/' + type + '/cpanel', form, (data) => {
			DAN.$('e_cpanel_additional').innerHTML = data.content
			let items = document.getElementsByClassName('e_cpanel_additional_items')
			for (i = 0; i < items.length; ++i){
				items[i].onclick = function(){
					let type = this.dataset.type
					let style_id = this.dataset.style
					EDIT.cpanel.block_insert(type, style_id)
				}
			}
		})
	},


	block_insert(type, style_id) {
		let form = new FormData()
		form.append('p', EDIT.p)
		form.append('style_id', style_id)
		DAN.modal.spinner()
		EDIT.ajax('/edit/block/' + type + '/insert', form, (data) => {
			if (data.answer == 'success'){
				DAN.modal.del()
				EDIT.cpanel.close()
				let b = DAN.$('blocks');
				b.insertAdjacentHTML('beforeEnd', data.content)
				DAN.jumpTo('block_' + data.id, 500)
				EDIT.block.initialize()
			}
		})
	},


	close(){
		DAN.$('e_cpanel').classList.remove('expand')
		DAN.$('e_cpanel_additional').innerHTML = '';
		DAN.$('e_cpanel_additional').classList.remove('expand')
		DAN.$('e_cpanel_open').style.display = 'block'
	},


	open(){
		DAN.$('e_cpanel_open').style.display = 'none'
		DAN.$('e_cpanel').classList.add('expand')
	},


	css(){
		let form = new FormData()
		form.append('p', EDIT.p)
		EDIT.ajax('/edit/css/edit', form, (data) => {
			DAN.modal.add(data.content, 800, '100%')
			let code = document.getElementById("e_css_code")
			if (code) {
			    let CM = CodeMirror.fromTextArea(code, {
					mode: "css",
					lineNumbers: true,
					styleActiveLine: true,
					indentWithTabs: true,
					indentUnit: 4,
					matchBrackets: true
			    });
			    CM.setOption("theme", "dan")

				DAN.$('e_modal_submit').onclick = () => {
					let form = new FormData()
					form.append('p', EDIT.p)
					form.append('code', CM.getValue())
					EDIT.ajax('/edit/css/save', form, (data) => {})
				}
			}
			DAN.$('e_modal_cancel').onclick = DAN.modal.del
		})	
	},


	help(){
		let form = new FormData()
		EDIT.ajax('/edit/help/mainpage', form, (data) => {
			DAN.modal.add(data.content)
		})
	}
}