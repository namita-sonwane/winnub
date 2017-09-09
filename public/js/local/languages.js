

var list_language=[];
 
 /**
  * 
  * @param {type} string
  * @returns {String}
  */
function t(chiave){
    
    if(list_language[chiave] === undefined){
        return chiave;
    }
    
    return list_language[chiave];
    
}


function addLang(string,value){
    
    list_language[string]=value;
    
}
