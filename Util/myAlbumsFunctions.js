

function openPage(pageName, elmnt, color) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablink");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].style.backgroundColor = "";
    }
    document.getElementById(pageName).style.display = "block";
    elmnt.style.backgroundColor = color;
}

// Get the element with id="defaultOpen" and click on it
document.getElementById("defaultOpen").click();

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

$("form#addPhotoUserForm").submit(function (e) {
    e.preventDefault();
    var formData = new FormData(this);
    var modal = document.getElementById("addPhotographs");
    $.ajax({
        url:"../Util/addPhotoUser.php",
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

function addPhotoModal(userId) {
    // Get the modal
    var modal = document.getElementById("addPhotographs");

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[3];

    document.getElementById("hiddenUserId").value = userId;
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

function showYourPhotographListModal(id)
{
    showYourPhotographList(id);
    // Get the modal
    var modal = document.getElementById("viewYourPhotographs");

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[4];

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

function showYourPhotographList(id)
{
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var x = document.getElementById("listContainer");
            x.innerHTML = this.responseText;
        }
    };
    xhttp.open("POST", "../Util/showYourPhotographList.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("id=" + id);
}

function updateType(row) {
    var name = document.getElementById("typeTable").rows[row].cells[1].innerHTML;
    var active = document.getElementById("typeTable").rows[row].cells[2].innerHTML;
    var id = document.getElementById("typeTable").rows[row].cells[0].innerHTML;

    document.getElementById("typeName").value = name;
    if (active == "Active") {
        document.getElementById("active").checked = true;
    } else {
        document.getElementById("active").checked = false;
    }

    document.getElementById("id").value = id;
    // Get the modal
    var modal = document.getElementById("updateType");

    modal.style.display = "block";

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[1];

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

function updateTypeSQL() {
    var id = document.getElementById("id").value;
    var name = document.getElementById("typeName").value;
    if (document.getElementById("active").checked) {
        var isActive = 1;
    } else {
        var isActive = 0;
    }

    var xhttp1 = new XMLHttpRequest();
    xhttp1.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var x = document.getElementById("snackbar1");
            if(this.responseText == "The Type has been updated, great work!")
            {
                x.style.backgroundColor="green";
            }
            x.innerHTML = this.responseText;
            x.className = "show";
            setTimeout(function () {
                x.className = x.className.replace("show", "");
            }, 3000);

            showTypeList();
            var modal = document.getElementById("updateType");
            modal.style.display = "none";
        }
    };
    xhttp1.open("POST", "../Util/updateType.php", true);
    xhttp1.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp1.send("id=" + id + "&name=" + name + "&active=" + isActive);
}

function UploadType() {
    var typeName = document.getElementById("name1").value;
    var modal = document.getElementById("myModal");
    var xhttp1 = new XMLHttpRequest();
    xhttp1.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var x = document.getElementById("snackbar");
            if(this.responseText ==  "Type has been added, great work!")
            x.innerHTML = this.responseText;
            x.className = "show";
            setTimeout(function () {
                x.className = x.className.replace("show", "");
            }, 3000);
            showTypeList();
            modal.style.display="none";
        }
    };
    xhttp1.open("POST", "../Util/addTypeLogic.php", true);
    xhttp1.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp1.send("type=" + typeName);
}

function showTypeList() {
    if (document.getElementById("seeActive").checked) {
        var active = 1;
    } else {
        var active = 0;
    }

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("types").innerHTML = this.responseText;
        }
    };
    xhttp.open("POST", "../Util/showType.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("active=" + active);
}

function showAlbumList() {
    if (document.getElementById("activeAlb").checked) {
        var active = 1;
    } else {
        var active = 0;
    }

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("albumContainer").innerHTML = this.responseText;
        }
    };
    xhttp.open("POST", "../Util/showAlbumList.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("active=" + active);
}


function openDeleteModal(id, fname) {
    // Get the modal
    var modal = document.getElementById("delete");


    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[2];

    // When the user clicks the button, open the modal
    modal.style.display = "block";

    span.onclick = function () {
        modal.style.display = "none";
    }


    document.getElementById("hiddenId").value = id;
    document.getElementById("functionName").value = fname;
    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function (event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
}

function deleteObject() {
    var id = document.getElementById("hiddenId").value;
    var fname = document.getElementById("functionName").value;

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var x = document.getElementById("snackbar");
            if(this.responseText == "The album and the photographs were deleted" || this.responseText =="The Type has been deleted")
            {
                x.style.backgroundColor="green";
            }
            x.innerHTML = this.responseText;
            x.className = "show";
            setTimeout(function () {
                x.className = x.className.replace("show", "");
            }, 3000);
            showTypeList();
            showAlbumList();
            var modal = document.getElementById("delete");
            modal.style.display = "none";
        }
    };
    xhttp.open("POST", "../Util/delete.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("id=" + id + " & fname=" + fname);
}

$('#search-box').on("keyup input", function () {
    var input = $('#search-box').val();
    var result = $("#search-table");
    if (input.length) {
        $.get("../Util/myAlbums_user_search.php", {term: input}).done(function (data) {
            result.html(data);
        });
    } else {
        result.empty();
    }
});

function deletePhoto(id) {
    var modal = document.getElementById("viewYourPhotographs");
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var x = document.getElementById("snackbar");
            if (this.responseText == "The photograph was deleted.")
            {
                x.style.backgroundColor="green";
            }
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
    xhttp.send("photoId=" + id + " &deleteP=2");
}

function isActive(id) {
    var modal = document.getElementById("viewYourPhotographs");
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var x = document.getElementById("snackbar");
            if(this.responseText == "The Photos have been added, great work!")
            {
                x.style.backgroundColor="green";
            }
            x.innerHTML = this.responseText;
            x.className = "show";
            setTimeout(function () {
                x.className = x.className.replace("show", "");
            }, 3000);
         //   modal.style.display = "block";
            showYourPhotographList(id);
            modal.style.display = "none";
        }
    };
    xhttp.open("POST", "../Util/isPhotoActive.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("photoId=" + id + " &isActive=2");
}
