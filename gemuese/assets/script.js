function maps_ready(){
  if(! $("#map").length){
    log("map not embedded");
  }
  else{
    log("map ready");

    var mapCenter = new google.maps.LatLng(48.13728, 16.35954);
    var map = new google.maps.Map(document.getElementById("map"), {
      zoom: 12,
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

    var markerPos = new google.maps.LatLng(48.1787, 16.376);
    var marker = new google.maps.Marker({
      position: markerPos,
      map: map,
      label: "M",
      title:"M&M Obst und Gemüse"
    });
  };
};

function log(msg){
  if(typeof console != "undefined") console.log(msg);
};

function site_ready(){
  log("site ready");

  // init jQuery.address for tabs
  $.address.history(true)             // browser
           .strict(true)              // "/"
           .tracker($.noop);          // do it the own way

  $.address.change(function(event) {  // internal and external
    var id = event.path.split("/")[1];
    log("addressed "+id);
    $("#tab-"+id).tab('show');
  });

  // prepare tabs
  if(window.no_ajax){
    log("we won't load contents");
  }
  else if($(".tab-content").length){  // if there isn't a specific site
    $(".tab-content").load("/", {"type":"content"}); // load "everything" now

    $("#tab-menu a").each(function(i,a){
      $(a).attr("href", "#"+$(a).attr("href"));
    });
    $("#tab-menu a").bind("click", function(e){
      e.preventDefault();
      var id = $(this).attr("href").split("#")[1];
      log("clicked "+id);
      $.address.value(id);
      return false;
    });
  };

  // activate if there is one active
  //$("#tab-menu .active a").trigger("click");

  // prepare email links
  $("a").each(function(i,a){
    var link = $(a);
    if (link.text().match(/\(a\)/)){
    var text = link.text().replace("(a)","@");
        link.text(text).attr("href","mailto:"+text);
    };
  });

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
  log("form binded");

  if(window.no_dataTable){
    log("datatable not rendered");
  }
  else if( $(".dataTable table").length ){
    // add templates to dom
    ich.grabTemplates();
    log("templates added");

    // prepare order form
    window.dataTable = $(".dataTable table").dataTable( {
      "sDom": "<'row-fluid'<'pull-left'f><'pull-left'p><'pull-right'ri>><'row-fluid't><'pull-left'p>",
      "bStateSave": false,
      "bAutoWidth": true,
      "bSort": false,
      "bPaginate": true,
      "sPaginationType": "bootstrap",
      "bLengthChange": false,
      "iDisplayLength": 60,
      "oLanguage": {
        "sSearch": "Nach _INPUT_ suchen",
        "oPaginate": {
          "sFirst": "&lsaquo;&lsaquo;",
          "sLast": "&rsaquo;&rsaquo;",
          "sNext": "",
          "sPrevious": ""
        },
        "sInfo": "_START_ bis _END_ aus <span class='label label-important'>_TOTAL_ Artikel</span>",
        "sInfoFiltered": " von _MAX_ gesamt",
        "sInfoEmpty": "gefiltert <span class='label label-important'>nichts gefunden</span>",
        "sEmptyTable": "Wir aktualisieren gerade unser Produktsortiment. Bitte kontaktieren Sie uns telefonisch.",
        "sZeroRecords": "Diesen Artikel führen wir leider nicht. Ändere gegebenenfalls den Suchfilter oberhalb."
      },
      "aoColumns": null,
      "fnCreatedRow": function( row, data, index ) {
        $("td", row).first().prepend( $("<input>").attr("type", "checkbox") );
        // if the checkbox is clicked, the TableTools click is also triggered, so there is no binding necessary
        var last = $("td", row).last();
        last.html( ich.add_input({
          "verpackung": last.text()
        }) );
        last.find("input").on("blur change", function(e){
          check_item( last.parent()[0] );
        });
      }
    } );
    log("datatable created");

    window.dataTools = new TableTools(dataTable, {
      "sRowSelect": "multi",
      "sSelectedClass": "active",
      "fnRowSelected": function(nodes){ check_item(nodes[0]); },
      "fnRowDeselected": function(nodes){ check_item(nodes[0]); }
    } );
    log("datatable tools");

    // add demo chart
    ich.add_item({
      "demo": true,
      "artikel": "Ananas Extra Sweet",
      "menge": 5,
      "verpackung": "Stk"
    }).appendTo("#order-items");
    ich.add_item({
      "demo": true,
      "artikel": "Apfel Golden Delicious",
      "menge": 8,
      "verpackung": "kg"
    }).appendTo("#order-items");

    // bind buttons
    $("#step1-btn").on("click", function(){
      order_items();
      $("#step1").hide();
      $("#step2").show();
    });
    $("#step2-btn").on("click", function(){
      //$(this).addClass("disabled");
      send_order();
    });
    $("#step2-back-btn").on("click", function(){
      $("#step2").hide();
      $("#step1").show();
    });
    log("buttons binded");

  } else {
    log("datatable not embedded");
  };
};

function check_item(row){
  var input = $("input:text", row);
  if(window.dataTools.fnIsSelected(row)){
    if(!input.val().length){
      window.dataTools.fnDeselect(row);
    }else{
      $("input:checkbox", row).attr("checked", true);
    };
  }else{
    if(input.val().length){
      window.dataTools.fnSelect(row);
    }else{
      $("input:checkbox", row).attr("checked", false);
    };
  };
};

function order_items(){
  rows = window.dataTools.fnGetSelected();
  $(rows).each(function(i, row){
    order_item(row);
  });
};

function order_item(row){
  var data = window.dataTable.fnGetData(row); // original data
  //var head = window.dataTable.fnGetData($("thead tr").first()[0]); // is null
  var list = $("#order-items");
  var info = $("#order-info");
  var name = unescape(data[0].replace(/[\s\W]/g,"-").toLowerCase());
  var item = $("#order-item-"+name);

  if( item.length ) {
    item.remove();
  };
  ich.add_item({
    "id": "order-item-"+name,
    "artikel": data[0],
    "menge": $("input:text", row).val(),
    "verpackung": $("button", row).text().trim()
  }).appendTo(list);

  $(".demo", list).remove();
  info.removeClass("alert-error").text("In deiner Bestellung befinden sich "+list.children().length+" Artikel.");
};

function order_dropdown(element){
  console.log(element);
  var e = $(element);
  var d = e.parents("ul").siblings("button").find("span");
  d.text( e.text() );
};

function send_order(){
  var items = [];
  $("#order-items").children("li").each(function(i, item){
    item = $(item);
    items.push([
      item.find("input[name=artikel]").val(),
      item.find("input[name=menge]").val(),
      item.find("input[name=verpackung]").val()
    ]);
  });
  var post = {
    "name": $("input[name=gender]:checked").val()+" "+$("input[id=name]").val(),
    "customer": $("input[id=customer]").val(),
    "number": $("input[id=number]").val(),
    "email": $("input[id=email]").val(),
    "street": $("input[id=street]").val(),
    "code": $("input[id=code]").val(),
    "town": $("input[id=town]").val(),
    "items": items
  }
  if($("input[id=terms]").is(":checked")){
    if(
      $("input[name=gender]:checked").length > 0 &&
      post.name.length > 0 &&
      post.customer.length > 0 &&
      post.number.length > 0 &&
      post.email.length > 0 &&
      post.street.length > 0 &&
      post.code.length > 0 &&
      post.town.length > 0
    ){
      $("#step2-btn").addClass("disabled");
      $.ajax({
        url: "/",
        type: "post",
        data: { "type": "order", "order": post },
        dataType: "json",
        success: function(data, text, xhr){
          log(data.msg);
          alert("Danke für die Bestellung, "+data.name+"!");
        },
        error: function(xhr, text, error){
          log(text+":");
          log(error);
          alert("Leider ist ein Fehler aufgetreten.\nRufen Sie uns bitte unter +43 660 6522007 an.\nDanke!")
        },
        complete: function(){
          $("#step2-btn").removeClass("disabled");
        }
      });
    }
    else alert("Bitte fülle alle Daten aus. Danke!");
  }
  else alert("Bitte akzeptiere unsere Geschäftsbedingungen. Danke!");
}

/**
 * Slide Tabs
 *

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

// Slide Leistungen

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

// Insert Google Maps

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


// function codeMaps(map, street){
//   var address = $("#maps").attr("data-maps");
//   var geocoder = google.maps.Geocoder()
//   if (geocoder){
//     geocoder.geocode( { 'address': street}, function(results, status) {
//       if (status == google.maps.GeocoderStatus.OK) {
//         map.setCenter(results[0].geometry.location);
//         var marker = new google.maps.Marker({
//             map: map,
//             position: results[0].geometry.location
//         });
//       } else {
//         alert("Geocode was not successful for the following reason: " + status);
//       }
//     });
//   }
// }

// Validate Contact Form

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

// Google Maps Images dynamically
// var map1 = $("<img>"); map1.attr("src", "http://maps.google.com/maps/api/staticmap?center=48.23474,16.31957&zoom=14&size=640x273&maptype=roadmap&markers=color:gray%7Clabel:K%7C48.23874,16.31957&sensor=false");
// var map2 = $("<img>"); map2.attr("src", "http://maps.google.com/maps/api/staticmap?center=48.23474,16.35610&zoom=14&size=210x273&maptype=roadmap&sensor=false");
// $("#map1").html(map1); $("#map2").html(map2);
//
//
// function loadMaps() {
//   log("loadMaps ()");
//   var script = document.createElement("script");
//   script.type = "text/javascript";
//   script.src = "http://maps.google.com/maps/api/js?sensor=false&callback=showMaps&key=ABQIAAAAdzX5NIg5QEz64ynjdmHhBxRyP7INfmQOJaH34RLKrPvgrZzQvhRwfAWimbc76Un8fpqh5vNjIYurOQ";
//   document.body.appendChild(script);
// };
//
// window.onload = function () {
//   setTimeout(function () {
//     window.scripts = [];
//     (function () {
//       if(src = window.scripts.shift()) {
//          tag = document.createElement('script');
//          tag.setAttribute('type','text/javascript');
//          tag.setAttribute('src', src);
//          document.getElementsByTagName('head')[0].appendChild(tag);
//          tag.onload = arguments.callee;
//       };
//     })();
//   }, 1);
// }

*/
