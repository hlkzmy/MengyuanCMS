function ajaxGetJsonData(PostData,PostURL,CallBack,dataType,ErrorMsg){
    	
    	$.ajax({
    		type:'POST',
    		async:false,
    		url:PostURL,
    		data:PostData,
    		dataType:dataType||"json",
    		cache:false,
    		success:CallBack,
    		error:ErrorMsg||{}
    	});
    
}//function ajaxGetJsonData() end

function showErrorMessage(msg){
	alert(msg);
	
}//function showErrorMessage() end

function navTabAjaxDone(json){

    DWZ.ajaxDone(json);

    if (json.statusCode == DWZ.statusCode.ok){

          if (json.navTabId){ //把指定navTab页面标记为需要“重新载入”。注意navTabId不能是当前navTab页面的

                navTab.reloadFlag(json.navTabId);

          } else { //重新载入当前navTab页面

                navTabPageBreak();
          }
          

          if ("closeCurrent" == json.callbackType) {

                setTimeout(function(){navTab.closeCurrentTab();}, 100);

          } else if ("forward" == json.callbackType) {

                navTab.reload(json.forwardUrl);

          }

    }

}

