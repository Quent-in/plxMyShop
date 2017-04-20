window.onload=function() {
 // get tab container
 var container = document.getElementById("tabContainer");
 // set current tab
 var navitem = container.querySelector(".tabs ul li");
 //store which tab we are on
 var ident = navitem.id.split("_")[1];
 navitem.parentNode.setAttribute("data-current",ident);
 //set current tab with class of activetabheader
 navitem.setAttribute("class","tabActiveHeader");

 //hide two tab contents we don't need
 var pages = container.querySelectorAll(".tabpage");
 for (var i = 1; i < pages.length; i++) {
   pages[i].style.display="none";
 }

 //this adds click event to tabs
 var tabs = container.querySelectorAll(".tabs ul li");
 for (var i = 0; i < tabs.length; i++) {
   tabs[i].onclick=displayPage;
 }
}

// on click of one of tabs
function displayPage() {
 var current = this.parentNode.getAttribute("data-current");
 //remove class of activetabheader and hide old contents
 document.getElementById("tabHeader_" + current).removeAttribute("class");
 document.getElementById("tabpage_" + current).style.display="none";

 var ident = this.id.split("_")[1];
 //add class of activetabheader to new active tab and show contents
 this.setAttribute("class","tabActiveHeader");
 document.getElementById("tabpage_" + ident).style.display="block";
 this.parentNode.setAttribute("data-current",ident);
}