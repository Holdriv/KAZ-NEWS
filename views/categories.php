
<div class="page-info">
  <div class="page-header">
            <h2>Категории</h2>
        </div>

        <?php
            $cat = mysqli_query($con, 
            "SELECT * FROM categories");
            for($i=0; $i<mysqli_num_rows($cat); $i++){
                $categ = mysqli_fetch_assoc($cat);
        ?>
            <a class='list-item' href="?category_id=<?=$categ["id"]?>"><?=$categ["name"]?></a>
        <?php
            }
        ?>
        
</div>