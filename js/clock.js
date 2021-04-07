window.onload = setInterval(clock,1000);

function clock()
{
	var d = new Date();
	
	var date = d.getDate();
	
	var month = d.getMonth();
	var montharr =["Jan","Feb","Mar","April","May","June","July","Aug","Sep","Oct","Nov","Dec"];
	month=montharr[month];
	
	var year = d.getFullYear();
	
	var day = d.getDay();
	var dayarr =["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"];
	day=dayarr[day];
	
	var hour =d.getHours();
	var min = d.getMinutes();
  var sec = d.getSeconds();
  
  if (min < 10)
  {
    min = "0"+min;
  }
  if (hour < 10)
  {
    hour = "0"+hour;
  }
  if (sec < 10)
  {
    sec = "0"+sec;
  }

	document.getElementById("timedate").innerHTML=hour+":"+min+":"+sec+" | "+day+" "+date+" "+month+" "+year;
}