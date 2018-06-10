//FETCH GROUP NAME FROM DROP DOWN
var select = document.getElementsByClassName('expn_groups');
var ajax = new XMLHttpRequest(); 

// AJAX REQUEST
function request(){
	var option = select[0].selectedIndex;
	var grp_name = select[0][option].value;
	
	ajax.onreadystatechange = response;
	ajax.open('POST',"./js/ajaxresponse.php",true);
	ajax.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	ajax.send( "grp_name="+grp_name);
}

//AJAX RESPONSE 
function response(){
	if (ajax.readyState == 4) {
		if (ajax.status == 200) {
			var friends_names = JSON.parse(ajax.responseText);
			console.log(friends_names);
			var count_radio = friends_names.length;

			//Clear all radio button from container(DIV)
			rmradio();

			//Add label("Paid by:") before radio button 
			var radio_parent = document.getElementsByClassName('expn_radio');
			var label = document.createTextNode("Paid by:");
			radio_parent[0].appendChild(label);
			
			//CALL radio FUNCTION TO APPEND radio IN DIV
			while (count_radio > 0) {
				radio(friends_names[count_radio-1]["Name"],friends_names[count_radio-1]["Upr_id"]);
				count_radio--;
			}
		}
	}
}

//CREATE radio ELEMENTS
function radio(radio_name,radio_value){
	var input = document.createElement('input');
	input.type ="radio";
	input.className ="expn_radio";
	input.name ="expn_radio";
	input.value= radio_value;
	var radio_parent = document.getElementsByClassName('expn_radio');
	var text = document.createTextNode(radio_name);
	radio_parent[0].appendChild(input);				
	radio_parent[0].appendChild(text);
}

//REMOVE radio
function rmradio(){
	var radio_parent = document.getElementsByClassName('expn_radio');
	while (radio_parent[0].hasChildNodes()){
		radio_parent[0].removeChild(radio_parent[0].lastChild);
	}
}