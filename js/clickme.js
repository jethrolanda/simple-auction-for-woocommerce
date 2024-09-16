import { store, getContext, getElement } from "@wordpress/interactivity";

const { state } = store("clickme", {
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
    },
    toggle: () => {
      const context = getContext();
      console.log(state.someValue);
      context.isOpen = !context.isOpen;
      context.offers.pop();
    }
  },
  callbacks: {
    setOfferPrice: () => {
      const context = getContext();
      const { ref } = getElement();
      context.offerPrice = ref.value;
    },
    logIsOpen: () => {
      const context = getContext();
      console.log(`Is open: ${context.isOpen}`);
    }
  }
});
