(function($){
	
	  $.fn.extend({
		    
		  componentSelect:function(){
		    	
			   var $form = $(this);
			   
			   var $formAction = $form.attr('action');
			  
			   $form.find('input[class=confirmSelectButton]').click(function(){
				
				   var inputSelect = $form.find('input:checked[name=element_id]').attr('value');
				   
				   if(inputSelect==undefined){
					   alertMsg.error('请选择为布局容器选择一个内容组件');
				   }
				   else if(!isNaN(inputSelect)){
					   
					   var options = new Object();
					   options['data'] = new Object();
					   options['data']['container_id'] = $form.find('input:hidden[name=container_id]').attr('value');
					   options['data']['element_id']   = $form.find('input:checked[name=element_id]').attr('value');
					   options['data']['title']   = 'sssss';
					   
					   navTab.reload($formAction , options);
					
				   }
				
			   });
			   
           }//function Gauge() end
	  
	  
	 });//$.fn.extend  function end
	
	
	
})(jQuery)