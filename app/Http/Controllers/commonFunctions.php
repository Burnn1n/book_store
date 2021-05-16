<?php
if (session_status() === PHP_SESSION_NONE) {
	session_start();
}
class db{
	private $servername = "localhost";
	private $username = "root";
	private $password = "1234";
	private $dbname = "bookstore";
	function __construct() {
		$this->conn = mysqli_connect($this->servername, $this->username, $this->password, $this->dbname);
	}
	// /book view-d buh 
	function print_book($sql,$limit){
		$result = mysqli_query($this->conn,$sql);
		$count=1;
		while($row1 = mysqli_fetch_assoc($result)){
			$name1 = $row1["book_name"];
			$num = $row1["book_price"];
			$img = $row1["book_image"];
			echo "<div class='col-sm-3'>";
			echo '<a href="/book/'.$name1.'"><img src="data:image/jpeg;base64,'.base64_encode($img).'" style="width:235px;height:320px;"/></a>';
			echo "<center><a href='/book/$name1'>$name1</a></center>";
			echo "<center>$num төгрөг</center>";
			echo "</div>";
			if($limit != null){
				if($count == $limit)
					break;
			$count+=1;
			}
		}
	}
	//home eswel category view
	function print_($type) {
		if($type == 'home')
			$sql = "select * from home order by home_name";
		elseif($type == 'category')
			$sql = "select * from category order by category_name";
		$result = mysqli_query($this->conn,$sql);
		while($row = mysqli_fetch_assoc($result)){
			$name = $row[($type=='home')?'home_name':'category_name'];
			$id = $row[($type=='home')?'home_id':'category_id'];
			echo "<div class='col-sm-10'style='margin-top: 20px;margin-bottom:20px;border-bottom: 1px solid #7f7f7f;'>$name</div>";
			if($type == 'home'){
				echo "<div class='col-sm-2' style='margin-top: 20px;margin-bottom:20px;border-bottom: 1px solid #7f7f7f;'><a href='/$name'>Бүгд</a></div>";
				$sql1 = "select book_name,book_price,book_image from book where book_home=$id order by book_name";
			}
			elseif($type == 'category'){
				echo "<div class='col-sm-2' style='margin-top: 20px;margin-bottom:20px;border-bottom: 1px solid #7f7f7f;'><a href='category/$name'>Бүгд</a></div>";
				$sql1 = "select book_name,book_price,book_image from book where book_category=$id order by book_name";
			}
			$this->print_book($sql1,4);				
		}
	}
	function print_book_single($book_name,$cat_id){
		$sql1 = "select book_name,book_price,book_image from book where book_category=$cat_id";
		$result1 = mysqli_query($this->conn,$sql1);
		$count=1;
		while($row1 = mysqli_fetch_assoc($result1)){
			$name1 = $row1["book_name"];
			if ($name1 == $book_name)
				continue;
			$num = $row1["book_price"];
			$img = $row1["book_image"];
			echo "<div class='col-sm-3'>";
			echo '<a href="/book/'.$name1.'"><img src="data:image/jpeg;base64,'.base64_encode($img).'" style="width:235px;height:320px;"/></a>';
			echo "<center><a href='/book/$name1'>$name1</a></center>";
			echo "<center>$num төгрөг</center>";
			echo "</div>";
			if($count == 4)
				break;
			$count+=1;
		}
	}
	function print_category_single($type,$value){
		if($type == 'home')
			$sql = "select home_id from home where home_name = '$value'";
		elseif($type == 'category')
			$sql = "select category_id from category where category_name = '$value'";
		$result = mysqli_query($this->conn,$sql);
		$row = mysqli_fetch_row($result);
		$id = $row[0];
		if($type == 'home')
			$sql = "select book_name,book_price,book_image from book where book_home=$id order by book_name";
		elseif($type == 'category')
			$sql = "select book_name,book_price,book_image from book where book_category=$id order by book_name";
		$this->print_book($sql,null);
		}
	function print_user($img,$sql,$type,$user_type){
		$result = mysqli_query($this->conn,$sql);
		while($row1 = mysqli_fetch_assoc($result)){
			$c = $row1["id"];
			$c1 = $row1["user_name"];
			$c2 = $row1["user_email"];
			$c3 = $row1["user_phone"];
			$c4 = $row1["user_wallet"];
			echo "<tr>
			<td><img src='$img'style='width:50px;height:50px;'><a href='/user/$c'>$c1</a></td>
			<td>$c2</td>
			<td>$c3</td>";
			if($type != null)	echo "<td>$c4</td>";
			if($user_type == 1){
				echo "
			<td style='width: 20%;'>
			<a href='/user/$c' class='table-link'>
				<span class='fa-stack'>
					<i class='fa fa-square fa-stack-2x'></i>
					<i class='fa fa-search-plus fa-stack-1x fa-inverse'></i>
				</span>
			</a>
			<a href='/user/$c?edit=a' class='table-link'>
				<span class='fa-stack'>
					<i class='fa fa-square fa-stack-2x'></i>
					<i class='fa fa-pencil fa-stack-1x fa-inverse'></i>
				</span>
			</a>
			<a href='/user/$c?delete=a' class='table-link danger confirmation'>
				<span class='fa-stack'>
					<i class='fa fa-square fa-stack-2x'></i>
					<i class='fa fa-trash-o fa-stack-1x fa-inverse'></i>
				</span>
			</a>
			</td>";
			}
			else{
				echo"<td></td>";
			}
			echo"</tr>";
		}
	}
	function print_order($sql){
		$result = mysqli_query($this->conn,$sql);
		while($row1 = mysqli_fetch_assoc($result)){
			$c = $row1["id"];
			$c1 = $row1["user_name"];
			$c2 = $row1["user_email"];
			$c3 = $row1["user_phone"];
			$c4 = $row1["user_wallet"];
			echo "<tr>
			<td>$c1</td>
			<td>$c2</td>
			<td>$c3</td>
			<td>$c4</td>
			<td>$c4</td>
			</tr>";
		}
	}
	function single_value($sql){
		$result = mysqli_query($this->conn,$sql);
		$row = mysqli_fetch_row($result);
		return $row[0];
	}
}