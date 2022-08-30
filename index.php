<?php
	include "config/base_url.php";
	include "config/db.php";
	include "common/time.php";

	$sql = "SELECT b.*, u.nickname, c.name FROM blogs b
	LEFT OUTER JOIN users u ON b.author_id = u.id
	LEFT OUTER JOIN categories c ON b.category_id = c.id
	";
    $q = "";
	if(isset($_GET["category_id"]) && intval($_GET["category_id"])){
		$cat_id = $_GET["category_id"];
		$sql .= " WHERE b.category_id=".$cat_id;
	}

	if(isset($_GET["q"]) && strlen($_GET["q"]) > 0){
		$q = strtolower($_GET["q"]);
		$sql .= " WHERE LOWER(b.title) LIKE ? OR
				  LOWER(b.description) LIKE ? OR
				  LOWER(u.nickname) LIKE ? OR
				  LOWER(c.name) LIKE ?";
	}

	if($q){
		$param = "%$q%";
		
		$prep_blogs = mysqli_prepare($con, $sql);
		mysqli_stmt_bind_param($prep_blogs, "ssss", 
		$param, $param,$param, $param);

		mysqli_stmt_execute($prep_blogs);

		$query = mysqli_stmt_get_result($prep_blogs);
	}else{
		$query = mysqli_query($con, $sql);
	}

	

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Главная</title>
    <?php include "views/head.php"; ?>
</head>
<body>
<?php include "views/header.php"; ?>


<section class="container page">
	<div class="page-content">
			<h2 class="page-title">Новостной блог</h2>
			<p class="page-desc">Новости от прямого эфира с места событий</p>

		<div class="blogs">
			<?php
				if(mysqli_num_rows($query) > 0){
					while($blog = mysqli_fetch_assoc($query)){
			?>
				<div class="blog-item">
					<img class="blog-item--img" src="<?=$BASE_URL?>/<?=$blog["img"]?>" alt="">
					<div class="blog-header">
						<h3> 
							<a href="<?=$BASE_URL?>/blog-details.php?id=<?=$blog["id"]?>">
								<?=$blog["title"]?>
							</a> 
						</h3>
					</div>
					<p class="blog-desc"><?=$blog["description"]?></p>

					<div class="blog-info">
						<span class="link">
							<img src="<?=$BASE_URL; ?>/images/date.svg" alt="">
							<?= to_time_ago( strtotime($blog["date"]) ) ?>
						</span>
						<span class="link">
							<img src="images/visibility.svg" alt="">
							21
						</span>
						<a class="link">
							<img src="images/message.svg" alt="">
							4
						</a>
						<span class="link">
							<img src="images/forums.svg" alt="">
							<?=$blog["name"]?>
						</span>
						<a class="link" href="<?=$BASE_URL?>/profile.php?nickname=<?=$blog["nickname"]?>">
							<img src="images/person.svg" alt="">
							<?=$blog["nickname"]?>
						</a>
					</div>
				</div>
			<?php
					}
				}else{
			?>
				<h3>0 blogs</h3>
			<?php
				}
			?>

		</div>
	</div>

	<?php
	include "views/categories.php";
	?>
</section>	
</body>
</html>