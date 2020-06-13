// for safari, to make hover available
document.body.addEventListener('touchstart', function () { }, false);

// home page
// goto top
function goTop () {
    window.scrollTo({
        top: 0,
        behavior: "smooth"
    });
}

// refresh pictures
function refreshPic () {
    // 刷新页面
    location.reload();
}

// details page
// heart++

function likedPlus () {
    const likedNumberObj = document.getElementById("likedNumber");
    let num = likedNumberObj.textContent;
    const heart = document.getElementById("liking");
    if (heart.style.color === "rgb(255, 225, 225)" || heart.style.color === "") {
        num++;
        heart.style.color = "orangered";
    } else {
        num--;
        heart.style.color = "rgb(255, 225, 225)";
    }
    likedNumberObj.innerHTML = num;
    alert('This is my pj!');
}

// switch description and properties
function switchDeAndPro () {
    document.getElementsByClassName("de_choice de_myProperties")[0].style.display = "none";

    // 上面两个tab
    const choice1 = document.getElementById("description");
    const choice2 = document.getElementById("properties");

    choice1.onclick = function () {
        document.getElementsByClassName("de_choice de_myProperties")[0].style.display = "none";
        document.getElementsByClassName("de_choice de_myWords")[0].style.display = "block";
        choice1.className = "selected";
        choice2.className = "";
    };

    choice2.onclick = function () {
        document.getElementsByClassName("de_choice de_myProperties")[0].style.display = "inline-table";
        document.getElementsByClassName("de_choice de_myWords")[0].style.display = "none";
        choice1.className = "";
        choice2.className = "selected";
    };
}
// condition
if (document.getElementsByClassName("de_choice de_myProperties")[0]) {
    switchDeAndPro();
}

// upload page
// show picture
function show (file) {
    const reader = new FileReader();
    const img = document.getElementById('uploadPic');

    reader.onload = function (evt) {
        img.src = evt.target.result;
    };
    reader.readAsDataURL(file.files[0]);
    document.getElementById("uploadPicBox").style.display = "flex";
    document.getElementsByClassName("uploadBtn")[0].style.display = "none";
}

//my hearts & my gallery pages
// make del & modify buttons appear
function buttonAppear () {
    let onePic = document.getElementsByClassName("onePic");
    for (let i = 0; i < onePic.length; i++) {
        let addr = onePic[i].children[0].children[0].onclick;
        let picture = onePic[i].children[0];
        let button = onePic[i].children[1].children[2];
        picture.addEventListener("swipeLeft", function () {
            if (button != undefined) {
                picture.style.filter = "opacity(0.5)";
                picture.children[0].onclick = " ";
                button.style.display = "block";
            }
        });
        picture.addEventListener("swipeRight", function () {
            if (onePic[i].children[1].children[2] != undefined) {
                picture.style.filter = "none";
                picture.children[0].onclick = addr;
                button.style.display = "none";
            }
        });
    }
}

// touch function
(function () {
    let coord = {},
        start = {},
        el;

    document.addEventListener('touchstart', touchStart);
    document.addEventListener('touchmove', touchMove);
    document.addEventListener('touchend', touchEnd);
    document.addEventListener('touchcanel', touchCancel);

    function newEvent (type) {
        return new Event(type, {
            bubbles: true,
            cancelable: true
        });
    }

    function touchCancel () {
        coord = {}
    }

    function touchStart (e) {
        const c = e.touches[0];
        start = {
            x: c.clientX,
            y: c.clientY,
            time: Date.now()
        };
        el = e.target;
        el = 'tagName' in el ? el : el.parentNode;
    }

    function touchMove (e) {
        const t = e.touches[0];
        coord = {
            x: t.clientX - start.x,
            y: t.clientY - start.y
        }
    }

    function touchEnd () {
        const touchTimes = Date.now() - start.time,
            c = 250 > touchTimes && Math.abs(coord.x) > 40 || Math.abs(coord.x) > 120,
            s = 250 > touchTimes && Math.abs(coord.y) > 40 || Math.abs(coord.y) > 120,
            left = coord.x < 0,
            top = coord.y < 0;
        if (250 > touchTimes && (isNaN(coord.y) || Math.abs(coord.y)) < 12 && (isNaN(coord.x) || Math.abs(coord.x) < 12)) {
            el.dispatchEvent(newEvent('tap'));
        } else if (750 < touchTimes && (isNaN(coord.y) || Math.abs(coord.y)) < 12 && (isNaN(coord.x) || Math.abs(coord.x) < 12)) {
            el.dispatchEvent(newEvent('longTap'));
        }
        c ? el.dispatchEvent(left ? newEvent('swipeLeft') : newEvent('swipeRight')) : s && el.dispatchEvent(top ? newEvent('swipeUp') : newEvent('swipeDown'));

        coord = {};
    }
}());

// browser page
// swipe right to show aside, swipe left to show filter
function browserAsideAppear () {
    const browserAside = document.getElementsByClassName("browserAside")[0];
    const mainPic = document.getElementsByClassName("mainPic")[0];
    const browserResult = document.getElementsByClassName("browserResult")[0];
    const pageNum = document.getElementsByClassName("pageNum")[0];
    const threeFilter = document.getElementById("threeFilter");

    mainPic.addEventListener("swipeRight", function () {
        browserAside.style.display = "flex";
        browserResult.style.display = "none";
        pageNum.style.display = "none";
    });

    mainPic.addEventListener("swipeLeft", function () {
        threeFilter.style.transform = "translateX(0)";
    });

    threeFilter.addEventListener("swipeRight", function () {
        threeFilter.style.transform = "translateX(1000px)";
    });

    browserAside.addEventListener("swipeLeft", function () {
        browserAside.style.display = "none";
        browserResult.style.display = "flex";
        pageNum.style.display = "initial";
    });
}
// condition
if (document.getElementsByClassName("browserAside")[0])
    browserAsideAppear();

// login page
function hintRegister () {
    var hintIt = document.getElementById("hintIt");
    let counter = setInterval(function () {
        if (hintIt.style.display == "inline-block")
            hintIt.style.display = "none";
        else
            hintIt.style.display = "inline-block";
    }, 400);
    setTimeout(function () {
        clearInterval(counter)
    }, 1500);
}
if (document.getElementById("hintIt")) {
    hintRegister();
}

// 提示框 warning, success, error
function myAlert (type, content) {
    if (type === 'warning') $.dialog({ title: '⚠ Warning', content: content, type: 'orange', backgroundDismiss: true });
    else if (type === 'success') $.dialog({ title: '✔ Success', content: content, type: 'green', backgroundDismiss: true });
    else if (type === 'error') $.dialog({ title: '❌ Error', content: content, type: 'red', backgroundDismiss: true });
}

$(function () {
    // login toggle
    if (window.sessionStorage.getItem("token")) $('.account').eq(0).hide();
    else $('.account').eq(1).hide();

    // logout
    $('#logout').click(() => {
        window.sessionStorage.clear();
    })

    // im looking
    $('.imlooking').removeAttr('href');

    // hinter
    if ($(".onePic") && document.body.clientWidth <= 830) {
        buttonAppear();
        if ($(".myHearts")) $(".hinter").text("My Hearts | try ←👆");
        if ($(".myGallery")) $(".hinter").text("My Gallery | try ←👆");
    }
})

// open details
function openDetail (event) {
    // console.log(event.target.getAttribute('data-id'));
    const id = event.target.getAttribute('data-id');
    window.open(`../html/details.html?id=${id}`)
}
function getQueryVariable (variable) {
    var query = window.location.search.substring(1);
    var vars = query.split("&");
    for (var i = 0; i < vars.length; i++) {
        var pair = vars[i].split("=");
        if (pair[0] == variable) { return pair[1]; }
    }
    return false;
}
