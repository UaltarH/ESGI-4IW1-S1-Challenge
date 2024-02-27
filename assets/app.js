/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)

// css
import "./styles/app.scss";

// js
import $ from "jquery";

import "./js/components/tables/tables.js";
import "./js/product/productComponentsManage.js";
document.addEventListener("DOMContentLoaded", function() {
    // main menu toggle
    const mainNav = document.querySelector('.main-nav ul');
    const burger = document.querySelector('.menu-burger');

    burger.addEventListener('click', () => {
        console.log('clicked');
        console.log(mainNav);
        console.log(burger);
        mainNav.classList.toggle('sm:-left-full');
    });
});
