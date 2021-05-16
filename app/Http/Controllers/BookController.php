<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index(){
        $servername = "localhost";
	    $username = "root";
	    $password = "1234";
	    $dbname = "bookstore";
        $conn = mysqli_connect($servername, $username, $password, $dbname);
        //tureesiin tsag hetersen esehiig shalgah
        $sql = "SELECT * FROM rent";
        $result = mysqli_query($conn,$sql);
        while($row = mysqli_fetch_assoc($result)){
	        //herew tureesiin tuluw ni haagdsan eswel tsutsladsan bol hugatsaa hetersen bolohgui
	        if($row['rent_tuluw_id'] !=4 and $row['rent_tuluw_id'] !=7){
		        $id1 = $row['rent_id'];
		    //herew tureesiin tsag hetersen baiwal tuluwiig solidog query
		    $sql = "UPDATE rent SET rent_tuluw_id = if(deadline_at < now() ,5, rent_tuluw_id) WHERE rent_id = $id1;";
		    mysqli_query($conn,$sql);
	        }
        }
        //ajjilluulah uyuuded odort 1 l udaa ajillana hedii olon udaa achaalluulsan ch gesen
        if(!isset($_COOKIE['day'])){
	        //hugatsaa ni hetersen hereglegchdiin dansnaas odort 5000-g hasah
	        $sql = "SELECT rent_user_id from rent where rent_tuluw_id = 5";
	        $result = mysqli_query($conn,$sql);
	        while($row = mysqli_fetch_assoc($result)){
		        $deadlined_user_id = $row['rent_user_id'];
		        $sql = "UPDATE users SET user_wallet=user_wallet - 5000 where id = $deadlined_user_id";
		        mysqli_query($conn,$sql);
	        }
	        setcookie ("day","value",time()+ 86400);
        }
        return view('home');
    }
}
