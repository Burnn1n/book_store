<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BookController extends Controller
{
	private $servername = "localhost";
	private $username = "root";
	private $password = "1234";
	private $dbname = "bookstore";
	
    public function index(){
				$conn = mysqli_connect($this->servername, $this->username, $this->password, $this->dbname);
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
		public function single(){
			$conn = mysqli_connect($this->servername, $this->username, $this->password, $this->dbname);
			$c1 = $_POST['name'];
			$c2 = $_POST['author'];
			$c3 = $_POST['price'];
			$c4 = $_POST['o_price'];
			$c5 = $_POST['quantity'];
			$c6 = $_POST['pages'];
			$c7 = $_POST['desc'];
			$c8 = $_POST['rent_price'];
			$c9 = $_POST['categ'];
			$file_name = $_FILES['img']['name'];
      $file_tmp = $_FILES['img']['tmp_name'];
			//file path
			$fil = "C:/xampp/htdocs/projects/Laravel/book/resources/pic/".$file_name;
			move_uploaded_file($file_tmp,$fil);
			$sql = "INSERT INTO book(book_name,book_online_price,book_price,book_author,book_quantity,book_about,
			book_pages,book_image,book_category,book_home,updated_at,book_rent_price)
			values('$c1','$c4','$c3','$c2','$c5','$c7','$c6',null,'$c9','1',null,'$c8');";
			if(mysqli_query($conn,$sql)) echo "yeah";
			else echo mysqli_error($conn);

			//$data = file_get_contents($_FILES['file']["tmp_name"]);
			//$sql = "UPDATE book SET book_image = '$data' WHERE book_id = '$id'";
			//if(!mysqli_query($this->conn,$sql)){
			//echo "<script>alert('amjiltgui')</script>";
			//}
			//else{
			//	echo "<script>alert('yess')</script>";
			//}
			header("Location: /book");
			exit;
		}
		
}
