import { createPopper } from "@popperjs/core";
const popcorn = document.querySelector(".avatar");
const tooltip = document.querySelector("#logo");
createPopper(popcorn, tooltip, {
  placement: "bottom",
});
