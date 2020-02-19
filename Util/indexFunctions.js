function sendEmail(){
    var fname=document.getElementById("fname").value;
    var lname=document.getElementById("lname").value;
    var email=document.getElementById("email").value;
    var description=document.getElementById("description").value;
    var avail=document.getElementById("availabilities").value;

    var dropdownServ = document.getElementById("service");
    var service = dropdownServ.options[dropdownServ.selectedIndex].value;

    var xhttp=new XMLHttpRequest();
    xhttp.onreadystatechange=function(){
        if(this.readyState==4 && this.status ==200)
        {
            var x = document.getElementById("snackbar");

            var str=this.responseText;

            if(str == "An email has been sent,the owner will contact you soon, Thank you !")
            {
                x.style.backgroundColor="green";
            }
            x.innerHTML=str;
            x.className = "show";
            setTimeout(function () {
                x.className = x.className.replace("show", "");
            }, 3000);
        }
    };
    xhttp.open("POST", "../Util/Functions.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("fname="+fname+"&"+"lname="+lname+"&"+"email="+email+"&"+"description="+description+"&"+"avail="+avail+"&"+"service="+service);
}
function showAll(){
    var xhttp=new XMLHttpRequest();
    xhttp.onreadystatechange=function(){
        if(this.readyState==4 && this.status ==200)
        {
            $("#galleryBox").addClass(".fade-in");
            document.getElementById("galleryContainer").innerHTML=this.responseText;
        }
    };
    xhttp.open("POST", "../Util/selectGalleryType.php", true);
    xhttp.send();
}
function getGalleryType() {
    var dropdownType = document.getElementById("typeDrop");
    var type = dropdownType.options[dropdownType.selectedIndex].value;

    var xhttp1=new XMLHttpRequest();
    xhttp1.onreadystatechange=function(){
        if(this.readyState==4 && this.status ==200)
        {
            document.getElementById("galleryContainer").innerHTML=this.responseText;
        }
    };
    xhttp1.open("POST", "../Util/selectGalleryType.php", true);
    xhttp1.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp1.send("type="+type);
}