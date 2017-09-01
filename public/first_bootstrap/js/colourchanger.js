/////////////////- Colour Change -//////////////////////////

initialColour1 = "1a000d";//"7b4397";
initialColour2 = "0000la";//"000d1a";//"dc2430";
// setInterval(function(){updateColour()}, 1000);

function updateColour(){
    initialColour1 = (parseInt(initialColour1, 16) + 1).toString(16);
    initialColour2 = (parseInt(initialColour2, 16) + 1).toString(16);
    mastheadDiv = document.getElementById("main_div");
    mastheadDiv.style.background =  "url(../../images/bg-pattern.png), #" + initialColour2;
    mastheadDiv.style.background =  "url(../../images/bg-pattern.png), -webkit-linear-gradient(to left, #"+initialColour1+", #"+ initialColour2+")";
    mastheadDiv.style.background =  "url(../../images/bg-pattern.png), linear-gradient(to left, #"+initialColour1+", #"+initialColour2+")";
}

