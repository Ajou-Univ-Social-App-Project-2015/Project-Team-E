var loc;//current location
var gmarker;
var address="모임 위치(지도)";
var selectedPartyId;
var selectedPartyDate;
var selectedPartyLocExp;
var selectedPartyExp;
var selectedPartyInterests;
var selectedPartyName;
var selectedPartyMembers;
var selectedPartyNumber;
var selectedPartyLoc;
var whatparty; 
    
 var navbar =  '<div data-role="navbar" class="ui-navbar" role="navigation"><ul class="ui-grid-b"><li class="ui-block-a"><a href="#partypage"  data-inline="true"data-theme="e" class="ui-link ui-btn ui-btn-e">정보</a></li><li class="ui-block-b"><a href="#boardpage?id='+selectedPartyId+'" data-inline="true" data-theme="e" class="ui-link ui-btn ui-btn-e" id="btn_board">게시판</a></li><li class="ui-block-c"><a href="#memberpage" data-inline="true"data-theme="e" class="ui-link ui-btn ui-btn-e" id="btn_memberpage">멤버</a></li></ul></div>';  


var deleteparty ='<form method="post" action="remove_party.php" data-ajax="false"><input data-mini="true" type="submit" name="removesubmit" id="removesubmit" value="팟 삭제" data-theme="d" class="ui-link ui-btn ui-btn-d" style="border-radius:32px;"/><input type="hidden" name="saveid" id="saveid" value="empty"/></form>';  


function setNavbar(){
    $("#navibar").html(navbar);                   
}
  
function setNavbar2(){
    $("#navibar2").html(navbar); 
}

function setNavbar4(){//member page
    $("#navibar4").html(navbar); 
}

function setdeleteFoo(){ //개설팟
    $("#partyfooter").html(deleteparty);
     $("#saveid").val(selectedPartyId);//set id for remove POST
}


function toast(message) {
    var $toast = $('<div class="ui-loader ui-overlay-shadow ui-body-e ui-corner-all"><h3>' + message + '</h3></div>');

    $toast.css({
        display: 'block', 
        background: '#fff',
        opacity: 0.90, 
        position: 'fixed',
        padding: '7px',
        'text-align': 'center',
        width: '270px',
        left: ($(window).width() - 284) / 2,
        top: $(window).height() / 2 - 20
    });

    var removeToast = function(){
        $(this).remove();
    };

    $toast.click(removeToast);

    $toast.appendTo($.mobile.pageContainer).delay(2000);
    $toast.fadeOut(400, removeToast);
}


//for toolbar showing
$(document).ready(function(){
	
         $("[data-role='header']").toolbar();  
        navigator.geolocation.getCurrentPosition(function(position){
            loc = new google.maps.LatLng(position.coords.latitude,position.coords.longitude);
            
            $("#curLat").val(position.coords.latitude);
            $("#curLng").val(position.coords.longitude);
            
            
        },function(){});
        
    
    $("#btn_find").click(function(){whatparty='find';});
    $("#btn_my").click(function(){whatparty='my';});
     $("#btn_made").click(function(){whatparty='maden';});
    

    //get party info from selected li
    $("li.partyItem").click(function() {    
    selectedPartyId =$(this).attr('id').trim();  
            //save to cookie
    createCookie("partyid",selectedPartyId,"10");
    selectedPartyName=$(this).find(".partyName").html().trim();  
    selectedPartyDate=$(this).find(".partyDate").html().trim();  
    selectedPartyLocExp=$(this).find(".partyLocExp").html().trim(); 
    selectedPartyNumber=$(this).find(".partyNumber").html().trim();    
    selectedPartyExp=$(this).find(".partyExp").html().trim();       
    selectedPartyInterests=$(this).find(".partyInterests").val().trim();
    selectedPartyMembers=$(this).find(".partyMembers").val().trim();
    selectedPartyLoc=$(this).find(".partyLoc").val().trim();        
    setPartyPage();
    });

    


}); //doc.ready end


$(document).on('pagebeforeshow','#memberpage', function() {
        setNavbar4();
        var member_arr = selectedPartyMembers.split(",");
        var memout="<button class=\"ui-btn ui-icon-user ui-btn-icon-left ui-shadow ui-corner-all\"></button>";
    
        for(var i=0; i<member_arr.length;++i){
            if(member_arr[i]==""){
                continue;
            }
            memout += "  ID : ";
            memout += member_arr[i];
            memout += "<br><hr>";
        }
        
        $("#memlist").html(memout);

});


function setEnrollbtn(){
    var btn_enroll= ' <div style="background-color: rgba(0,0,0,.0); border:0;" id="partyfooter" data-role="footer" data-position="fixed" role="contentinfo" class="ui-footer ui-footer-fixed slideup ui-bar-inherit">';
   btn_enroll += '<form method="post" action="attend_party.php" id="enrollform" data-ajax="false">';
   btn_enroll += '<input data-mini="true" data-iconpos="left" data-icon="plus" data-theme="d" class="ui-link ui-btn ui-btn-d ui-shadow ui-corner-all" type="submit" name="attendsubmit" value="가입하기" />';
    btn_enroll += '<input type=\"hidden\" name=\"enrollId\" id=\"enrollId\" value=\"empty\"/>';
    btn_enroll += '</form></div>';  
    $("#partyfooter").html(btn_enroll);   
    $("#enrollId").val(selectedPartyId);
}


function setPartyPage(){
    
     setPartyMap();
     setEnrollbtn();

    //navibar is shown only on my party page
    if(whatparty=='my'){
        setNavbar();
        $("#partyfooter").html(""); 
    }else if(whatparty=='find'){
         $("#navibar").html(""); 
    }else if(whatparty=='maden'){
        setdeleteFoo();
    }else{}

    $("#partyPageName").html("<h2>"+ selectedPartyName +" ( "+selectedPartyInterests+" )"+"</h2>");
    $("#partyPageExp").html("<p> "+selectedPartyExp+"</p>");
    $("#partyPageDate").html("<p> 일시 : "+selectedPartyDate+"</p>");
    $("#partyPageLoc").html("<p> 위치 : "+selectedPartyLocExp+"</p>");

}

 function createCookie(name, value, days) {
 var expires;
 if (days) {
  var date = new Date();
  date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
  expires = "; expires=" + date.toGMTString();
 } else {
  expires = "";
 }
  document.cookie = escape(name) + "=" + escape(value) + expires + "; path=/";
 }


//board page 
$(document).on('pageshow','#boardpage',function(){
    
    if($.cookie("reload")===undefined){
        $.cookie("reload","1");
//        window.location.reload(); 
    }else{
        if($.cookie("reload")=="0"){
            $.cookie("reload","1");
//            window.location.reload(); 
        }else{
            $.cookie("reload","0");
        }
    }
    setNavbar2();//board page navi bar
    console.log(selectedPartyId);
    console.log($.cookie("partyid"));
    
});



function setPartyMap(){
    var arr = selectedPartyLoc.split(',');
    var lat = parseFloat(arr[0]);
    var long = parseFloat(arr[1]);
    console.log(arr[0]+" " +arr[1]);
    
    var partyMap = document.getElementById("partyMap");
        var partyLoc =new google.maps.LatLng(lat,long);
        var modifyLoc = new google.maps.LatLng(lat+0.22871759131086- 0.02813140392944,long-0.4202270507813+0.1814460754394);
    
    
		var pmap = new google.maps.Map(
				partyMap,
				{
					zoom:10,
				 	center: modifyLoc,
					mapTypeId:google.maps.MapTypeId.ROADMAP
				}
		);
		var partymarker = new google.maps.Marker(
			{
				position:partyLoc,
				map:pmap,
				title:"모임 위치",
                animation: google.maps.Animation.DROP
			}
		);
    
        setTimeout(function() {
            google.maps.event.trigger(pmap,'resize');
        }, 700);
}


$(document).on('pageshow',"#registerpage",function(){
    $("#address").text(address);
    $("#saveloc").val(gmarker.getPosition().lat()+","+gmarker.getPosition().lng());
});
    
$(document).on('pagebeforeshow',"#mapdialog",function(){
    toast("모임 위치로 드래그 하세요");
});


    
//for googlemap
	$(document).on('pageshow',"#mapdialog",function(){
        

		if( navigator.geolocation == undefined ) {
			alert(" 위치 정보를 이용할 수 없습니다. ");
			return; 
		}

		//	지도를 보여줄 div 참조객체 얻어오기 
		var myMap = document.getElementById("myMap");
		//	div 에 구글맵 보이기
		var gmap = new google.maps.Map(
				myMap,	//지도가 보여질 div
				{
					zoom:16,//	지도 확대 정보
				 	center:loc,	//	지도 중앙	위치
					mapTypeId:google.maps.MapTypeId.ROADMAP //	지도타입
				}
		);
		//	위치에 마커 표시하기
		gmarker = new google.maps.Marker(
			{
				position:loc,
				map:gmap,
				title:"모임 위치",
                draggable: true,
                animation: google.maps.Animation.DROP
			}
		);
        google.maps.event.addListener(gmarker, 'click', toggleBounce);
        google.maps.event.addListener(gmarker, 'mouseup',showMarkLocation);
        
	});

    function showMarkLocation(){    
        var markerlatlng = new google.maps.LatLng(gmarker.getPosition().lat(),gmarker.getPosition().lng());
        
        //지오코더 사용 주소로 변환
        var geocoder = new google.maps.Geocoder();
        geocoder.geocode({'latLng' : markerlatlng}, function(results, status) 

            {
            if (status == google.maps.GeocoderStatus.OK) {
                if (results[1]) {
                    address=results[0].formatted_address;          
//                    $("#markLocation").html(address);
                    toast(address);
                    }
                } else {
                    alert("Geocoder failed due to: " + status);
                 }
            });
        //위도 경도
     console.log(gmarker.getPosition().lat()+","+gmarker.getPosition().lng());
            
    }


    //마커 animation
    function toggleBounce() {
     
      if (gmarker.getAnimation() != null) {
        gmarker.setAnimation(null);
      } else {
        gmarker.setAnimation(google.maps.Animation.BOUNCE);
      }
    }






//for external panel
var panel = '<div data-role="panel" id="mypanel" data-position="left" data-display="push" data-theme="b"><div style="border-radius:5px;"data-role="header" data-theme="d"><h4>설정</h4></div><ul data-role="listview" data-inset="true">';

panel+='<li><form action="distance_party.php" method="post"><input data-inline="true" data-mini="true" type="number" name="distance" id="distance" value="" placeholder="검색 범위를 입력(단위:km)"/><input type="submit" data-inline="true" name="submit_distance" id="submit_distance" value="검색 범위 설정" data-mini="true" data-theme="e"/><input type="hidden" name="curLat" id="curLat" value="1"/><input type="hidden" name="curLng" id="curLng" value="1"/></form>';

panel +='</li><li data-theme="e"data-role="list-divider"></li><li><a>계정정보</a></li><li><a>친구</a></li><li><a>공지사항</a></li><li><a>도움말</a></li></ul></div>';

$(document).one('pagebeforecreate', function () {
    $.mobile.pageContainer.prepend(panel);
    $("#mypanel").panel().enhanceWithin();
});





 



