const backendSrc = 'http://localhost:8080/backend/PHP/api';
const backendImgSrc = 'http://localhost:8080/backend/travel-images/large';

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
        $.confirm({
            title: 'What\'s up?',
            content: 'Are you sure that you wanna log out?',
            buttons: {
                Sure: {
                    text: "Sure",
                    btnClass: 'btn-blue',
                    action: function () {
                        window.sessionStorage.clear();
                        window.location.href = '../html/login.html';
                    }
                },
                cancel: {}
            }
        });
    })

    // im looking
    $('.imlooking').removeAttr('href');
    $('.imlooking').click(function () {
        if (window.location.href.includes('upload.html?id='))
            window.location.href = '../html/upload.html';
    });

    // hinter
    if ($(".onePic") && document.body.clientWidth <= 830) {
        buttonAppear();
        if ($("#myHearts").length) $(".hinter").text("My Hearts | try ←👆");
        if ($("#myGallery").length) $(".hinter").text("My Gallery | try ←👆");
        if ($('#browser').length) $(".hinter").text(" try 👆→ | Browser | try ←👆");
    }

    // for safari, to make hover available
    document.body.addEventListener('touchstart', function () { }, false);
    // condition
    if (document.getElementsByClassName("de_choice de_myProperties")[0]) {
        switchDeAndPro();
    }
})

// open details
function openDetail (event) {
    const id = event.target.getAttribute('data-id');
    window.open(`../html/details.html?id=${id}`, "_blank");
}

// getQueryVariable
function getQueryVariable (variable) {
    const query = window.location.search.substring(1);
    const vars = query.split("&");
    for (let i = 0; i < vars.length; i++) {
        let pair = vars[i].split("=");
        if (pair[0] == variable) { return pair[1]; }
    }
    return false;
}

// img fits div
function ImgFitDiv (filter, width, height) {
    $(filter).on('load', function () {
        const divRatio = height / width;
        const imgRatio = $(this)[0].naturalHeight / $(this)[0].naturalWidth;

        let parent = $(this).parent();
        let parentWidth = parent[0].offsetWidth;
        let paretHeight = parseInt(parentWidth * divRatio)
        parent.css('height', paretHeight);

        let imgWidth = ($(this)[0].naturalWidth * paretHeight) / $(this)[0].naturalHeight
        let imgHeight = ($(this)[0].naturalHeight * parentWidth) / $(this)[0].naturalWidth

        if (imgRatio >= divRatio) {
            $(this).css({ width: '100%', position: 'relative', bottom: `${(imgHeight - paretHeight) / 2}px`, height: 'auto', right: 0 })
        } else {
            $(this).css({ height: '100%', position: 'relative', right: `${(imgWidth - parentWidth) / 2}px`, width: 'auto', bottom: 0 })
        }
    });
}

function getCountries (filter) {
    return $.ajax({
        method: "GET",
        url: `${backendSrc}/JSONCountry.php`,
    }).done((data) => {
        for (let index = 0; index < data.countries.length; index++) {
            let newOption = $(`<option value="${data.countries[index]}">${data.countries[index]}</option>`);
            $(filter).append(newOption)
        }
    }).fail((err) => {
        if (err.status === 0) { myAlert('error', 'Connection refused!'); return; }
        myAlert('error', JSON.parse(err.responseText).message);
    });
}

function countrysCity (countryFilter, cityFilter) {
    $(cityFilter).empty();

    // console.log(country.options[country.selectedIndex].text);
    return $.ajax({
        method: "GET",
        url: `${backendSrc}/JSONCity.php`,
        data: { country: $(countryFilter).val() }
    }).done((data) => {
        for (let index = 0; index < data.cities.length; index++) {
            let newOption = $(`<option value="${data.cities[index]}">${data.cities[index]}</option>`);
            $(cityFilter).append(newOption)
        }
    }).fail((err) => {
        if (err.status === 0) { myAlert('error', 'Connection refused!'); return; }
        myAlert('error', JSON.parse(err.responseText).message);
    });
}

function searchImg (choice, text, page = 1) {
    if (!text) {
        myAlert('warning', `Please fill in ${choice}!`)
        return
    }

    return $.ajax({
        method: "GET",
        url: `${backendSrc}/imgSearch.php`,
        data: { choice: choice, text: text, page: page }
    }).done((data) => {
        return data;
    }).fail((err) => {
        console.log(err.responseText);

        if (err.status === 0) { myAlert('error', 'Connection refused!'); return; }
        myAlert('error', JSON.parse(err.responseText).message);
    });
}

function showPageNum (pageNum) {
    if (getQueryVariable('page') == 1 && pageNum >= 5)
        for (let index = 5; index > 0; index--) {
            if (index == getQueryVariable('page')) $('#before').after(`<span class="current">${index}</span>`);
            else $('#before').after(`<span>${index}</span>`);
        }
    else if ((Number)(getQueryVariable('page')) > 1 && pageNum - (Number)(getQueryVariable('page')) >= 4)
        for (let index = (Number)(getQueryVariable('page')) + 3; index > (Number)(getQueryVariable('page')) - 2; index--) {
            if (index == getQueryVariable('page')) $('#before').after(`<span class="current">${index}</span>`);
            else $('#before').after(`<span>${index}</span>`);
        }
    else if (pageNum - (Number)(getQueryVariable('page')) < 4 && pageNum >= 5)
        for (let index = pageNum; index > pageNum - 5; index--) {
            if (index == getQueryVariable('page')) $('#before').after(`<span class="current">${index}</span>`);
            else $('#before').after(`<span>${index}</span>`);
        }
    else
        for (let index = pageNum; index > 0; index--) {
            if (index == getQueryVariable('page')) $('#before').after(`<span class="current">${index}</span>`);
            else $('#before').after(`<span>${index}</span>`);
        }
}

function pageNumClick (pageNum) {
    $('.pageNum span').click(function (event) {
        const page = event.currentTarget.innerText;
        switch (page) {
            case '<': {
                if ((getQueryVariable('page') == 1)) myAlert('warning', 'It\'s the first page 🙄')
                else window.location.href = window.location.href.replace(/=[0-9]*/, '=' + ((Number)(getQueryVariable('page')) - 1))
                break;
            }
            case '<<': {
                window.location.href = window.location.href.replace(/=[0-9]*/, '=' + 1)
                break;
            }
            case '>': {
                if ((getQueryVariable('page') == pageNum)) myAlert('warning', 'It\'s the last page 🙄')
                else window.location.href = window.location.href.replace(/=[0-9]*/, '=' + ((Number)(getQueryVariable('page')) + 1))
                break;
            }
            case '>>': {
                window.location.href = window.location.href.replace(/=[0-9]*/, '=' + pageNum)
                break;
            }
            default: {
                window.location.href = window.location.href.replace(/=[0-9]*/, '=' + page)
                break;
            }
        }
    })
}