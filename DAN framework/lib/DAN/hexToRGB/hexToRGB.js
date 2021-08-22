DAN.hexToRGB = function(hex, opacity){
	hex = hex.replace('#','')
	r = parseInt(hex.substring(0,2), 16)
	g = parseInt(hex.substring(2,4), 16)
	b = parseInt(hex.substring(4,6), 16)

	result = 'rgba('+r+','+g+','+b+','+opacity+')'
	return result
}


DAN.rgbToHex = function(col) { 
	if (col.charAt(0) == 'r'){ 
		col = col.replace ('rgb(', '').replace (')', '').split (',')
		let r = parseInt(col[0], 10).toString (16) 
		let g = parseInt(col[1], 10).toString (16)
		let b = parseInt(col[2], 10).toString (16)
		r = r.length == 1 ? '0' + r : r ; g = g.length == 1 ? '0' + g : g ; b = b.length == 1 ? '0' + b : b
		var colHex = '#' + r + g + b
		return colHex
	} 
}