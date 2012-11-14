function startCMS(){
  log("CMS: started");
  
  // Editors
  var editors = $("[data-cms]");
  $("#count").text(editors.length+" Editoren gefunden");
  log("CMS: "+editors.length+" Editors found");
  
  // Add Hover Effect
  editors.each(function(i,el){
    var info = $(el).attr("data-cms").split(" ");
    $(el).data("cms", {"type": info[0], "id": info[1]})
         .addClass("cms-"+info[0])
         .bind("click", function(){ makeEditor(this); });
  });
  
  // Bind Form Event
  $("form#cms").bind("submit", function(e){
    if(!confirm("Texte sollen gespeichert werden?")) e.preventDefault();
  });
};

function saveEditors(){
  var areas = $(".cms-area textarea");
  if(areas.length){
    areas.each(function(i){
      $(this).val( $.trim( $(this).val().replace(/\n/g, "<br />") ) );
      if ($(this).val().match(/\w+(\(a\))\w+/g)){
        var link = "<a href='#' target='_self' 'title'='Emailprogramm öffnen'>" //var link = $("<a>").attr({"href":"#", "target":"_self", "title":"Emailprogramm öffnen"});
                 + $(this).val().match(/(\S+\(a\)\S+)/)[0] + "</a>";
        $(this).val( $(this).val().replace(/\S+\(a\)\S+/g, link) );
      };
    });
  };
  log("save");
  $("form#cms").submit();
};

var count = 0;
function countEditors(){
  count++;
  var s = count>1 ? "Änderungen" : "Änderung";
  var a = $("<a>").css({"color":"IndianRed"})
          .attr({"href": "#", "title": "alles abschicken"})
          .text(count+" "+s+". Jetzt speichern");
  $("#count").html(a);
  $("#count a").unbind("click").bind("click", function(e){ e.preventDefault(); saveEditors(); });
};

function makeEditor(editor){
  $(editor).unbind("click").css({"position":"relative"});
  var name = "contents";
  var html = $(editor).html();
  var info = $(editor).data("cms"); log(info);
  
  // Take Style
  var width = $(editor).width();
  var height = $(editor).height()-3;
  //if(info.id.match(/kontakt-contact/)) height=55;
  
  // One Line
  if ($.inArray(info.type, ["head","button","input"])>-1){
    var form = $("<input>").val(html);
  }
  // Multi Line
  else if (info.type == "area"){
    html = $.trim( html.replace(/<br>|<br \/>/ig, "\n") );
    html = html.replace(/<a .+>(.+)@(.+)<\/a>/ig, "$1(a)$2");
    var form = $("<textarea>").val(html);
    form.css({"height": height});
    
  }
  // Editor
  else if (info.type == "editor"){
    var form = $("<textarea>").val(html);
    form.css({"height": height, "width": width});
  }
  // Image Upload
  else if (info.type == "image"){
    name = "images"; // for php: instead of "contents"
    var form = $("<input>").attr({"type":"file"});
    $(editor).css({"height":height, "width":width});
    $(form).css({"height":height, "width":width});
  };
  
  form.attr({"id": info.id, "name": name+"["+info.id+"]"})
  
  $(editor).html(form);
  countEditors();
  
  if(info.type == "editor") wysiwyg(info.id);
};

function wysiwyg(id, less){
  var form = $("#"+id);
  var tiny = form.parent().hasClass("tiny");
  log(tiny);
  
  form.ckeditor(function(){
    form.parent().removeClass("timeline");
    log("CKeditor loaded for "+form.attr("id"));
  },
  {
    language : 'de',
    uiColor : '#eee',
    height: 600,
    
    // removeDialogTabs = 'flash:advanced;image:Link',
    resize_dir : 'vertical',
    bodyClass : (form.parent().attr("class") || ""),
    contentsCss: '/css/main.css',
    enterMode : CKEDITOR.ENTER_BR,

    format_tags : 'h2;p',

    toolbar : (less ? 'tiny' : 'small'),
    toolbar_small : [
      ['Undo','Redo','Copy','Paste','RemoveFormat','-','Link','Unlink','-','Source'],
      ['Bold','Italic','-','NumberedList','BulletedList','Outdent','Indent','CreateDiv','-','Format']
    ],
    toolbar_tiny : [
      ['Undo','Redo','-','Link','Unlink','-','Source']
    ]
  });
};
