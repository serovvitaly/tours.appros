@extends('layout')

@section('content') 

<div class="row">
  <div class="span10">
    <div id="searh-result">
      <table class="results rounded white table table-bordered table-striped table-hover">
        <thead><tr>
          <th style="width: 100px;">Дата заезда</th>
          <th style="width: 50px;">Ночей</th>
          <th>Отель</th>
          <th>Курорт</th>
          <th style="width: 160px;">Питание</th>
          <th style="width: 100px;">Размещение</th>
          <th style="width: 100px;">Стоимость</th>
          <th style="width: 50px;">Места</th>
        </tr></thead>
        <tbody>
       
        </tbody>
      </table>
      
      <div style="text-align: center; margin: 0 0 20px;">
        <button style="display: none;" class="btn" id="search-result-load-button" onclick="showResults(20)">Показать еще</button>
      </div>
        
    </div>
    <div class="ajax-loader"></div>  
  </div>
  <div class="span2">
    <div class="filter rounded white" style="margin-left: -20px; padding: 5px;">
      @include('filter')
            
      <button class="button button-rounded button-flat-action" style="width: 100%;" onclick="goSearch()">Искать</button>
      
    </div>
  </div>
</div>


<script>

var searchResult = [];
var searchResultStart = 0;

function openPopup(el, cls) {
  var popup = { el : $('<div class="popup opening"><div class="background"></div><div class="scroll"><div class="playout"></div></div>') }, 
    close = $('<div class="cross"></div>');
    
  popup.layout = popup.el.find('.playout'),
  popup.background = popup.el.find('.background')
  popup.scroll = popup.el.find('.scroll')
  
  if (cls) popup.el.addClass(cls)
  
  popup.layout.append(close);
  popup.layout.append(el);
  $('body').append(popup.el).addClass('haspopup');
  setTimeout(function(){
    popup.el.removeClass('opening');
  },1);
  
  popup.syncSize = function() {
    var 
      ph = popup.layout.outerHeight(),
      pw = popup.layout.outerWidth(),
      wh = $(window).height()
    
    if (wh > ph+100) {
      popup.layout.css({
        top : '50%',
        marginLeft : pw*-0.5,
        marginTop : ph*-0.5
      })
      popup.scroll.removeClass('active');
    } else {
      popup.layout.css({
        top : 50,
        marginLeft : pw*-0.5,
        marginTop : 0
      }) 
      popup.scroll.addClass('active');
    }
  }
  popup.syncSize();
  popup.el.find('img').load(function(){
    popup.syncSize();
  })
  popup.el.on('resize', function(){
    popup.syncSize();
  })
  $(window).bind('resize.popup', function(){
    popup.syncSize();
  })
  popup.close = function() {  
    popup.el.addClass('closing')
    setTimeout(function(){
      popup.el.css('opacity', 0);
      setTimeout(function(){  
        popup.el.remove();
        if(!$('.popup').length) $('body').removeClass('haspopup') 
      },1);
      $(window).unbind('.popup');
    }, 600);
    if (popup.onClose) popup.onClose();
  }
  
  close.click(function(){
    popup.close();
  })
  /*
  popup.scroll.click(function(e){
    var t = $(e.target);
    if (t.hasClass('playout') || t.parents('.playout').length) return;
    popup.close();
  });
  */
  return popup;
}

function showHotelInfo(hotelId){
    
    var popup = openPopup( $('#tpl-popup-hotel-info').html() ).el;
    
    popup.find('.hotel-manager-icons a').on('click', function(){
        var self = $(this);
        self.siblings().removeClass('active');
        self.addClass('active');
        switch (self.attr('data-act')) {
            case 'map':
                popup.find('.hotel-gallery').slideUp(240);
                popup.find('.hotel-map').slideDown(240);
                break;
            case 'gallery':
                popup.find('.hotel-map').slideUp(240);
                popup.find('.hotel-gallery').slideDown(240);
                break;
        }
        
        return false;
    });
}

function showBookingDialog(){
    var popup = openPopup( $('#tpl-popup-booking').html() ).el;
}

function showResults(count){
    var limit = 0;
    
    if (count && count > 0) limit = searchResultStart + count;
    if (limit > searchResult.length) limit = searchResult.length;
    
    if (limit < 1) {
        return false;
    }
    
    if (searchResultStart >= limit) {
        $('#search-result-load-button').hide();
        return false;
    }
    $('#search-result-load-button').show();
        
    for (var i = searchResultStart; i < limit; i++) {
        console.log(searchResult[i]);
        var rowItem = $.tmpl($('#tpl-search-result-item'), searchResult[i]);
        
        rowItem.on('click', function(){
            //$(this).toggleClass('select');
        });
        
        rowItem.find('.hover')
            .on('mouseover', function(e){
                $(this).find('.sr-popover').show();
            })
            .on('mouseout', function(e){
                $(this).find('.sr-popover').hide();
            });
        
        rowItem.appendTo('#searh-result .results tbody').fadeIn();
    }
    
    searchResultStart = i;
}

function getFilter(){
    return {
        foo: 'bar',
        hello: 'world!'
    };
}

function goSearch(){
    
    searchResult = [];
    searchResultStart = 0;
    $('#searh-result .results tbody').html('');
    
    $('#search-result-load-button').hide();
    $('.ajax-loader').fadeIn();
    
    $.ajax({
        url: 'http://service.appros/tez/search',
        dataType: 'jsonp',
        type: 'GET',
        data: getFilter(),
        success: function(data){
            $('.ajax-loader').fadeOut();
            if (data.success === true) {
                searchResult = data.result;
                
                showResults(20);
            }
        }
    });
}

$(document).ready(function(){
    $( ".datepicker" ).datepicker({
        dateFormat: 'dd.mm.yy',
        showOtherMonths: true,
        selectOtherMonths: true
    });
    
    goSearch();
});
</script>


<script id="tpl-popup-hotel-info" type="text/x-jquery-tmpl">
<div id="hotel-info-box">
  <div class="hotel-map"></div>
  <div class="hotel-manager-icons">
    <a href="#" data-act="map" class="active"><img src="/skins/base/img/icons/glyphicons_242_google_maps.png"></a>
    <a href="#" data-act="gallery"><img src="/skins/base/img/icons/glyphicons_138_picture.png"></a>
  </div>
  <div class="hotel-main-image"><img src="http://lorempixel.com/100/100/?=60"></div>
  <div class="hotel-title">BELLEVUE HOTEL 3 * <img class="hotel-rating" src="/skins/base/img/ratings/rat-3.png"></div>
  <div class="hotel-gallery">
    <img src="http://lorempixel.com/70/70/?=60">
    <img src="http://lorempixel.com/70/70/?=60">
    <img src="http://lorempixel.com/70/70/?=60">
    <img src="http://lorempixel.com/70/70/?=60">
    <img src="http://lorempixel.com/70/70/?=60">
    <img src="http://lorempixel.com/70/70/?=60">
    <img src="http://lorempixel.com/70/70/?=60">
    <img src="http://lorempixel.com/70/70/?=60">
    <img src="http://lorempixel.com/70/70/?=60">
    <img src="http://lorempixel.com/70/70/?=60">
    <img src="http://lorempixel.com/70/70/?=60">
    <img src="http://lorempixel.com/70/70/?=60">
    <img src="http://lorempixel.com/70/70/?=60">
    <img src="http://lorempixel.com/70/70/?=60">
    <img src="http://lorempixel.com/70/70/?=60">
    <img src="http://lorempixel.com/70/70/?=60">
    <img src="http://lorempixel.com/70/70/?=60">
    <img src="http://lorempixel.com/70/70/?=60">
    <img src="http://lorempixel.com/70/70/?=60">
    <img src="http://lorempixel.com/70/70/?=60">
    <img src="http://lorempixel.com/70/70/?=60">
    <img src="http://lorempixel.com/70/70/?=60">
    <img src="http://lorempixel.com/70/70/?=60">
    <img src="http://lorempixel.com/70/70/?=60">
    <img src="http://lorempixel.com/70/70/?=60">
    <img src="http://lorempixel.com/70/70/?=60">
    <img src="http://lorempixel.com/70/70/?=60">
    <img src="http://lorempixel.com/70/70/?=60">
    <img src="http://lorempixel.com/70/70/?=60">
    <img src="http://lorempixel.com/70/70/?=60">
  </div>
  <div class="hotel-description">
    <!--strong>Немного об отеле</strong-->
    <p>Отель представляет собой одно четырехэтажное здание, имеет небольшую территорию. Последний ремонт был произведен в 2007 году. КОНЦЕПЦИЯ "ЛЕТО 2013".<p>
  </div>
</div>
</script>

<script id="tpl-popup-booking" type="text/x-jquery-tmpl">
<div id="hotel-info-box">
  <div class="hotel-map"></div>
  <div class="hotel-manager-icons">
    <a href="#" data-act="map" class="active"><img src="/skins/base/img/icons/glyphicons_242_google_maps.png"></a>
    <a href="#" data-act="gallery"><img src="/skins/base/img/icons/glyphicons_138_picture.png"></a>
  </div>
  <div class="hotel-main-image"><img src="http://lorempixel.com/100/100/?=60"></div>
  <div class="hotel-title">BELLEVUE HOTEL 3 * <img class="hotel-rating" src="/skins/base/img/ratings/rat-3.png"></div>
  <div class="hotel-description">
    <!--strong>Немного об отеле</strong-->
    <p>Отель представляет собой одно четырехэтажное здание, имеет небольшую территорию. Последний ремонт был произведен в 2007 году. КОНЦЕПЦИЯ "ЛЕТО 2013".<p>
  </div>
</div>
</script>


<script id="tpl-search-result-item" type="text/x-jquery-tmpl">
<tr style="display:none">
  <td>${checkIn} (${checkInDayofWeek})</td>
  <td>${nightCount}</td>
  <td><strong><a href="#" onclick="showHotelInfo(${hotelId}); return false;">${hotel}</a></strong><br><span class="font-gray font-small">${hotelRoomType}</span></td>
  <td>${region}<br><span class="font-gray font-small">${tour}</span></td>
  <td>${pansionComment} (${pansion})</td>
  <td>${ageGroupType} (${hotelStayType})</td>
  <td class="price"><a href="" onclick="showBookingDialog(); return false;">${price}</a></td>
  <td class="hover">${existsRoom}
    <div class="sr-popover">
      <div class="sr-row sr-header">
        <div class="title">Билеты</div>
        <div>Туда</div>
        <div>Обратно</div>
      </div>
      <div class="sr-row">
        <div class="title">Эконом</div>
        <div>${freeSeatNumberToY}</div>
        <div>${freeSeatNumberFromY}</div>
      </div>
      <div class="sr-row">
        <div class="title">Премиум-Эконом</div>
        <div>${freeSeatNumberToR}</div>
        <div>${freeSeatNumberFromR}</div>
      </div>
      <div class="sr-row">
        <div class="title">Бизнес</div>
        <div>${freeSeatNumberToC}</div>
        <div>${freeSeatNumberFromC}</div>
      </div>
    </div>
  </td>
</tr>
</script>

@endsection