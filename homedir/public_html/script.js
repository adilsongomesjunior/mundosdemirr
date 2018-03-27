function popup(url, width, height)
{
	ok = true;

	window.open(url, "popup", "width=" + width + ",height=" + height + ",scrollbars=1");

	return ok;
}

function album_foto(href, target)
{
	var target = ( document.getElementById ? document.getElementById(target) : null );
	if(target == null) return false;
	target.innerHTML = '<img src="' + href + '" />';
	return true;
}

function show_hide(id)
{
	var obj = document.getElementById(id);
	if(obj) {
		if(!obj.style) obj.style = obj;
		if(obj.style.display == "none") {
			obj.style.display = "block";
		} else {
			obj.style.display = "none";
		}
	}
}