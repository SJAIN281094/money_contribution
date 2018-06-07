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
	if(ajax.readyState == 4){
		if(ajax.status == 200){
		var friends_names = JSON.parse(ajax.responseText);
		var count_checkbox = friends_names.length;

			//CLEAR ALL CHECKBOXES FROM DIV
			rmcheckbox();
			
			//CALL CHECKBOX FUNCTION TO APPEND CHECKBOX IN DIV
			while(count_checkbox>0){
			checkbox(friends_names[count_checkbox-1]["Name"]);
			count_checkbox--;
			
			}
		}
	}
}

//checkbox_parent = document.getElementsByClassName('expn_checkboxes');	
//var text = document.createTextNode("Select Friends:");
//checkbox_parent[0].appendChild(text);

//CREATE CHECKBOX ELEMENTS
function checkbox(chkbx_value){
var input = document.createElement('input');
input.type ="checkbox";
input.className ="expn_checkbox";
input.name ="expn_checkbox";
input.value= chkbx_value;
var checkbox_parent = document.getElementsByClassName('expn_checkboxes');
var text = document.createTextNode(chkbx_value);
checkbox_parent[0].appendChild(input);				
checkbox_parent[0].appendChild(text);
}

//REMOVE CHECKBOXEX
function rmcheckbox()
{
	var checkbox_parent = document.getElementsByClassName('expn_checkboxes');
	while (checkbox_parent[0].hasChildNodes()) 
		{
			checkbox_parent[0].removeChild(checkbox_parent[0].lastChild);
		}

}







