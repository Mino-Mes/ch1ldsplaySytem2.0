$("form#addAlbumForm").submit(function (e) {
    e.preventDefault();
    var formData = new FormData(this);

    $.ajax({
        url:"../Util/addAlbumLogic.php",
        type: 'POST',
        data: formData,
        success: function (data) {
            var x = document.getElementById("snackbar");
            x.innerHTML = data;
            x.className = "show";
            setTimeout(function () {
                x.className = x.className.replace("show", "");
            }, 3000);
        },
        cache: false,
        contentType: false,
        processData: false
    });
});


function PreviewImage() {
    var oFReader = new FileReader();
    oFReader.readAsDataURL(document.getElementById("uploadImage").files[0]);

    oFReader.onload = function (oFREvent) {
        document.getElementById("uploadPreview").src = oFREvent.target.result;
    };
};

function PreviewImages(){
    var images =document.getElementById("albumImages[]");
    var output =document.getElementById("albumContainer");

    for(var i=0;i<images.files.length;i++)
    {
        var oFReader = new FileReader();
        oFReader.readAsDataURL(images.files[i]);

        oFReader.onload = function (oFREvent) {
            output.innerHTML +="<div class='col-4'><span class='image fit'><img src= " + oFREvent.target.result +" alt='Album Image'/></span></div>";
        };
    }
}

function showTypeDropdown()
{
    var xhttp1 = new XMLHttpRequest();
    xhttp1.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var x = document.getElementById("typeDrop");
            x.innerHTML = this.responseText;
        }
    };
    xhttp1.open("POST", "../Util/showTypeDropdown.php", true);
    xhttp1.send();
}
showTypeDropdown();

function addTypeModal() {
    // Get the modal
    var modal = document.getElementById("myModal");

    // Get the button that opens the modal
    var btn = document.getElementById("myBtn");

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];

    // When the user clicks the button, open the modal
    modal.style.display = "block";

    // When the user clicks on <span> (x), close the modal
    span.onclick = function () {
        modal.style.display = "none";
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function (event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
}
function UploadType() {
    var typeName = document.getElementById("name").value;
    var xhttp1 = new XMLHttpRequest();
    xhttp1.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var x = document.getElementById("snackbar");
            x.innerHTML = this.responseText;
            x.className = "show";
            setTimeout(function () {
                x.className = x.className.replace("show", "");
            }, 3000);
            showTypeDropdown();
            var modal = document.getElementById("myModal");
            modal.style.display = "none";
        }
    };
    xhttp1.open("POST", "../Util/addTypeLogic.php", true);
    xhttp1.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp1.send("type=" + typeName);
}