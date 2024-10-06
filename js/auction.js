import { store, getContext, getElement } from "@wordpress/interactivity";

const { state } = store("auction", {
  state: {},
  actions: {
    *submitOffer() {
      try {
        const context = getContext();
        context.is_bidding_started = !context.is_bidding_started;

        const index = context.offers.findIndex((offer) => {
          return offer.uid == state.uid;
        });

        if (context.offerPrice === 0 || context.offerPrice === "") {
          toastr.error("Offer price must not empty");
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
          toastr.error("You already provided an offer");
        }
      } catch (e) {
        console.log(e);
      }
    }
  },
  callbacks: {
    test: () => {
      console.log("test");
    },
    setOfferPrice: () => {
      const context = getContext();
      const { ref } = getElement();
      context.offerPrice = ref.value;
    },
    timer: () => {
      const context = getContext();

      const endDate = new Date(context.end_date).getTime();

      const startDate = new Date(context.start_date).getTime();

      var x = setInterval(function () {
        // Get today's date and time
        var now = new Date().getTime();

        // Find the distance between now and the count down date

        // The auction has started
        if (context.is_bidding_started) {
          var distance = endDate - now;
        } else {
          // Future auction
          var distance = startDate - now;
        }

        // Time calculations for days, hours, minutes and seconds
        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
        var hours = Math.floor(
          (distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)
        );
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);

        // Display the result in the element with id="bidding_timeout"
        days = days > 0 ? `${days} Days` : "";
        hours = hours > 0 ? `${hours} Hours` : "";
        minutes = minutes > 0 ? `${minutes} Minutes` : "";
        seconds = seconds > 0 ? `${seconds} Seconds` : "";

        let timer = `${days} ${hours} ${minutes} ${seconds}`;
        if (context.is_bidding_started) {
          context.time_left = `Time Left: ${timer}`;
        } else {
          context.time_left = `Starting Soon: ${timer}`;
        }

        // If the count down is finished, write some text
        if (distance < 0 && context.is_bidding_started === false) {
          context.is_bidding_started = true;
        } else {
          if (context.is_bidding_started) {
            let totalTime = endDate - startDate;
            let progress = now - startDate;
            let percentage = ((progress / totalTime) * 100).toFixed(2);
            let increment =
              (ending_price - starting_price) * (percentage / 100);

            let newPrice = (parseInt(starting_price) + increment).toFixed(2);

            context.auction_price = newPrice;
          }
        }

        if (distance < 0 && context.is_bidding_started) {
          clearInterval(x);
          context.auction_price = ending_price;
          context.time_left = "ENDED";
          context.is_bidding_ended = true;
        }
      }, 1000);
    }
  }
});
