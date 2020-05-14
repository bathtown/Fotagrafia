// for safari, to make hover available
document.body.addEventListener('touchstart', function () {}, false);

// home page
// goto top
function goTop() {
    window.scrollTo({
        top: 0,
        behavior: "smooth"
    });
}

// refresh pictures
function refreshPic() {
    // 刷新页面
    location.reload();
    alert('This is my pj!');
}

// details page
// heart++

function likedPlus() {
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
function switchDeAndPro() {
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
function show(file) {
    const reader = new FileReader();
    const img = document.getElementById('uploadPic');

    reader.onload = function (evt) {
        img.src = evt.target.result;
    };
    reader.readAsDataURL(file.files[0]);
    document.getElementById("uploadPicBox").style.display = "flex";
    document.getElementsByClassName("uploadBtn")[0].style.display = "none";
}

// search page
// show search result
function searchResult() {
    alert('This is my pj!');
    document.getElementsByClassName('result')[0].style.display = 'block';
    if (document.getElementsByClassName('filter')[0]) {
        const filterAny = document.getElementsByClassName('filter')[0];
        filterAny.setAttribute('class', "filterAfter");
    }

    const width = document.body.clientWidth;
    const extension = document.getElementsByClassName('search_extension')[0];
    if (width <= 830)
        extension.style.display = 'flex';
    filterAny = document.getElementsByClassName('filterAfter')[0];
    if (filterAny.style.display = 'block' && width <= 830) {
        filterAny.style.display = 'none';
        extension.style.display = 'flex';
    } else {
        filterAny.style.display = 'block';
    }
}
// show search box
function showSearchBox() {
    document.getElementsByClassName('filterAfter')[0].style.display = 'block';
    document.getElementsByClassName('search_extension')[0].style.display = 'none';
}

//my hearts & my gallery pages
// make del & modify buttons appear
function buttonAppear() {
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
// condition
if (document.getElementsByClassName("onePic") && document.body.clientWidth <= 830) {
    buttonAppear();
    let hinter = document.getElementsByClassName("hinter")[0];
    if (document.getElementById("myHearts")) {
        hinter.innerHTML = "My Hearts | try ←👆";
    }
    if (document.getElementById("myGallery")) {
        hinter.innerHTML = "My Gallery | try ←👆";
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

    function newEvent(type) {
        return new Event(type, {
            bubbles: true,
            cancelable: true
        });
    }

    function touchCancel() {
        coord = {}
    }

    function touchStart(e) {
        const c = e.touches[0];
        start = {
            x: c.clientX,
            y: c.clientY,
            time: Date.now()
        };
        el = e.target;
        el = 'tagName' in el ? el : el.parentNode;
    }

    function touchMove(e) {
        const t = e.touches[0];
        coord = {
            x: t.clientX - start.x,
            y: t.clientY - start.y
        }
    }

    function touchEnd() {
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
function browserAsideAppear() {
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

// browser page
data = {
    China: ['Shanghai', 'Kunming', 'Beijing', 'Yantai'],
    Japan: ['Tokyo', 'Osaka', 'Kamakura'],
    Italy: ['Roma', 'Milan', 'Venice', 'Florence'],
    America: ['New York', 'San Francisco', 'Washington']
};
// initial countries
function initialFilter() {
    const country = document.getElementById("country");

    for (let i in data) {
        let countryOption = document.createElement("option");
        countryOption.innerHTML = i;
        country.appendChild(countryOption);
    }
}
if (document.getElementById("country")) {
    initialFilter();
}
// initial cities
function countrysCity(thisCountry) {
    const choice = (thisCountry.options[thisCountry.selectedIndex]).innerHTML;
    const city = document.getElementById("city");

    let options = city.children;
    // remove pre children
    for (let k = 0; k < options.length; k++) {
        city.removeChild(options[k]);
        k--;
    }
    // add default one
    let CityOption = document.createElement("option");
    CityOption.innerHTML = "...";
    CityOption.style.display = "none";
    city.appendChild(CityOption);
    // add new children
    for (let i in data[choice]) {
        CityOption = document.createElement("option");
        CityOption.innerHTML = data[choice][i];
        city.appendChild(CityOption);
    }
}

// login page
function hintRegister() {
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