var on_adj = false;
function adj_height()
{
	try {
		if(on_adj) return;
		on_adj = true;
		var objs = document.getElementsByTagName("TABLE");
		var i;
		var last_i = 0;
		var top    = objs[last_i].offsetTop;
		if(top == 0) return;
		             objs[last_i].style.marginBottom = 0;
		var height = objs[last_i].offsetHeight;
		for(i = 0; i < objs.length; i++) {
			if(objs[i].offsetTop != top) {
				for(j = last_i; j < i; j++) {
					objs[j].style.marginBottom = ((height - objs[j].offsetHeight) + 5) + "px";
				}
				last_i = i;
				top    = objs[last_i].offsetTop;
				         objs[last_i].style.marginBottom = 0;
				height = objs[last_i].offsetHeight;
			}
			objs[i].style.marginBottom = 0;
			height = Math.max(height, objs[i].offsetHeight);
		}
		for(j = last_i; j < i; j++) {
			objs[j].style.marginBottom = ((height - objs[j].offsetHeight) + 5) + "px";
		}
	} catch(e) { }
	on_adj = false;
}
function adj_width()
{
	try {
		var obj = document.getElementById("conteudo");
		if(obj == null) return;
		if(obj.style.width == "") obj.style.width = "702px";
		if(obj.style.width.substr(0, obj.style.width.length - 2) == "702") {
			obj.style.width = "233px";
		} else {
			obj.style.width = "702px";
		}
		adj_height();
		if (window.getSelection){
			window.getSelection().removeAllRanges();
		} else if (document.getSelection) {
			document.getSelection().removeAllRanges();
		} else if (document.selection) {
			document.selection.empty();
		}
	} catch(e) { }
}
window.onload = adj_height;
window.onresize = adj_height;
document.ondblclick = adj_width;