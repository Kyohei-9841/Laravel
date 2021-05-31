async function httpcConnect(fd, url, redirect_url) {
    try{
        await fetch(url, {
            method: "POST",
            headers: {
                'X-CSRF-Token': document.getElementsByName("csrf-token").item(0).content
            },
            processData: false,
            contentType: false,
            body: fd
        })
        .then(response => {
            console.log("成功しました");
            func_loard_hide();
            location.href = redirect_url;
        })
        .catch(error => {
            console.log(error);
            console.log("失敗しました");
            throw error;
        });    
    } catch(e) {
        throw e;
    }
}

function func_loard_display(text) {
    try{
        document.getElementById("loader-text").innerHTML=text;
        var h = $(window).height();
        document.getElementById('container').style.display = 'none';
        var loader = document.getElementById('loader-bg', 'loader');
        loader.style.height = h;
        loader.style.display = '';
    } catch(e) {
        throw e;
    }
}

function func_loard_hide() {
    try{
        window.setTimeout(() => {
            document.getElementById('loader-bg').animate({
                opacity: [0, 1]
            }, {
                direction: 'reverse',
                duration: 600
            })    
        }, 700);
        window.setTimeout(() => {
            document.getElementById('loader-bg', 'loader').animate({
                opacity: [0, 1]
            }, {
                direction: 'reverse',
                duration: 150
            })
        }, 300);
        document.getElementById('container').style.display = '';
    } catch(e) {
        throw e;
    }
}
