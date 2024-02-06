import Alpine from 'alpinejs'
import intersect from '@alpinejs/intersect'

// plugins have to be imported before Alpine is started
Alpine.plugin(intersect)

Alpine.start()
window.Alpine = Alpine


document.addEventListener('DOMContentLoaded', function () {
    // select all elements with data-collapse-toggle="navbar-cta"
    const navbarCta = document.querySelectorAll('[data-collapse-toggle="navbar-cta"]');

    // loop through all elements with data-collapse-toggle="navbar-cta"
    navbarCta.forEach((navbarCtaEl) => {
        // add click event listener
        navbarCtaEl.addEventListener('click', handleHamburgerMenuClick);
    });

    assignTabSliderEvents();

});


function handleHamburgerMenuClick() {
    // select element with data-collapse-toggle="navbar-cta"
    const navbarCta = document.querySelector('[data-collapse-toggle="navbar-cta"]');

    // set the target element that will be collapsed or expanded (eg. navbar menu)
    const targetEl = document.getElementById('navbar-cta');

    // toggle the aria-expanded attribute
    navbarCta.setAttribute('aria-expanded', targetEl.classList.contains('hidden') ? 'true' : 'false');

    // toggle the hidden class
    targetEl.classList.toggle('hidden');
}


function assignTabSliderEvents() {
    // do that for each .tab-slider
    let tabSliders = document.querySelectorAll(".tab-slider")

    tabSliders.forEach(tabSlider => {
        let tabs = tabSlider.querySelectorAll(".tab")
        let panels = tabSlider.querySelectorAll(".tab-panel")

        tabs.forEach(tab => {
            tab.addEventListener("click", ()=>{
                let tabTarget = tab.getAttribute("aria-controls")
                // set all tabs to data-active-tab = false
                tabs.forEach(tab =>{
                    tab.setAttribute("data-active-tab", "false")
                })

                // set the clicked tab to data-active-tab = true
                tab.setAttribute("data-active-tab", "true")

                panels.forEach(panel =>{
                    let panelId = panel.getAttribute("id")
                    if(tabTarget === panelId){
                        panel.classList.remove("hidden", "opacity-0")
                        panel.classList.add("block", "opacity-100")
                        // animate panel fade in

                        panel.animate([
                            { opacity: 0, maxHeight: 0 },
                            { opacity: 1, maxHeight: "100%" }
                        ], {
                            duration: 500,
                            easing: "ease-in-out",
                            fill: "forwards"
                        })

                    } else {
                        panel.classList.remove("block", "opacity-100")
                        panel.classList.add("hidden", "opacity-0")

                        // animate panel fade out
                        panel.animate([
                            { opacity: 1, maxHeight: "100%" },
                            { opacity: 0, maxHeight: 0 }
                        ], {
                            duration: 500,
                            easing: "ease-in-out",
                            fill: "forwards"
                        })
                    }
                })
            })
        })

        let activeTab = tabSlider.querySelector(".tab[data-active-tab='true']")
        activeTab.click()
    })

}
