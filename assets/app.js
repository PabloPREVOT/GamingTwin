/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.scss';

// start the Stimulus application
// import './bootstrap';

require("bootstrap");

/////////////////////////////////////////////////////////////////////// Home ///////////////////////////////////////////////////////////////////////////////

let img1 = document.getElementById("home_img_1");
let img2 = document.getElementById("home_img_2");

// window.addEventListener("resize", () => {
//     if(document.querySelector('#width') <= 425){
//         img1.getAttribute("src") = "img/home/ImageHomeMini.png";
//         img2.getAttribute("src") = "img/home/matching.Mini.png";
//     };
// });

window.addEventListener("resize", function() {
    if (window.screen.width <= 500){
        img1.setAttribute("src", "img/home/ImageHomeMini.png");
    }
    else if (window.screen.width <= 425){
        img2.setAttribute("src", "img/home/broGamer.png");
    }
    else{
        img1.setAttribute("src", "img/home/ImageHome.png");
        img2.setAttribute("src", "img/home/broGamer.png");
    }
})