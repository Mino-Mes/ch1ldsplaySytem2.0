<?php
require "../Util/dbconn.php";

$html="";
$sql2="SELECT * FROM album WHERE album_isActive=1";
if(isset($_POST['type']))
{
    $type = $_POST["type"];
    $sql2 = "SELECT * FROM album WHERE typeId=" . $type;
}
$result2 = $conn->query($sql2);
$count = 0;

if ($result2->num_rows > 0) {

    while ($album = $result2->fetch_assoc()) {
        $album_label = $album["album_label"];
        $album_title = $album["album_title"];
        $album_description = $album["album_description"];
        $album_id = $album["album_id"];
        $album_img = $album["album_img"];

        $count++;
        if ($count % 2 == 0) {
            $html .="<article class=\"post style2 alt fade-in\" id='galleryBox'> 
                                  <div class=\"content\"> 
                                   <header> 
                                    <span class=\"category\">$album_label</span> 
                                     <h3>$album_title</h3> 
                                      </header>
                                       <p>$album_description</p> 
                                       <ul class=\"actions\"> 
                                         <li><a href=\"album.php?id=$album_id \"class=\"button next\">View Full Album</a></li> 
                                          </ul> 
                                           </div> 
                                            <div class=\"image\" data-position=\"center\"><img src=\"$album_img\" alt=\"\"/></div> 
                                             </article>";

        } else {
            $html .="<article class=\"post style2 fade-in\" id='galleryBox'> 
                            <div class=\"content\"> 
                            <header> 
                            <span class=\"category\">$album_label</span>
                            <h3>$album_title</h3>
                             </header>
                             <p>$album_description</p>
                            <ul class=\"actions\">
                             <li><a href=\"album.php?id=$album_id \"class=\"button next\">View Full Album</a></li> 
                            </ul>
                            </div> 
                            <div class=\"image\" data-position=\"center\"><img src=\"$album_img\" alt=\"\"/></div> 
                            </article>";
        }
    }
}
else{
    $html="<div class=\"box\" style='width: 50%;margin-left: 25%;margin-right: 25%;background-color: white;'>
                              <div style=\"text-align: center;\">
                              <h4>There is no existing Gallery for that Type. Please select another type !</h4>
                              </div>";
}
echo $html;


