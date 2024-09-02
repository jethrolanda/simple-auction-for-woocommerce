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
  $("#myModal")
    .find(".place-offer")
    .on("click", function () {
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
            alert("Your vote could not be added");
            alert(response);
          }
        });
      } else {
        alert("test");
      }
    });
});
