import { store, getContext, getElement } from "@wordpress/interactivity";

const { state } = store("auction", {
  state: {},
  actions: {
    *submitOffer() {
      try {
        const context = getContext();

        const index = context.offers.findIndex((offer) => {
          return offer.uid == state.uid;
        });
        console.log(context.offerPrice);
        if (context.offerPrice === 0 || context.offerPrice === "") {
          console.log("Offer price must not empty");
        } else if (index < 0) {
          // If no offer for this user then create new offer
          // else show error
          const formData = new FormData();
          formData.append("action", "safw_place_offer");
          formData.append("nonce", state.nonce);
          formData.append("offer", context.offerPrice);
          formData.append("uid", state.uid);
          formData.append("pid", state.pid);

          yield fetch(state.ajax_url, {
            method: "POST",
            body: formData
          })
            .then((response) => response.json())
            .then((data) => {
              console.log(data.status, data.data);
              if (data.status === "success") {
                context.offers.unshift(data.data);
              }
            });
        } else {
          console.log("you already provided an offer");
        }
      } catch (e) {
        console.log(e);
      }
    }
  },
  callbacks: {
    setOfferPrice: () => {
      const context = getContext();
      const { ref } = getElement();
      context.offerPrice = ref.value;
    },
    timer: () => {
      const context = getContext();

      var x = setInterval(function () {
        // Get today's date and time
        var now = new Date().getTime();

        // Find the distance between now and the count down date

        if (state.bidding_started) {
          var distance = startDate - now;
        } else {
          var distance = endDate - now;
        }

        // Time calculations for days, hours, minutes and seconds
        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
        var hours = Math.floor(
          (distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)
        );
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);

        // Display the result in the element with id="bidding_timeout"
        if (state.bidding_started) {
          document.getElementById("bidding_started").innerHTML =
            days + "d " + hours + "h " + minutes + "m " + seconds + "s ";
        } else {
          document.getElementById("bidding_soon").innerHTML =
            days + "d " + hours + "h " + minutes + "m " + seconds + "s ";
        }

        // If the count down is finished, write some text
        if (distance < 0) {
          clearInterval(x);
          if (state.bidding_started) {
            document.getElementById("bidding_started").innerHTML =
              "EXPIRED at " + document.getElementById("auction_end_date").value;
            document.getElementById("auction_price").innerHTML =
              "Price: " + ending_price;
          }
        } else {
          if (state.bidding_started) {
            let totalTime = endDate - startDate;
            let progress = now - startDate;
            let percentage = ((progress / totalTime) * 100).toFixed(2);
            let increment =
              (ending_price - starting_price) * (percentage / 100);

            let newPrice = (parseInt(starting_price) + increment).toFixed(2);

            document.getElementById("auction_price").innerHTML =
              "Price: " + newPrice;
          }
        }
      }, 1000);
    }
  }
});
