var table = document.getElementById("calendarTable");
var eventInput = document.getElementById("eventName");
let monthAndYear = document.getElementById("monthAndYear");

table.addEventListener("click", function (event) {
  let focusList = document.getElementsByClassName("focus");
  if (focusList.length == 1) {
    focusList[0].classList.remove("focus");
  }
  focusList = [];
  event.target.classList.add("focus");
  // if (eventInput.value == "") {
  // } else {
  //   event.target.innerHTML += `<br>${eventInput.value}`;
  //   eventInput.value = "";
  // }
});
