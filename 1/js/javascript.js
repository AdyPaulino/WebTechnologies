window.onload = function(){
	$('buttonOrder').onclick = function(){
		//e.preventDefault();
		//if(validateAll()){
			$('order').submit();
		//} else {
		//	return false;
	//	}
		
	}; 
    
    /*$('order').submit(function(e){
        e.preventDefault();
        alert('got it');
    }); */
	
	$('inputPostalCode').onblur = function(){
		$('inputPostalCode').value = $('inputPostalCode').value.toUpperCase();
	};

}