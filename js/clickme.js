import { store, getContext, getElement } from "@wordpress/interactivity";

const { state } = store("clickme", {
  state: {},
  actions: {
    *submitOffer() {
      try {
        const context = getContext();
        const formData = new FormData();
        formData.append("action", "safw_place_offer");
        formData.append("nonce", state.nonce);
        formData.append("offer", state.offerPrice);
        formData.append("uid", state.uid);
        formData.append("pid", state.pid);
        const data = yield fetch(state.ajax_url, {
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
        // console.log("Server data!", data);
      } catch (e) {
        // Something went wrong!
      }
    },
    makeOffer: (e) => {
      const element = getElement();
      // Logs attributes
      console.log("element attributes => ", element.attributes);
      console.log("making offer", e);
    },
    toggle: () => {
      const context = getContext();
      console.log(state.someValue);
      context.isOpen = !context.isOpen;
    }
  },
  callbacks: {
    setOfferPrice: () => {
      const { ref } = getElement();
      state.offerPrice = ref.value;
    },
    logIsOpen: () => {
      const context = getContext();
      console.log(`Is open: ${context.isOpen}`);
    }
  }
});
