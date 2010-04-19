/* 
 * 
 */

function setHeight2() {
    var h; // Объявляем переменную h - высота
    var b = document.getElementById('content');
    if (!b) return;
    h = (window.innerHeight ? window.innerHeight : (document.documentElement.clientHeight ? document.documentElement.clientHeight : document.body.offsetHeight));
    b.style.height = (h - 120) + 'px';
}

