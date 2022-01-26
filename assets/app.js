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

window.addEventListener("load", ()=> {
    if (localStorage.getItem('cookieAccept') != "true") {

        let text = "Accepter les cookies ?";
    
        if(confirm(text) === true){
            localStorage.setItem('cookieAccept', "true");
        } else {
            localStorage.setItem('cookieAccept', "true");
        }
    }
    
    /////////////////////////////////////////////////////////////////////// Home ///////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////// Responsive ////////////////////////////////////////////////////////////////////////////
    
    window.addEventListener("resize", function() {
        let img1 = document.getElementById("home_img_1");
        let img2 = document.getElementById("home_img_2");
    
        if (window.screen.width <= 500){
            if (img1 != null) {
                img1.setAttribute("src", "img/home/ImageHomeMini.png");   
            }
        }
        else if (window.screen.width <= 425){
            if (img2 != null) {
                img2.setAttribute("src", "img/home/broGamer.png");
            }
        }
        else{
            if (img1 != null && img2 != null) {
                img1.setAttribute("src", "img/home/ImageHome.png");
                img2.setAttribute("src", "img/home/broGamer.png");
            }
        }
    })
    
    ///////////////////////////////////////////////////////////////// Js modif profil-image /////////////////////////////////////////////////////////////////////////
    
    if (document.getElementById("profil_profil_img") != null) {
    
        let select = document.getElementById("profil_profil_img");
    
        select.addEventListener("change", ()=> {
            let selectValue = select.value.slice(0, 7);
            let allImage = document.querySelectorAll(".img_profil_edit");
        
            allImage.forEach(img => {
                console.log(selectValue, img.getAttribute("src").slice(-11, -4));
                if (selectValue == img.getAttribute("src").slice(-11, -4)) {
                    img.classList.add("borderSelectedImgProfil");
                } else {
                    img.classList.remove("borderSelectedImgProfil")
                }
            });
        })
    }
})

