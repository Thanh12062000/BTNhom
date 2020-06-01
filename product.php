<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<link rel="stylesheet" type="text/css" href="productcss.css">
</head>
<body>
	<h1>PRODUCT: </h1>
	<?php
		
		require_once('data_access_helper.php');
		$db = new DataAccessHelper();
		$db->connect();

		// BƯỚC 2: TÌM TỔNG SỐ RECORDS
        $result = mysqli_query($conn, 'select count(productCode) as total from products');
        $row = mysqli_fetch_assoc($result);
        $total_records = $row['total'];

        // BƯỚC 3: TÌM LIMIT VÀ CURRENT_PAGE
        $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
        $limit = 12;
 
        // BƯỚC 4: TÍNH TOÁN TOTAL_PAGE VÀ START
        // tổng số trang
        $total_page = ceil($total_records / $limit);

        // Giới hạn current_page trong khoảng 1 đến total_page
        if ($current_page > $total_page){
            $current_page = $total_page;
        }
        else if ($current_page < 1){
            $current_page = 1;
        }
 
        // Tìm Start
        $start = ($current_page - 1) * $limit;
        // BƯỚC 5: TRUY VẤN LẤY DANH SÁCH TIN TỨC
        // Có limit và start rồi thì truy vấn CSDL lấy danh sách tin tức
        $result = mysqli_query($conn, "SELECT * FROM products LIMIT $start, $limit");
    ?>
    <div>
        <?php 
        // PHẦN HIỂN THỊ TIN TỨC
        // BƯỚC 6: HIỂN THỊ DANH SÁCH TIN TỨC

        echo "<table id=table >";
		echo "<tr>";
		echo 	"<th>Code</th>
				<th>Name</th>
				<th>Line</th>
				<th>Vendor</th>
				<th>Price</th>";
		echo "</tr>";
		 while ($row = mysqli_fetch_assoc($result)){
			echo "<tr>";

			echo   "<td> " . $row["productCode"]. "</td>
					<td> " . $row["productName"]. "</td>
					<td> " . $row["productLine"]. "</td>
					<td> " . $row["productVendor"]. "</td>
					<td> " . $row["buyPrice"]. "</td>";
			echo "</tr>";
		}
		echo "</table>";

        ?>
    </div>
    <br><br>
    <div class="pagination">
       <?php 
       	$link="test";
        // PHẦN HIỂN THỊ PHÂN TRANG
        // BƯỚC 7: HIỂN THỊ PHÂN TRANG

        // nếu current_page > 1 và total_page > 1 mới hiển thị nút prev
        if ($current_page > 1 && $total_page > 1){
            echo '<a href="'.$link.'.php?page='.($current_page-1).'">Trang trước</a> | ';
        }

        // Lặp khoảng giữa
        for ($i = 1; $i <= $total_page; $i++){
            // Nếu là trang hiện tại thì hiển thị thẻ span
            // ngược lại hiển thị thẻ a
            if ($i == $current_page){
                echo '<span>'.$i.'</span> | ';
            }
            else{
                echo '<a href="'.$link.'.php?page='.$i.'">'.$i.'</a> | ';
            }
        }

        // nếu current_page < $total_page và total_page > 1 mới hiển thị nút prev
        if ($current_page < $total_page && $total_page > 1){
            echo '<a href="'.$link.'.php?page='.($current_page+1).'">Trang sau</a> | ';
        }
        $db->close();
       ?>
    </div>

</body>
</html>


 