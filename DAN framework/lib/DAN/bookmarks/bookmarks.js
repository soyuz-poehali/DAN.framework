window.addEventListener('DOMContentLoaded', function(){
	DAN,bookmarks()
});

DAN,bookmarks = ()=> {
	let heads = document.getElementsByClassName('dan_bookmark_head')
	let bookmark_bodys = document.getElementsByClassName('dan_bookmark_body')
	let last_head = heads[0]
	let last_body = bookmark_bodys[0]

	for (var i = 0; i < heads.length; i++) {
	 	heads[i].onclick = (e)=>{
	 		if (e.target == last_head)
	 			return
			e.target.classList.add('active')
			last_head.classList.remove('active')
			last_head = e.target
	 		let bookmark_body = document.getElementById(e.target.dataset.id)
	 		bookmark_body.classList.add('active')
	 		last_body.classList.remove('active')
	 		last_body = bookmark_body
	 	}
	 } 
}