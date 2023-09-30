const links = document.querySelectorAll('.nav-links a');
const body = document.querySelector("body"),
    sidebar = body.querySelector(".sidebar"),
    toggle = body.querySelector(".toggle"),
    searchBtn = body.querySelector(".search-box"),
    modeSwitch = body.querySelector(".toggle-switch");
    modeText = body.querySelector(".mode-text");


    toggle.addEventListener('click', () => {
        sidebar.classList.toggle('close');
    })

    searchBtn.addEventListener('click', () => {
        sidebar.classList.remove('close');
    })

    // modeSwitch.addEventListener('click', () => {
    //     body.classList.toggle('dark');

    //     if(body.classList.contains('dark')) {
    //         modeText.innerText = 'Light Mode'
    //     } else {
    //         modeText.innerText = 'Dark Mode'
    //     }
// })

// const time = new Date();
// const now = time.getHours()

// const dark = () => {
//     if(now >= 18 || (now >= 1 && now <= 6)) {
//         body.classList.add('dark');
//     } else if (now >= 17 && now <= 7) {
//         body.classList.remove('dark');
//     }
// }

// window.addEventListener('DOMContentLoaded', () => dark);
