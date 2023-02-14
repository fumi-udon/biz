window.calcurry = function(){
    var  b = $('#number').val();
    var r = b * 0.155;
    var r2 = Math.floor(r);

    var p = b * 0.0036;
    var p2 = Math.floor(p);

    $("#roux").text(r2);
    $("#poud").text(p2);
}