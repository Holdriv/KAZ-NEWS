<?php
include "config/db.php";
include "config/base_url.php";
include "common/time.php";

if(isset($_GET["nickname"])){
	$nick = $_GET["nickname"];	
	$prep = mysqli_prepare($con, 
	"SELECT b.*, u.nickname, c.name FROM blogs b
	LEFT OUTER JOIN users u ON b.author_id = u.id
	LEFT OUTER JOIN categories c ON b.category_id = c.id
	WHERE u.nickname =?");

	mysqli_stmt_bind_param($prep, "s", $nick);
	mysqli_stmt_execute($prep);
	$query = mysqli_stmt_get_result($prep);

}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Профиль</title>
	<?php include "views/head.php"; ?>
</head>
<body>
<?php include "views/header.php"; ?>

<section class="container page">
	<div class="page-content">
		<div class="page-header">
			<?php
				if($nick == $_SESSION["nickname"]){
					
			?>
				<h2>Мои Новости</h2>
				<a class="button" href="newblog.php">Написать новость</a>
			<?php
				}else{
			?>
				<h2></h2>
				<a href=""></a>
			<?php
				}
			?>

		</div>

		<div class="blogs">
			<?php
				if(mysqli_num_rows($query) > 0){
					while($blog = mysqli_fetch_assoc($query)){
			?>
			<div class="blog-item">
				<img class="blog-item--img" src="<?=$BASE_URL?>/<?=$blog["img"]?>" alt="">
				<div class="blog-header">
					<h3><?=$blog["title"]?></h3>
					<?php
					if($nick == $_SESSION["nickname"]){
					?>
						<span class="link">
							<img src="images/dots.svg" alt="">
							Еще

							<ul class="dropdown">
								<li> <a href="<?=$BASE_URL?>/editblog.php?id=<?=$blog["id"]?>">Редактировать</a> </li>
								<li><a href="<?=$BASE_URL?>/api/blog/delete.php?id=<?=$blog["id"]?>" class="danger">Удалить</a></li>
							</ul>
						</span>
					<?php
						}else{
					?>
						<span></span>
						<?php
							}
						?>
					

				</div>
				<p class="blog-desc"><?=$blog["description"]?></p>

				<div class="blog-info">
					<span class="link">
						<img src="images/date.svg" alt="">
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
					<a class="link">
						<img src="images/person.svg" alt="">
						<?=$blog["nickname"]?>
					</a>
				</div>
			</div>
			
			<?php
					}
				}else{
			?>
				<h3>0 новостей</h3>
			<?php
				}
			?>

		</div>
	</div>
	<div class="page-info">
		<div class="user-profile">
			<img class="user-profile--ava" src="images/zhurnalist2.jpg" alt="">

			<h1>Нурсултан Ахметов</h1>
			<h2>Независимый журналист, пишу на острые темы</h2>
			<a href="" class="button">Редактировать</a>
			<a href="<?=$BASE_URL?>/api/user/signout.php" class="button button-danger"> Выход</a>
		</div>
	</div>

	
</section>	
</body>
</html>