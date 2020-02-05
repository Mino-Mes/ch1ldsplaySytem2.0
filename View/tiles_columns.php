<?php require "../../Util/dbconn.php"; ?>
<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Unite Gallery - Tiles - Columns</title>

	<script type='text/javascript' src='../unitegallery-master/package/unitegallery/js/jquery-11.0.min.js'></script>
	<script type='text/javascript' src='../unitegallery-master/package/unitegallery/js/unitegallery.min.js'></script>

	<link rel='stylesheet' href='../unitegallery-master/package/unitegallery/css/unite-gallery.css' type='text/css' />
	
	<script type='text/javascript' src='../unitegallery-master/package/unitegallery/themes/tiles/ug-theme-tiles.js'></script>
	
	
</head>

<body>
	
	<h2>Tiles - Columns</h2>
	
	<div id="gallery" style="display:none;">
        <?php
        $sql = "SELECT photo_img FROM photo WHERE album_id=1";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                ?>
                <img alt="Peppers"
                     src="<?php echo $row["photo_img"]; ?>"
                     data-description="Those are peppers"
                     style="display:none">
                <?php
            }
        } else {
            echo "asdasdsada";
        }
        ?>
	</div>
	
	<script type="text/javascript">

		jQuery(document).ready(function(){

			jQuery("#gallery").unitegallery({
				tiles_max_columns: 3,
				theme_enable_preloader: true,
				tiles_space_between_cols: 13,
				lightbox_type: "compact"
			});

		});
		
	</script>


</body>
</html>
