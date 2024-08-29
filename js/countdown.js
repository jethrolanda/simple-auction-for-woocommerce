var endDate = new Date(
  document.getElementById("auction_end_date").value
).getTime();

var startDate = new Date(
  document.getElementById("auction_start_date").value
).getTime();

var starting_price = document.getElementById("auction_starting_price").value;
var ending_price = document.getElementById("auction_ending_price").value;

var bid_start_el = document.getElementById("bid_start");

// Update the count down every 1 second
var x = setInterval(function () {
  // Get today's date and time
  var now = new Date().getTime();

  // Find the distance between now and the count down date

  if (bid_start_el == null) {
    var distance = endDate - now;
  } else {
    var distance = startDate - now;
  }

  // dateNow = dateNow - 1000;

  // Time calculations for days, hours, minutes and seconds
  var days = Math.floor(distance / (1000 * 60 * 60 * 24));
  var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
  var seconds = Math.floor((distance % (1000 * 60)) / 1000);

  // Display the result in the element with id="bid_ends"
  if (bid_start_el == null) {
    document.getElementById("bid_ends").innerHTML =
      days + "d " + hours + "h " + minutes + "m " + seconds + "s ";
  } else {
    document.getElementById("bid_start").innerHTML =
      days + "d " + hours + "h " + minutes + "m " + seconds + "s ";
  }

  // If the count down is finished, write some text
  if (distance < 0) {
    clearInterval(x);
    if (bid_start_el == null) {
      document.getElementById("bid_ends").innerHTML =
        "EXPIRED at " + document.getElementById("auction_end_date").value;
      document.getElementById("auction_price").innerHTML =
        "Price: " + ending_price;
    }
  } else {
    if (bid_start_el == null) {
      let totalTime = endDate - startDate;
      let progress = now - startDate;
      let percentage = ((progress / totalTime) * 100).toFixed(2);
      let increment = (ending_price - starting_price) * (percentage / 100);

      let newPrice = (parseInt(starting_price) + increment).toFixed(2);

      document.getElementById("auction_price").innerHTML = "Price: " + newPrice;
    }
  }
}, 1000);
