<?php
	include "config/base_url.php";
	include "config/db.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Добавление Новости</title>
	<?php include "views/head.php"; ?>
</head>
<body>
<?php include "views/header.php"; ?>

	<section class="container page">
		<div class="page-block">

			<div class="page-header">
				<h2>Новость</h2>
			</div>
			
			<form class="form" action="<?=$BASE_URL?>/api/blog/add.php" method="POST" enctype="multipart/form-data">
				
			<fieldset class="fieldset">
				<input class="input" type="text" name="title" placeholder="Заголовок">
			</fieldset>

			<fieldset class="fieldset">
				<select name="category_id" id="" class="input">
					<?php
						$categs = mysqli_query($con, "SELECT * FROM categories");
						while($cat = mysqli_fetch_assoc($categs)){
					?>
						<option value="<?=$cat["id"]?>"><?=$cat["name"]?></option>

					<?php
						}
					?>
					
				</select>
			</fieldset class="fieldset">
			
			<fieldset class="fieldset">
				<button class="button button-yellow input-file">
					<input type="file" name="image">
					Выберите картинку
					<!-- 1.png == $_FILES["image"]["name"]-->
				</button>
			</fieldset>
				
			<fieldset class="fieldset">
				<textarea class="input input-textarea" name="description" id="" cols="30" rows="10" placeholder="Описание"></textarea>
			</fieldset>
			<fieldset class="fieldset">
				<button class="button" type="submit">Сохранить</button>
			</fieldset>
			</form>

			

				<!-- <p class="text-danger"> Заголовок и Описание не могут быть пустыми!</p> -->


		</div>

	</section>
	
</body>
</html>