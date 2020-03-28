// JavaScript Document
//全选、反选、批量操作
function SelectAll(action,formid,inputid){ 
    var testform=document.getElementById(formid); 
    for(var i=0 ;i<testform.elements.length;i++){ 
        if(testform.elements[i].type=="checkbox"){ 
            e=testform.elements[i]; 
			if(e.id==inputid)
			{
            if(action=="selectAll")e.checked=1;
			else if(action=="")e.checked=!e.checked;
			else if(action=="selectNo")e.checked=0;
			}
        } 
    }     
}

//批量操作时判断是否选择数据
function checkdelform(formid,inputid){
	var testform=document.getElementById(formid); 
    for(var i=0 ;i<testform.elements.length;i++){if(testform.elements[i].type=="checkbox"){e=testform.elements[i]; if(e.checked==1&&e.id==inputid) return true;}}
	alert('您没有选择任何数据');return false;
}

//删除前提示
function ask(url){if(confirm('您确定要删除吗？'))location=url;}

//设置COOKIE
function setCookie(name,value,second) {
	var exp = new Date(); 
	exp.setTime(exp.getTime() + second*1000); 
	document.cookie = name + "="+ escape (value) + ";expires=" + exp.toGMTString(); 
}
	
//取出COOKIE
function getCookie(name) {  
    var arr,reg=new RegExp("(^| )"+name+"=([^;]*)(;|$)"); 
    if(arr=document.cookie.match(reg)) return unescape(arr[2]); 
    else return null; 
}