// Get the modal
var modal = document.getElementById("myModal");

// Get the button that opens the modal
var btn = document.getElementById("myBtn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal
btn.onclick = function () {
  modal.style.display = "block";
};

// When the user clicks on <span> (x), close the modal
span.onclick = function () {
  modal.style.display = "none";
};

// When the user clicks anywhere outside of the modal, close it
window.onclick = function (event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
};

jQuery(document).ready(function ($) {
  // Here you register for the event and do whatever you need to do.
  $(document).on("data-attribute-changed", function (e, param) {
    var offers = $("form.cart").data("product-attr");
    console.log(e, param, offers);
    $(".bid-offers");
    $(`<tr><td>${param.name}</td><td>${param.price}</td><td>Time</td></tr>`)
      .insertAfter(".bid-offers tr:nth-child(1)")
      .animate({ backgroundColor: "green" }, 400);
  });

  $("#myModal")
    .find(".place-offer")
    .on("click", function () {
      var offers = $("form.cart").data("product-attr");
      console.log(offers);
      var offer = $("#myModal").find(".qty").val();
      var uid = bid_script.uid;
      var pid = bid_script.pid;
      if (offer > 0) {
        $.ajax({
          type: "post",
          dataType: "json",
          url: bid_script.ajax_url,
          data: {
            action: "safw_place_offer",
            nonce: $("#place_offer").val(),
            offer,
            uid,
            pid
          },
          success: function (response) {
            $("form.cart").data("product-attr", response.offers);
            // Whenever you change the attribute you will user the .trigger
            // method. The name of the event is arbitrary
            $(document).trigger("data-attribute-changed", response.data);
          }
        });
      } else {
        console.log("offer cant be 0");
      }
    });
});
