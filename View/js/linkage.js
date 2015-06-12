// 获得源
function getdoc(){
	var xhr='';
	if(window.XMLHttpRequest){
		xhr = new XMLHttpRequest();
	}else{
		xhr = new ActiveXObject("Microsoft.XMLHTTP");
	}
	xhr.open("GET","linkage.xml",false);
	xhr.send();
	return xhr.responseXML;
}

// 省change时
function provices(e){
	var doc = getdoc();
	var provice = doc.getElementsByTagName('provice');
	var poscity = document.getElementById('city');
	var poscountry = document.getElementById('country');
	poscity.innerHTML = '<option value="0">请选择市</option>' + common(provice,e.value);
	poscountry.innerHTML = '<option value="0">请选择县</option>';
}
// 共同方法
function common(sea,neddle){
	var res = '';
	for(var i = 0; i < sea.length; i++ ){
		if(sea[i].attributes[0].value == neddle){
			var currsea = sea[i].childNodes;
			for (var j = 0; j < currsea.length; j++) {
				var name = currsea[j].attributes[0].value;
				res = res + '<option value="'+name+'">'+name+'</option>';
			}
			return res;
		}
	}
}

// 加载城市
function citys(e){
	var doc = getdoc();
	var provice = doc.getElementsByTagName('provice');
	var poscountry = document.getElementById('country');
	var currprovice = document.getElementById('provice').value;

	for (var i = provice.length - 1; i >= 0; i--) {
		if(provice[i].attributes[0].value == currprovice){
			return poscountry.innerHTML = '<option value="0">请选择县</option>' + common(provice[i].childNodes,e.value);
		}
	};
}

// 加载省
window.onload = function(){
	var doc = getdoc();
	var provice = doc.getElementsByTagName('provice');
	var res = '<option value="0">请选择省</option>';
	for (var i = 0; i < provice.length; i++) {
		var v = provice[i].attributes[0].value;
		res = res + '<option value="'+v+'">'+v+'</option>';
	};
	document.getElementById('provice').innerHTML = res;
}

