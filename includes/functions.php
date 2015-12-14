<?php 
    function confirm_query($result_set){
        if(!$result_set){
            die("db query failed.");
        }
        
    }


    function find_all_parties(){
        global $connection;
        //2. Perform database query
        //query for findpage
        $query = "SELECT * ";
        $query .= "FROM party ";
        $query .= "ORDER BY id DESC";
        $result_set = mysqli_query($connection,$query);//get resource for findpage
        //Test if there was a query error
        confirm_query($result_set);

        return $result_set;
    }
    
    function find_my_parties(){
        
        global $myID;
         global $connection;
        //query for mypage
        $madenquery = "SELECT * FROM party WHERE members LIKE '%$myID%' ";
        $madenquery .= "ORDER BY id DESC";
        $madenresult_set = mysqli_query($connection,$madenquery);
        //Test if there was a query error
        confirm_query($madenresult_set);
        
        return $madenresult_set;
        
    }

    function find_maden_parties(){
        
        global $myID;
         global $connection;
        //query for madenpage
        $myquery = "SELECT * FROM party WHERE master LIKE '%$myID%' ";
        $myquery .= "ORDER BY id DESC";
        $myresult_set = mysqli_query($connection,$myquery);//get resource for findpage
        //Test if there was a query error
        confirm_query($myresult_set);
        
        return $myresult_set;
        
    }

    
function find_all_admins(){
        global $connection;
        $query = "SELECT * ";
        $query .= "FROM admins ";
        $admin_set = mysqli_query($connection,$query);
        confirm_query($admin_set);
        return $admin_set;
    }

function find_admin_by_id($admin_id){
        global $connection;
        $safe_admin_id = mysqli_real_escape_string($connection,$admin_id);
    
        $query = "SELECT * ";
        $query .= "FROM admins ";
        $query .= "WHERE id = {$safe_admin_id} ";
        $query .= "LIMIT 1";
        $admin_set = mysqli_query($connection,$query);
        confirm_query($admin_set);
        if($admin = mysqli_fetch_assoc($admin_set)){
            return $admin;
        }else{
            return null;
        }
    }

function find_admin_by_username($username){
        global $connection;
        $safe_username = mysqli_real_escape_string($connection,$username);
    
        $query = "SELECT * ";
        $query .= "FROM admins ";
        $query .= "WHERE username = '{$safe_username}' ";
        $query .= "LIMIT 1";
        $admin_set = mysqli_query($connection,$query);
        confirm_query($admin_set);
        if($admin = mysqli_fetch_assoc($admin_set)){
            return $admin;
        }else{
            return null;
        }
    }

function distance($lat1, $lng1, $lat2, $lng2, $miles = false)
{
	$pi80 = M_PI / 180;
	$lat1 *= $pi80;
	$lng1 *= $pi80;
	$lat2 *= $pi80;
	$lng2 *= $pi80;

	$r = 6372.797; // mean radius of Earth in km
	$dlat = $lat2 - $lat1;
	$dlng = $lng2 - $lng1;
	$a = sin($dlat / 2) * sin($dlat / 2) + cos($lat1) * cos($lat2) * sin($dlng / 2) * sin($dlng / 2);
	$c = 2 * atan2(sqrt($a), sqrt(1 - $a));
	$km = $r * $c;
//return km
	return ($miles ? ($km * 0.621371192) : $km);
}


function find_using_distance($currentLat,$currentLng,$setDistance){
    global $connection;
    $party_set = find_all_parties(); //mysqli_result object
    $query = "SELECT * ";
    $query .= "FROM party ";
    $query .= "WHERE ";
    
     while($party = mysqli_fetch_assoc($party_set)){
        $locArr =split(",",$party["loc"]);    
        $lat = $locArr[0];
        $lng = $locArr[1];
        $id= $party["id"];
         
        //세팅 된 거리보다 거리가 작으면
         if(distance($currentLat,$currentLng,$lat,$lng) <= $setDistance ){

             $query .= "id = {$id} OR ";
         }

     }

    //delete last "OR "
    $query = substr($query, 0, strlen($query) - 3);
    $query .= " ORDER BY id DESC";    
    $dt_party_set = mysqli_query($connection,$query);
    confirm_query($dt_party_set);
    return $dt_party_set;
}


function attempt_login($username,$password){
    $admin = find_admin_by_username($username);
    if ($admin){
        //found admin , now check paswwrd
        if ($password == $admin["hashed_password"]){
            //password matches
            return $admin;
        }else{
            //password not match
            return false;
        }
    }else{
        //admin not found
        return false;
    }
        
 }


   function partylist($menu){

        $output =  "<ul id=\"findpartylistview\" data-role=\"listview\" data-inset=\"true\" data-filter=\"true\" data-filter-theme=\"b\" data-filter-placeholder=\"팟을 검색하세요\" data-divider-theme=\"d\"><div class=\"ui-btn-right\" data-role=\"controlgroup\" data-type=\"horizontal\"><li  data-theme\"e\" data-role=\"list-divider\"><div style=\"height:23px;\"></div></li>";

       if($menu=='find'){
           $party_set = find_all_parties();
       }
       elseif($menu=='my'){
           $party_set = find_my_parties();
       }elseif($menu=='distance'){
           $party_set=find_using_distance($_SESSION['curlat'],$_SESSION['curlng'],$_SESSION['distance']);
       }else{
           $party_set=find_maden_parties();
       }
       
        $output.="</div><li  data-theme=\"e\" data-role=\"list-divider\">파티 목록</li>";
       
        while($party = mysqli_fetch_assoc($party_set)){

        $output .="<li data-theme=\"c\" class=\"partyItem\" id=\"";
        $output .= $party["id"];
        $output .= "\"><a href=\"#partypage\"><p class=\"ui-li-aside partyDate\">";
        $output .= $party["date"];
        $output .= "</p><div id=\"listInfo\"><h5><span class=\"partyName\">";
        $output .= $party["name"];
        $output .= "</span> <span class=\"ui-li-count partyNumber\">";
        $numMem = substr_count($party["members"], ",");
        $output .= $numMem . "/". $party["mem_limit"];
        $output .= "</span></h5><p class=\"partyLocExp\">";
        $output .= $party["loc_exp"];
        $output .= "</p><p class=\"partyExp\">";
        $output .= $party["exp"];
        $output .= "</p><input type=\"hidden\" name=\"location\" class=\"partyLoc\" value=\"";
        $output .= $party["loc"];
        $output .="\" /><input type=\"hidden\" name=\"memebers\" class=\"partyMembers\" value=\"";
        $output .=$party["members"];
        $output .= "\" />  <input type=\"hidden\" name=\"interests\" class=\"partyInterests\" value=\"";
        $output .=$party["interests"];
        $output .= "\" /> </div></a></li>";     
                    

        } 

       $output .= "</ul>";  
       
    

       return $output;
       
   }





//party의 아이디를 받아서 해당 id에 relation을 가진
//board를 뿌려준다. WHERE party_id = id 
    function getBoards($partyId){
        global $connection;    
        $query = "SELECT * ";
        $query .= "FROM boards ";
        $query .= "WHERE party_id = {$partyId} ";
        $query .= "ORDER BY id DESC";
        $board_set = mysqli_query($connection,$board_set);
        //Test if there was a query error
        if(!$board_set){
            die("db query failed.");
        }
        return $board_set;//db result
    }

    function redirect_to($location)
    {
        if (!headers_sent($file, $line))
        {
            header("Location: " . $location);
        } else {
            printf("<script>location.href='%s';</script>", urlencode($location));
            # or deal with the problem
        }
        printf('<a href="%s">Moved</a>', urlencode($location));
        exit;
    }


        
        
        


?>

