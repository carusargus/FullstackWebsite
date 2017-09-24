/* Toggle between adding and removing the "responsive" class to mNav when the user clicks on the icon */
function responsiveNav() {
    var mNavElement = document.getElementById("myNav");
    if (mNavElement.className === "mNav") {
        mNavElement.className += " responsive";
    } else {
        mNavElement.className = "mNav";
    }
}