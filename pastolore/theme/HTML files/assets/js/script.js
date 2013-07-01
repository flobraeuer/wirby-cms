var boardInterval = null;
var boardBusy = false;

$( function()
{
  // carousel
  $('.carousel').carousel();
  
  $( '.form-select .options li' ).click( function()
  {
    $( this ).parents( '.options' ).hide();
    
    $( this ).parents( '.options' ).siblings( '.selected' ).html( $( this ).html() );
  } );
  
  // custom select
  $( '.form-select .arrow' ).click( function()
  {
    if( $( this ).siblings( '.options' ).css( 'display' ) == 'block' )
    {
      $( this ).siblings( '.options' ).hide();
    }
    else
    {
      var curr = $( this ).siblings( '.selected' ).html();
      
      $( this ).siblings( '.options' ).children( 'li' ).each( function()
      {
        if( $( this ).html() == curr )
        {
          $( this ).hide();
        }
        else
        {
          $( this ).show();
        }
      } );
      
      $( this ).siblings( '.options' ).show();
    }
  } );
  
  // animate board
  board();
  
  // animate home gallery
  home_gallery();
  
  // bind message close
  $( '.message-close' ).live( 'click', function()
  {
    $( this ).parents( '.message' ).fadeOut( 'fast',
      function()
      {
        $( this ).remove();
      } );
  } );
  
  // google maps
  if( $( '#mape' ).length > 0 )
  {
    var lln =new google.maps.LatLng(52.375435,16.939453);
            
    var map = new google.maps.Map( document.getElementById( 'mape' ), {
      streetViewControl: false,
      zoom: 14,
      width: 220,
      mapTypeControl: false,
      panControl: false,
      zoomControl: false,
      scrollwheel: false,
      scaleControl: false,
      overviewMapControl: false,
      disableDefaultUI: true,
      center: lln,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    } );

    var marker = new google.maps.Marker({
      position: lln,
      title: 'Olipizza',
      icon: 'assets/img/olipizza-marker.png'
    });

    marker.setMap( map );

    marker.setAnimation( google.maps.Animation.BOUNCE );
  }
} );

// animate home gallery
function home_gallery()
{
  if( $( '.home-gallery' ).length > 1 )
  {
    setInterval( function()
    {
      var current = $( '.home-gallery:visible' );
      
      current.fadeOut( 'slow', function()
      {
        if( current.next().length == 0 )
        {
          $( '.home-gallery:first-child' ).fadeIn( 'slow' );
        }
        else
        {
          $( this ).next().fadeIn( 'slow' );
        }
      } );
    }, 8000 );
  }
}

// animate board
function board()
{
  if( $( '.board-inner .item' ).length == 1 )
  {
    $( '.board-nav' ).hide();
    return false;
  }
  
  $( '.board-nav li' ).unbind().bind( 'click', function()
  {
    if( $( this ).hasClass( 'active' ) || boardBusy )
    {
      console.debug( 'return false' );
      return false;
    }
    else
    {
      clearInterval( boardInterval );
      
      $( '.board-nav .active' ).removeClass( 'active' );
      $( this ).addClass( 'active' );
      
      var index = $( this ).prevAll().length + 1;
      
      $( '.board-inner .active' ).fadeOut( 250, function()
      {
        $( this ).removeClass( 'active' );

        $( '.board-inner .item:nth-child(' + index + ')' ).fadeIn( 250, function()
        {
          $( this ).addClass( 'active' );
        } );
      } );
    }
    
    board();
  } );
  
  boardInterval = setInterval( function()
  {
    boardBusy = true;
    
    $( '.board-inner .active' ).fadeOut( 250, function()
    {
      $( this ).removeClass( 'active' );
      
      if( $( this ).next().length == 0 )
      {
        $( '.board-inner .item:first-child' ).fadeIn( 250, function()
        {
          boardBusy = false;
          $( this ).addClass( 'active' );
        } );
      }
      else
      {
        $( this ).next().fadeIn( 250, function()
        {
          $( this ).addClass( 'active' );
          boardBusy = false;
        } );
      }
    } );
    
    navActive = $( '.board-nav .active' );
    
    navActive.removeClass( 'active' );      
    
    if( navActive.next().length == 0 )
    {
      $( '.board-nav li:first-child' ).addClass( 'active' );
    }
    else
    {
      navActive.next().addClass( 'active' );
    }
  }, 5000 );
}

// contact send
function contact_send()
{
  contact_data = new Object();
  contact_data.name = $( '#contact-form input[name="name"]' ).val();
  contact_data.email = $( '#contact-form input[name="email"]' ).val();
  contact_data.message = $( '#contact-form textarea[name="message"]' ).val();
  
  // validation
  if( contact_data.name == '' )
  {
    $( '#contact-form input[name="name"]' ).addClass( 'error' );
    return false;
  }
  else
  {
    $( '#contact-form input[name="name"]' ).removeClass( 'error' );
  }
  
  if( contact_data.email == '' || !/^[a-zA-Z0-9_\.\-]+\@([a-zA-Z0-9\-]+\.)+[a-zA-Z0-9]{2,4}$/.test( contact_data.email ) )
  {
    $( '#contact-form input[name="email"]' ).addClass( 'error' );
    return false;
  }
  else
  {
    $( '#contact-form input[name="email"]' ).removeClass( 'error' );
  }
  
  if( contact_data.message == '' )
  {
    $( '#contact-form textarea[name="message"]' ).addClass( 'error' );
    return false;
  }
  else
  {
    $( '#contact-form textarea[name="message"]' ).removeClass( 'error' );
  }
  
  // e-mail send via AJAX
  $.ajax(
  {
    type: 'POST',
    url: 'ajax_contact.php',
    data: 'name=' + contact_data.name + '&email=' + contact_data.email + '&message=' + contact_data.message,
    success: function()
    {
      $( '#contact-form input[name="name"]' ).val( '' );
      $( '#contact-form input[name="email"]' ).val( '' );
      $( '#contact-form textarea[name="message"]' ).val( '' );
      $( '.header-big' ).after( '<table class="message" style="display: none;"><tbody><tr><td class="message-icon"><span><img alt="" src="assets/img/icon/ticket.png"></span></td><td><p><strong>Message sent:</strong> We will answer you soon as is possible.</p></td><td class="message-close"><img alt="" src="assets/img/message-close.png"></td></tr></tbody></table>' );
      $( '.message' ).fadeIn();
    }
  } );
}