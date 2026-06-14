// back-to-top
document.addEventListener("DOMContentLoaded", () => {
    const mybutton = document.getElementById("btn-back-to-top");

    if (!mybutton) return;

    const scrollFunction = () => {
        if (
            document.body.scrollTop > 20 ||
            document.documentElement.scrollTop > 20
        ) {
            mybutton.classList.remove("hidden");
        } else {
            mybutton.classList.add("hidden");
        }
    };

    const backToTop = () => {
        window.scrollTo({
            top: 0,
            behavior: "smooth",
        });
    };

    mybutton.addEventListener("click", backToTop);
    window.addEventListener("scroll", scrollFunction);
});

import { Carousel, initTWE } from "tw-elements";
import "./hamburger";
initTWE({ Carousel });

import intlTelInput from "intl-tel-input";
import "intl-tel-input/dist/css/intlTelInput.css";

window.intlTelInput = intlTelInput;

