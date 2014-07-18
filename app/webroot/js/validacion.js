function isNumero(evt){
		if(window.event){// IE
			keynum = evt.keyCode;
		}else{
			keynum = evt.which;
		}
		//alert(keynum);
		if((keynum>47 && keynum<58) || keynum == 0 || keynum == 8){
			return true;
		}else{
			return false;
		}
	}

function isDecimal(evt){
	if(window.event){// IE
		keynum = evt.keyCode;
	}else{
		keynum = evt.which;
	}
	//alert(keynum);
	if((keynum>47 && keynum<58) || keynum == 0 || keynum == 8 || keynum == 44){
		return true;
	}else{
		return false;
	}
}

function isDecimalPunto(evt){
	if(window.event){// IE
		keynum = evt.keyCode;
	}else{
		keynum = evt.which;
	}
	//alert(keynum);
	if((keynum>47 && keynum<58) || keynum == 0 || keynum == 8 || keynum == 46){
		return true;
	}else{
		return false;
	}
}

function isCoordenada(evt){
	if(window.event){// IE
		keynum = evt.keyCode;
	}else{
		keynum = evt.which;
	}
	//alert(keynum);
	if((keynum>44 && keynum<58) || keynum == 0 || keynum == 8 || keynum == 43){
		return true;
	}else{
		return false;
	}
}

function isGradoLat(obj){
	if(obj.value < 0){
		obj.value = 0
	}
	if(obj.value >16){
		obj.value = 16
	}
	
}

function isGradoLon(obj){
	if(obj.value < 58){
		obj.value = 58
	}
	if(obj.value >74){
		obj.value = 74
	}
}

function isMin(obj){
	if(obj.value < 0 || obj.value >60){
		obj.value = 0
	}
}

function isSeg(obj){
	if(obj.value < 0 || obj.value >60){
		obj.value = 0
	}	
}

function lat2Us(val){
	val = val.replace(",",".");
	return val;
}

function showMensaje(mensaje){
	
$(document).ready(function() {
		$(".message").html(mensaje);
		$(".message").addClass("visible");
		$(".message").slideDown(1500, function(){
			setTimeout("$('.message').slideUp(1500);", 7000);
		});
		
	});
}


