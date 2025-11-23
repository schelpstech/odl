function getclass() {
        var str='';
        var val=document.getElementById('class-list');
        for (i=0;i< val.length;i++) { 
            if(val[i].selected){
                str += val[i].value + ','; 
            }
        }         
        var str=str.slice(0,str.length -1);
        
	$.ajax({          
        	type: "GET",
        	url: "ajax/getcourselist.php",
        	data:'class_id='+str,
        	success: function(data){
        		$("#sbj-list").html(data);
        	}
	});
}