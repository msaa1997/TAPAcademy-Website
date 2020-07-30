
var url = document.URL;
var id = url.split("=")[1];

var xhttp = new XMLHttpRequest();
xhttp.onreadystatechange = function() {
	console.log(this.readyState)
	if (this.readyState == 4 && this.status == 200) {
		document.getElementById("premiumValue").innerHTML = this.responseText;
	}
};
console.log("http://ec2-3-87-121-179.compute-1.amazonaws.com/Forms/retrievePremium.php?id="+id);
xhttp.open("POST", "http://ec2-3-87-121-179.compute-1.amazonaws.com/Forms/retrievePremium.php?id="+id, true);
xhttp.send("Your JSON Data Here");
