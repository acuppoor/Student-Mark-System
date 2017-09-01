/////////////////- Contact Form Clicks -//////////////////////////
emailInput = document.getElementById("email");
existingEmailLbl = document.getElementById("existing_email");
newEmailLbl = document.getElementById("new_email");

newEmailLbl.onclick = function () {
    emailInput.disabled = false;
    this.classList.add("active");
    existingEmailLbl.classList.remove("active");
};

existingEmailLbl.onclick = function () {
    emailInput.setAttribute("disabled", true);
    this.classList.add("active");
    newEmailLbl.classList.remove("active");
};

/////////////////- Contact Form tabs hover -//////////////////////////
newEmailLbl.onmouseover = function () {
    this.style.background = "#fdcc52";
};
newEmailLbl.onmouseleave = function () {
    this.style.background = "";
};


existingEmailLbl.onmouseover = function () {
    this.style.background = "#fdcc52";
}
existingEmailLbl.onmouseleave = function () {
    this.style.background="";
}

