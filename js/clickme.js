import { store, getContext } from "@wordpress/interactivity";

const { state } = store("clickme", {
  state: {},
  actions: {
    toggle: () => {
      const context = getContext();
      console.log(state.someValue);
      context.isOpen = !context.isOpen;
    }
  },
  callbacks: {
    logIsOpen: () => {
      const context = getContext();
      console.log(`Is open: ${context.isOpen}`);
    }
  }
});
