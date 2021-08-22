if (typeof DAN == 'undefined') {
    DAN = {}
}

window.addEventListener('DOMContentLoaded', function(){
	DAN.tooltip()
});


DAN.tooltip = ()=> {
	let dan_tooltip = document.getElementsByClassName('dan_tooltip');
	for (var i = 0; i < dan_tooltip.length; i++) {
		dan_tooltip[i].onclick = (e)=>{
			let content = '<div id="dan_tooltip">' + e.target.innerHTML + '</div>'
			DAN.modal.add(content)
		}
	}
}