/** 
 ** Start and jQuery.address
 **/

function startKnotzer(cms){
  log("start ()");
  
  // init tabs to avoid jumping boxes
  if(!cms) initLeistungen();
  $("div.tab").hide();
  $("#knotzer").show();
  
  // init jQuery.address for tabs
  $.address.history(true)             // browser
           .crawlable(true)           // "#!" google
           .strict(true)              // "/"
           .tracker($.noop);          // do it the own way
  $.address.change(function(event) {  // internal and external
    console.log(event);
    var id = event.path.split("/")[1];
    log("address ("+id+")");
    slide( id );
  });
  
  // prepare links
  $(".link").bind("click", function(e){
    e.preventDefault();
    var id = $(this).attr("href").split("#")[1];
    log("click ("+id+")");
    $.address.value(id);
    return false;
  });
  
  // prepare email links
  $("a").each(function(i,a){
    var link = $(a);
    if (link.text().match(/\(a\)/)){
    var text = link.text().replace("(a)","@");
        link.text(text).attr("href","mailto:"+text);
    };
  });
  
  // prepare timeline hover
  if(!cms)
  $(".timeline p").removeClass("over")
     .bind("mouseover mouseenter", function(){ $(this).prev().addClass("over"); })
     .bind("mouseleave", function(){ $(this).prev().removeClass("over"); });
  
  // prepare contact form
  $("input,textarea")
    .each(function(i){ // also on focus in
      if(!$(this).data("val")) $(this).data("val", $(this).val());
    })
    .bind("focusin focusout", function(){
      if($(this).val()==$(this).data("val")) $(this).val("");
      else if(!$(this).val().length) $(this).val($(this).data("val"));
    });

  $("#email").bind("submit", function(e){
    e.preventDefault();
    mail();
  });
  $("#email a").bind("click", function(e){
    e.preventDefault(); $("#email").trigger("submit"); return false;
  });
};

/** 
 ** Slide Tabs
 **/

var slide = function(id){
  if(!id) id="knotzer";
  log("slide ("+id+")");
  var box = $("#wide");
  var tab = $("#"+id);
  if(!tab.length) tab = $("#knotzer");
  var pos = tab.position().left;
  
  $("#menu .current").removeClass("current");
  $("."+id).parent().addClass("current");
  
  $("div.tab").hide();
  tab.show();
  box.fadeOut(0, function(){
    $(this).css({"left":-pos}).fadeIn(0, function(){
      if(id=="kontakt"){
        if(typeof google != "undefined" && $.isFunction(google.maps.Map)) window.setTimeout(showMaps, 10);
        else log("no Google");
        $("#button").hide();
      }else $("#button").fadeIn(200);
    });
  });
};

/** 
 ** Slide Leistungen
 **/

function initLeistungen(){
  var leistungenText = $(".slide div");
      leistungenText.each( function(i, text){
        var id = $.trim( $(this).prev("h2").text() );
        var height =  $(this).height();
        if (height>0) $(this).css({"height": height});
        else {
          window.setTimeout(function(){log("fuck");initLeistungen();},500);
          return false;
        };
        log(height+"px for "+id);
      });
      leistungenText.hide();
      //leistungenText.first().show();
      
  var leistungenHead = $(".slide h2");
      //leistungenHead.first().addClass("active");
      leistungenHead.unbind("click").bind("click", function(){
        var head = $(this); //"#"+$(this).attr("id")
        var text = $(this).next("div"); //head.replace("head","text");
        log("show "+$.trim( $(this).text() ));
        $(".slide h2").not(head).removeClass("active");
        $(head).addClass("active");
        $(".slide div").not(text).slideUp(200);
        $(text).slideDown(200);
      });
};

/** 
 ** Insert Google Maps
 **/
 
function showMaps() {
  log("showMaps ()");
  $("#maps").css({"height":300,"width":500});
  
  var mapCenter = new google.maps.LatLng(48.2327, 16.3288);
  var map = new google.maps.Map(document.getElementById("maps"), {
    zoom: 13,
    center: mapCenter,
    mapTypeId: google.maps.MapTypeId.ROADMAP,
    mapTypeControl: true,
    mapTypeControlOptions: {
      style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR, //DROPDOWN_MENU
      position: google.maps.ControlPosition.TOP_LEFT
    },
    zoomControl: true,
    zoomControlOptions: {
      style: google.maps.ZoomControlStyle.LARGE, //SMALL
      position: google.maps.ControlPosition.LEFT_TOP
    },
    panControl: false,  // drag-move
    scaleControl: false,
    streetViewControl: false,
    overviewMapControl: false
  });
  
  var markerPos = new google.maps.LatLng(48.23874, 16.31957);
  var marker = new google.maps.Marker({
    position: markerPos, 
    map: map,
    label: "K",
    title:"Dr. Michael Knotzer"
  });
};

/*
function codeMaps(map, street){
  var address = $("#maps").attr("data-maps");
  var geocoder = google.maps.Geocoder()
  if (geocoder){
    geocoder.geocode( { 'address': street}, function(results, status) {
      if (status == google.maps.GeocoderStatus.OK) {
        map.setCenter(results[0].geometry.location);
        var marker = new google.maps.Marker({
            map: map, 
            position: results[0].geometry.location
        });
      } else {
        alert("Geocode was not successful for the following reason: " + status);
      }
    });
  }
}*/

/** 
 ** Validate Contact Form 
 **/

function mail(){
  var params = {
    "email": {
      "name": $("#email-name").val(),
      "address": $("#email-address").val(),
      "message": $("#email-message").val()
    }
  };
  log(params);
  
  $.ajax({
    type: "POST",
    url: "/cms/mail.php",
    data: params,
    success: function(xhr, text, status){
      if(xhr.status == "success") $("#email a").html("Nachricht versandt. Danke!").addClass("grey");
      else $("#email a").html("Fehler: "+xhr.error).addClass("grey");
    },
    error: function(xhr, text, status){
      log("error");
      $("#email a").html("Fehler beim Versenden").addClass("grey");
    },
    complete: function(){
      window.setTimeout(function(){
        $("#email a").html("Neue Nachricht absenden").removeClass("grey");
      }, 3000);
    }
  });
};

/*

Google Maps Images dynamically
var map1 = $("<img>"); map1.attr("src", "http://maps.google.com/maps/api/staticmap?center=48.23474,16.31957&zoom=14&size=640x273&maptype=roadmap&markers=color:gray%7Clabel:K%7C48.23874,16.31957&sensor=false");
var map2 = $("<img>"); map2.attr("src", "http://maps.google.com/maps/api/staticmap?center=48.23474,16.35610&zoom=14&size=210x273&maptype=roadmap&sensor=false");
$("#map1").html(map1); $("#map2").html(map2);


function loadMaps() {
  log("loadMaps ()");
  var script = document.createElement("script");
  script.type = "text/javascript";
  script.src = "http://maps.google.com/maps/api/js?sensor=false&callback=showMaps&key=ABQIAAAAdzX5NIg5QEz64ynjdmHhBxRyP7INfmQOJaH34RLKrPvgrZzQvhRwfAWimbc76Un8fpqh5vNjIYurOQ";
  document.body.appendChild(script);
};

window.onload = function () {
  setTimeout(function () {
    window.scripts = [];
    (function () {
      if(src = window.scripts.shift()) {
         tag = document.createElement('script');
         tag.setAttribute('type','text/javascript');
         tag.setAttribute('src', src);
         document.getElementsByTagName('head')[0].appendChild(tag);
         tag.onload = arguments.callee;
      };
    })();
  }, 1);
} 

*/