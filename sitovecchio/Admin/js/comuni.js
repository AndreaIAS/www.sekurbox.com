var xmlHttp = getXmlHttpObject();

function loadList(tb, id){
xmlHttp.open('GET','request.php?table='+tb+'&id='+id, true);
xmlHttp.onreadystatechange = stateChanged;
xmlHttp.send(null);
}


function addOption(select, value, text) {
	//Aggiunge un elemento <option> ad una lista <select>
	var option = document.createElement("option");
	option.value = value,
	option.text = text;
	try {
		select.add(option, null);
	} catch(e) {
		//Per Internet Explorer
		select.add(option);
	}
}
function deleteOption(select) {
var limite = select.length;
for(i=0; i < limit; i++) {
	select.remove(i);
	}
}


function addText(value,text){
	//Aggiunge testo ad una input type text
	document.getElementById('cap').value=text;
	
	}
	
function getSelected(select) {
	//Ritorna il valore dell'elemento <option> selezionato in una lista
	return select.options[select.selectedIndex].value;
}

function stateChanged() {
	if(xmlHttp.readyState == 4) {
		//Stato OK
		if (xmlHttp.status == 200) {
			var resp = xmlHttp.responseText;
			if(resp) {
				//Le coppie di valori nella striga di risposta sono separate da ;
				var values = resp.split(';');
				//Il primo elemento è l'ID della lista.
				var listId = values.shift();
				if (listId!='cap'){
					var select = document.getElementById(listId);
					//Elimina i valori precedenti
					while (select.options.length) {
						select.remove(0);
					} 
					
					if(listId == 'regioni') {
						addOption (select, 0, '-- Selezionare regione --');
					}
					if(listId == 'province') {
						addOption (select, 0, '-- Selezionare provincia --');
						/*
						var select = document.getElementById('comuni');
						deleteOption(select);
						*/
					}
					if(listId == 'comuni') {
						addOption (select, 0, '-- Selezionare comune --');
					}
					var limit = values.length;
					for(i=0; i < limit; i++) {
						var pair = values[i].split('|');
						//aggiunge un elemento <option>
						addOption(select,pair[0], pair[1]);
					}
				}
				else
				{
					var limit = values.length;
					for(i=0; i < limit; i++) {
						var pair = values[i].split('|');
						//riempie la textbox cap
						addText(pair[0], pair[1]);
					}
				}
				
			}
		} else {
			alert(xmlHttp.responseText);
		}
	}
}

function getXmlHttpObject()
{
  var xmlHttp=null;
  try
    {
    // Firefox, Opera 8.0+, Safari
    xmlHttp=new XMLHttpRequest();
    }
  catch (e)
    {
    // Internet Explorer
    try
      {
      xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
      }
    catch (e)
      {
      xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
      }
    }
  return xmlHttp;
}