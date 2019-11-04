$('.tombol').click(function(){
    $('.nav-slider').toggleClass("slide-menu-tampil");
});

function starter_click(){
    // $("#nav-menu-starter").attr("class","active");
    // $("#nav-menu-support").removeAttr("class");
    // $("#nav-menu-setting").removeAttr("class");
    // $("#nav-menu-manage").removeAttr("class");
    window.location = './';
}

function support_click(){
    // $("#nav-menu-starter").removeAttr("class");
    // $("#nav-menu-support").attr("class","active");
    // $("#nav-menu-setting").removeAttr("class");
    // $("#nav-menu-manage").removeAttr("class");
    window.location = 'maps';
}

function setting_click(){
    // $("#nav-menu-starter").removeAttr("class");
    // $("#nav-menu-support").removeAttr("class");
    // $("#nav-menu-manage").removeAttr("class");
    // $("#nav-menu-setting").attr("class","active");
}

function manage_click(){
    // $("#nav-menu-starter").removeAttr("class");
    // $("#nav-menu-support").removeAttr("class");
    // $("#nav-menu-setting").removeAttr("class");
    // $("#nav-menu-manage").attr("class","active");
}