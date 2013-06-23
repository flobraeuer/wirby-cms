window.wirby_editors = []; // editors
window.wirby_changes = []; // changed editors' ids

function wirby_ready(){
  log("CMS: started");

  // Editors
  wirby_editors = $("[data-wirby]").not("a");
  $("#wirby-editors").text(wirby_editors.length+" Editoren");
  log("CMS: "+wirby_editors.length+" Editors found");

  // Init CKEditor
  wirby_editors.each(function(i, elm){
    wirby_make( elm );
  });

  //wirby_editors.on("click",function(e){
  //  wirby_changed( $(this).attr("id") );
  //});

};

var wirby_count = 0;
function wirby_changed(id){
  if($.inArray(id, wirby_changes) == -1){
    wirby_changes.push(id);
    wirby_count++;
    var l = $("body").data("lang");
    var s = wirby_count>1 ? "Änderungen" : "Änderung";
    var a = $("<a>")
            .attr({"href": "#", "title": "Alle "+(l?l+" ":"")+"Inhalte abschicken"})
            .text(wirby_count+" "+s+" speichern");
    $("#wirby-editors").html(a);
    $("#wirby-editors a").unbind("click").bind("click", function(e){ e.preventDefault(); wirby_save(); });
  };
};

function wirby_save(){
  var contents = {};
  var lang = $("body").data("lang") || "de";
  $.each(wirby_changes, function(i, id){
    console.log("CMS: Save "+id);
    var content = null;
    if( content = $("#"+id).is("img") ) content = $("#"+id).attr("src");
    else content = CKEDITOR.instances[id].getData().replace(/&nbsp;/gi, " ");
    if( content ) contents[id] = content;
    else console.log("Fehler bei id="+id);
  });
  $.ajax({
    url: "/",
    type: "post",
    data: { "type": "update", "contents": contents, "lang": lang },
    dataType: "json",
    success: function(data, text, xhr){
      log(data);
      var txt = data["updated"]+" geändert";
      if(data["inserted"]) txt += " "+data["inserted"]+" hinzugefügt";
      $("#wirby-editors").html( txt );
      wirby_changes = [];
      wirby_count = 0;
    },
    error: function(xhr, text, error){
      log(text+":");
      log(error);
    }
  });
};

function wirby_make(editor){
  $editor = $(editor);                // jquery object, the other one is pure html
  var id = $editor.attr("id");        // if specified by template
  if(!id) id = $editor.data("wirby"); // otherwise take the wirby identifier
  $editor.attr("id", id);             // set it explicitly to avoid problems
  if($editor.is("a")){
    // TODO: editable menu
  }
  else if($editor.is("img")){
    wirby_make_img($editor);
  }
  else{
    // http://docs.ckeditor.com/#!/guide/dev_toolbar
    var config = {
      allowedContent: true, // http://docs.ckeditor.com/#!/guide/dev_advanced_content_filter
      toolbarGroups: [
        { name: "undo", groups: [ "undo", "cleanup" ] },
        { name: "basicstyles", groups: [ "basicstyles", "links" ] }
      ],
      on: {
        "instanceReady": function(){ console.log("CMS: editor ready"); },
        "key": function(){ wirby_changed( id ); }
      }
    };
    if(! $editor.is("h1,h2,h3,h4,h5,h6,span")){
      config.toolbarGroups.push(
        { name: "clipboard" }
      );
    }
    if($editor.is("div")){
      config.toolbarGroups.push(
        "/",
        { name: "align" },
        { name: "paragraph",   groups: [ "list", "indent" ] },
        { name: "blocks", groups: [ "blocks", "tools" ] },
        { name: "find" }
      );
    };

    $editor.attr("contenteditable", "true");
    CKEDITOR.inline(editor, config);
  };

  function wirby_make_img($editor){
    //var width = $editor.width();
    //var height = $editor.height();

    var $wrapper = $editor.parent(".img");    // it is yet wrapped
    if(!$wrapper.length){
      console.log("not wrapped");
      $wrapper = $("<div>").addClass("img");  // wrap it if not
      $editor.wrap($wrapper);
    };
    //$wrapper.css({"height":height, "width":width});
    var $uploader = $("<div>").addClass("uploader");
    $uploader.appendTo($wrapper).fineUploader({ // https://github.com/valums/file-uploader/blob/master/readme.md#options-of-both-fineuploader--fineuploaderbasic
      debug: true,
      multiple: false,
      request: { endpoint: '/?type=upload' },
      deleteFile: { enabled: false }, // https://github.com/valums/file-uploader/blob/master/docs/options-fineuploaderbasic.md#deletefile-option-properties
      dragAndDrop: {
        hideDropzones: false,
        disableDefaultDropzone: true,
        extraDropzones: [$wrapper.get()[0], $uploader.get()[0]]
      },
      text: {
        uploadButton: 'Hierher ziehen oder klicken',
        cancelButton: 'X',
        retryButton: 'Test',
        failUpload: 'Fehler',
        dragZone: 'Hierher ziehen',
        dropProcessing: 'Losgelassen',
        formatProgress: "{percent}% von {total_size}",
        waitingForResponse: "Bitte warten"
      }
    });
    $uploader.on("complete", function(e, id, file, json){
      $editor.attr("src", "/gemuese/files/"+file);
      $editor.data("img", file);
      wirby_changed( $editor.data("wirby") );
    });
    console.log($wrapper);

    // var $form = $("<input>").attr({"type":"file"});
    // $editor.css({"height":height, "width":width});
    // $form.css({"height":height, "width":width});
    // console.log($form);
    // $form.attr({"id": info.id, "name": images+"["+info.id+"]"});

    // var dropZone = $("#area-avatar");
    // var dropNear = function(){ dropZone.addClass("drag"); };
    // var dropOver = function(){ dropZone.addClass("drop"); };
    // var dropOut  = function(){ dropZone.removeClass("drag drop"); };
    // var avatarChoosen = function(event, files, index, xhr, handler, callBack){
    //   formNote(l.note.thanks, l.note.success.profile_avatar, "#form-profile-avatar", "success");
    //   $("#profile-avatar-label").text(l.account.avatarLoading);
    //   callBack(); // start uploading
    // };
    // var avatarLoading = function(e, files, index, xhr, handler){
    //   var percent = parseInt(e.loaded / e.total * 100, 10);
    //   log("snapAuth: avatarProcess", percent+"%");
    //   if(percent>=99) $("#profile-avatar-label").text(l.account.avatarProcess);
    //   else $("#profile-avatar-label").text(l.account.avatarLoading+" ("+percent+"%)");
    // };
    // var avatarLoaded = function(e, files, index, xhr, handler){
    //   log("snapAuth: avatarProcess", "finish");
    //   var text = xhr.responseText? xhr.responseText : (xhr.contents() && xhr.contents().text());
    //   var json = $.parseJSON( text );
    //   var avatar = (json&&json.user) ? json.user.avatar_urls.thumb : false;
    //   if(!avatar) formNote(l.note.error, l.note.profile_avatar, "#form-profile-avatar");
    //   else {
    //     that.user.avatar_urls = {"thumb": avatar};
    //     $("#profile-avatar-thumb").attr('src', avatar);
    //     $("#profile-avatar-label").text(l.account.avatarLoaded);
    //     dropOut();
    //   };
    //   window.setTimeout(function(){
    //     $("#profile-avatar-label").text(l.account.avatarChoose);
    //   }, 2000);
    // };
    //
    // // IE BUG
    // // Object doesn't support this property or method" in snap2.js, zeile 185, zeichen 127
    // $("#form-profile-avatar").fileUpload({
    //   "dragDropSupport": true,    "dropZone": dropZone,
    //   "url": conf.urlUserAvatar,  "method": "POST",
    //   "name": "user[avatar]",     "multipart": true,
    //   "onProgress": avatarLoading,"onLoad": avatarLoaded,
    //   "initUpload": avatarChoosen,"onDocumentDragOver": dropNear,
    //   "onDragOver": dropOver, "onDragEnter": dropOver, "onDrop": dropOver
    // });
  };
};
