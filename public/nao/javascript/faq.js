function rotate() {
    var elm = document.getElementsByClassName('fa-arrow-circle-down');
    var className = elm.className;
    if(className.indexOf('rotate') === -1) {
        elm.className = elm.className + ' rotate';
    } else {
        elm.className = elm.className.replace(' rotate', '');
    }
}