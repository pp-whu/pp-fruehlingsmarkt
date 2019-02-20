$('.no-js').removeClass('no-js').addClass('js');

// SVG-Unterstützung für IE laden.
svg4everybody();

// Menü ein-/ausblenden.
$('.toggle').each(function() {

  var toggle_for = $('#' + $(this).data('for'));

  toggle_for.hide();

  $(this).click(function(e) {
    $(this).toggleClass('active');
    toggle_for.slideToggle();
  });
});
$( document ).ready(function() {
  $('#erlesenes .content-inner').wrap('<div class="bg-circle"></div>');
  $('#erlesenes picture').appendTo($("#erlesenes"));
  $('.fts-jal-single-fb-post').removeAttr('style');
});

/**
 * Add hash to url without scrolling
 *
 * @param String $url - it could be hash or url with hash
 *
 * @return void
 */
function addHashToUrl($url)
{
  if ('' == $url || undefined == $url) {
    $url = '_'; // it is empty hash because if put empty string here then browser will scroll to top of page
  }
  $hash = $url.replace(/^.*#/, '');
  var $fx, $node = jQuery('#' + $hash);
  if ($node.length) {
    $fx = jQuery('<div></div>')
            .css({
                position:'absolute',
                visibility:'hidden',
                top: jQuery(window).scrollTop() + 'px'
            })
            .attr('id', $hash)
            .appendTo(document.body);
    $node.attr('id', '');
  }
  document.location.hash = $hash;
  if ($node.length) {
    $fx.remove();
    $node.attr('id', $hash);
  }
}

// Akkordeon.
var template_path = $('html').data('path');
$('.accordion').addClass('js').find('.a_header').each(function(index, value) {
    $(this).wrap('<a class="a_link" href="#"></a>').parent().append('<i class="a_icon"><svg role="img" class="symbol" aria-hidden="true" focusable="false"><use xlink:href="' + template_path + '/img/icons.svg#arrow-down"></use></svg></i>');
})

$('.a_link').click(function(e) {
    e.preventDefault();
    var accLink = $(this);
    var accParent = $(this).parent();

    if (accParent.hasClass('a_open')) {
        $('.a_open .a_content').slideUp(500).promise().done(function() {
          accLink.find('.a_icon').replaceWith('<i class="a_icon"><svg role="img" class="symbol" aria-hidden="true" focusable="false"><use xlink:href="' + template_path + '/img/icons.svg#arrow-down"></use></svg></i>');
          $('.a_open').removeClass('a_open');
        });
    } else {
        $('.a_open .a_content').slideUp(500).promise().done(function() {
            accLink.find('.a_icon').replaceWith('<i class="a_icon"><svg role="img" class="symbol" aria-hidden="true" focusable="false"><use xlink:href="' + template_path + '/img/icons.svg#arrow-up"></use></svg></i>');
            $('html, body').animate({
                scrollTop: (accParent.offset().top-145)
            }, 500);

            $('.a_open').removeClass('a_open');
            accLink.next().slideDown(500);
            accParent.addClass('a_open');
            addHashToUrl(accParent.attr('id'));
        });
    }
    return false;
});

$('.a_link').mouseup(function() {
    this.blur();
})

// Grid Karte.
function initMaps() {
    var locationLists = document.getElementsByClassName('locations');

    Array.prototype.forEach.call(locationLists, function(locationList) {
        var mapCanvas = locationList.getElementsByClassName('map')[0];
        var mapOptions = {
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            zoom: 15
        }
        var infoWindow = new google.maps.InfoWindow();
        var map = new google.maps.Map(mapCanvas, mapOptions);
        var latLngBounds = new google.maps.LatLngBounds();

        var addressList = locationList.getElementsByClassName('address');


        Array.prototype.forEach.call(addressList, function(address) {
            var lat = address.getElementsByClassName("lat")[0].getAttribute("content"),
                lng = address.getElementsByClassName("lng")[0].getAttribute("content"),
                ttl = address.getElementsByTagName('h3')[0].textContent;

            var marker = new google.maps.Marker({
                position: new google.maps.LatLng(lat, lng),
                title: ttl,
                draggable: false,
                map: map
            });

            google.maps.event.addListener(marker, "click", function(e) {
                infoWindow.setContent('<p><strong>' + ttl + '</strong></p><a href="http://maps.google.de/?q=' + lat + ',' + lng + '" target="_blank">Auf Google Maps anzeigen</a>');
                infoWindow.open(map, marker);
            });

            latLngBounds.extend(marker.position);
        });

        var bounds = new google.maps.LatLngBounds();
        if (addressList.length > 1) {
            map.fitBounds(latLngBounds);
        }
        map.setCenter(latLngBounds.getCenter());
    });

}

if ($(".locations").length > 0) {
    var script = document.createElement('script');
    script.src = '//maps.googleapis.com/maps/api/js?key=AIzaSyBQJ__YgeTKzO4wh-4-SDKqDxP9xFJl3Vk&callback=initMaps';
    document.body.appendChild(script);
}

$('a[href^="#"]').on('click', function(e){
  var href = $(this).attr('href');
  $('html, body').animate({
    scrollTop:$(href).offset().top-50
  },'slow');
  e.preventDefault();
});

// Add sticky class to body when scrolling
$(function() {
    $(window).scroll(function() {
        var scroll = $(window).scrollTop();

    });
    if (scroll > 600) {
        $('#header').addClass('sticky');
        // if ( $('.beans').parent().is( 'a' ) ) {
        //   $('.beans').unwrap();
        // }
        // $('.beans').wrap('<a href="https://www.beans-books.de/"></a>');
    } else {
        $('#header').removeClass('sticky');
        // if ( $('.beans').parent().is( 'a' ) ) {
        //   $('.beans').unwrap();
        // }
        // $('#content').removeAttr('style');
    }
});
