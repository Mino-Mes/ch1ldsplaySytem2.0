$("form#updateForm").submit(function (e) {
    e.preventDefault();
    var formData = new FormData(this);

    $.ajax({
        url:"../Util/updateAlbumInfo.php",
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
$("form#addPhotoForm").submit(function (e) {
    e.preventDefault();
    var formData = new FormData(this);
    var modal = document.getElementById("myModal");
    $.ajax({
        url:"../Util/addPhoto.php",
        type: 'POST',
        data: formData,
        success: function (data) {
            var x = document.getElementById("snackbar");
            x.innerHTML = data;
            x.className = "show";
            setTimeout(function () {
                x.className = x.className.replace("show", "");
            }, 3000);
            modal.style.display = "none";
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

function addPhotoModal() {
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


function isActive(id) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            showAlbumPhotoList();
        }
    };
    xhttp.open("POST", "../Util/isPhotoActive.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("photoId=" + id + " &isActive=1");
}

function openDeleteModal(id)
{
    // Get the modal
    var modal = document.getElementById("deleteP");

    // Get the button that opens the modal
    var btn = document.getElementById("myBtn");

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[1];

    // When the user clicks the button, open the modal
    modal.style.display = "block";

    span.onclick = function () {
        modal.style.display = "none";
    }


    document.getElementById("photoIdHidden").value=id;
    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function (event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
}

function deletePhoto() {

    var id=document.getElementById("photoIdHidden").value;
    var modal = document.getElementById("deleteP");
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            showAlbumPhotoList();
            var x = document.getElementById("snackbar");
            x.innerHTML = this.responseText;
            x.className = "show";
            setTimeout(function () {
                x.className = x.className.replace("show", "");
            }, 3000);
            modal.style.display = "none";
        }
    };
    xhttp.open("POST", "../Util/isPhotoActive.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("photoId=" + id + " &deleteP=1");
}
