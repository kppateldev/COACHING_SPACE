coaching_space_app = {
	baseURL: function(){
		return $('base').attr('href');
	},
	getToken: function(){
		return $('meta[name="csrf-token"]').attr('content');
	},
	ajaxRequest: function (reqURL,reqData,reqMethod = "",reqDataType = "") {
		return axios({
		    baseURL: mechanech_app.baseURL(),
		    url: reqURL,
		    method: (reqMethod != "") ? reqMethod : "post",
		    headers: {'Content-Type': (reqDataType != "") ? reqDataType : "application/x-www-form-urlencoded"},
		    data: reqData,
			async: false,
		});
	},
	notifyWithtEle: function(msg, type, pos, timeout){
		pos = "";
		timeout = "";
		var noty = new Noty({
			theme: 'metroui',
			text: msg,
			type: type,
			layout: (pos != "") ? pos : 'topRight',
			timeout: (timeout != "") ? timeout : 3000,
			progressBar: false,
			closeWith: ['click'],
			killer: true,
		});
		noty.show();
	},
}
// $('.mobile-filter-menu').on('click', function() {
// 		if($('body').hasClass('layout-fullwidth')) {
// 			$('body').addClass('layout-fullwidth');
			

// 		} else {
// 			$('body').removeClass('layout-fullwidth');
			
// 		}
// 	});

$(function () {
	
	
	//toggle two classes on button element
    $('.mobile-filter-menu').on('click',function () {
        $('body').toggleClass('open-mobile-filter-sidebar');
    });
});

// $('.mobile-filter-menu').click(function(){
//   $('body').toggleClass('red');
// });