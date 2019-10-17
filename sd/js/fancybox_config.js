$(document).ready(function() {
			$(".textfile").fancybox({
			maxWidth	: 800,
			maxHeight	: 700,
			fitToView	: false,
			width		: '70%',
			height		: '70%',
			autoSize	: false,
			closeClick	: false,
			transitionIn	: 'elastic',
			transitionOut	: 'elastic',
		    	helpers :{
				title : {
    			type : 'inside'
		    	}
			},
			afterLoad : function() {
				this.title = (this.title ? '<br/><b>' + this.title + "</b>" : '');
			}

	});
});