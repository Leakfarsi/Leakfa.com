var msie = window.navigator.userAgent.indexOf("MSIE ");
if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./)) {
    location.href = "/ie.html"
}
