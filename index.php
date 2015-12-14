<?php setcookie("partyid", 1);?>
<?php require_once("includes/db_connection.php")?>
<?php require_once("includes/functions.php");?>
<?php $admin_set = find_all_admins();?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="css/jquery.mobile.flatui.css" />
  <link rel="stylesheet" type="text/css" href="css/mycss.css" />
  <script src="js/jquery.js"></script>
  <script src="js/jquery.mobile-1.4.0.js"></script>
  <script src="js/myscript.js"></script>
    <script type="text/javascript" src="http://maps.google.com/maps/api/js?v=3&sensor=false&language=ko"> </script>
        <script>

        $(document).ready(function() {
            $('#regSubmit').click(function(event){

                data = $('#password').val();
                uid = $('#uid').val();
                var lenid = uid.length;
                var lenpw = data.length;

                if(lenid < 1 || lenpw < 1 ) {
                    toast("빈칸은 불가합니다");
                    // Prevent form submission
                    event.preventDefault();
                }

                if($('#password').val() != $('#cfmPassword').val()) {
                    toast("암호가 일치하지 않습니다");
                    // Prevent form submission
                    event.preventDefault();
                }

            });
        });
  </script>
    
    
</head>
    
<body>

<!--login page-->
  <div id="loginpage" data-role="page">
    <!--header-->
    <header data-role="header" data-position="fixed" style="background-color: rgba(0,0,0,.0); border:0;">
      <img style="width:100%;height:300px;"src="image/party.png" alt="title" />
    </header> <!--header end--> 

    <div data-role="content" role="main">             

    
      <form id="frm" name="frm" method="post" action="login.php" data-ajax="false">
            <fieldset>
                <label>ID</label> 
                <input id="userId" name="userId" type="text" value="" />
                <label>PW</label> 
                <input id="userPw" name="userPw" type="password" value=""/>
            </fieldset>

       <fieldset>
        <div align="center" style="width:100%" data-mini="true" data-role="controlgroup" data-type="horizontal">     
      <!--summit button-->
                <label for="login" class="ui-hidden-accessible">partytitle</label>
               <input data-mini="true" type="submit" data-icon="flat-heart" name="login" id="login" value="로그인" data-theme="b"/>
                <a data-mini="true" href="#reg" data-role="button" title="join" data-theme="b" data-icon="flat-new">회원가입</a>
                <a data-mini="true" href="/member.do?cmd=goIdPwFind"  data-role="button" data-theme="b"data-icon="search">ID/PW 찾기</a>
        </div>
          </fieldset>
        </form>  
        
      </div>
  </div> <!--login page end-->

        
<!--register page-->
  <div id="reg" data-role="page">
    <!--header-->
    <header data-role="header"data-theme="b">
      	<a href="#" data-rel="back" data-icon="delete" data-theme="b">Cancel</a>
	       <h1>회원가입</h1>
    </header> <!--header end--> 

    <div data-role="content" role="main">     

        
        <form id="regform" name="regform" method="post" action="new_admin.php" data-ajax="false">
            <fieldset>
                <label>ID</label> 
                <input id="uid" name="uid" type="text"/>
                <label>PW</label> 
                <input id="password" name="password" type="password"/>
                 <label>PW Confirm</label>
                <input type="password" name="cfmPassword" id="cfmPassword" >
                
                
            </fieldset>
         <input data-theme="f" type="submit" value="저장" id="regSubmit" name="regSubmit"/>

        </form>  
        
      </div>
  </div> <!--login page end-->

</body>
</html>
