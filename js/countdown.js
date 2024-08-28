// Set the date we're counting down to
var countDownDate = new Date("Jan 5, 2030 15:37:25").getTime();

var endDate = new Date(
  document.getElementById("auction_end_date").value
).getTime();
var startDate = new Date(
  document.getElementById("auction_start_date").value
).getTime();
var dateNow = new Date(
  document.getElementById("auction_date_now").value
).getTime();

var starting_price = document.getElementById("auction_starting_price").value;
var ending_price = document.getElementById("auction_ending_price").value;

// Update the count down every 1 second
var x = setInterval(function () {
  // Get today's date and time
  var now = new Date().getTime();

  // Find the distance between now and the count down date

  var distance = endDate - now;
  // dateNow = dateNow - 1000;

  // Time calculations for days, hours, minutes and seconds
  var days = Math.floor(distance / (1000 * 60 * 60 * 24));
  var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
  var seconds = Math.floor((distance % (1000 * 60)) / 1000);

  // Display the result in the element with id="demo"
  document.getElementById("demo").innerHTML =
    days + "d " + hours + "h " + minutes + "m " + seconds + "s ";

  // If the count down is finished, write some text
  if (distance < 0) {
    clearInterval(x);
    document.getElementById("demo").innerHTML = "EXPIRED";
    document.getElementById("auction_price").innerHTML =
      "Price: " + ending_price;
  } else {
    let totalTime = endDate - startDate;
    let progress = now - startDate;
    let percentage = ((progress / totalTime) * 100).toFixed(2);
    let increment = (ending_price - starting_price) * (percentage / 100);
    console.log(ending_price, starting_price);
    let newPrice = (parseInt(starting_price) + increment).toFixed(2);

    document.getElementById("auction_price").innerHTML = "Price: " + newPrice;
  }
}, 1000);
