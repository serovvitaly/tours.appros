@extends('layout')

@section('content') 

<div class="row">
  <div class="span12">поиск</div>
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

<div id="modal-hotel-info" class="modal hide" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3>Информация об отеле</h3>
  </div>
  <div class="modal-body">
    <p>One fine body…</p>
  </div>
  <div class="modal-footer">
    <a href="#" class="btn">Close</a>
    <a href="#" class="btn btn-primary">Save changes</a>
  </div>
</div>

<div id="modal-booking" class="modal hide" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3>Бронирование</h3>
  </div>
  <div class="modal-body">
    <p>One fine body…</p>
  </div>
  <div class="modal-footer">
    <a href="#" class="btn">Close</a>
    <a href="#" class="btn btn-primary">Save changes</a>
  </div>
</div>


<script>

var searchResult = [];
var searchResultStart = 0;

function showHotelInfo(hotelId){
    $('#modal-hotel-info').modal('show');
}

function showBookingDialog(){
    $('#modal-booking').modal('show');
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
        dateFormat: 'dd.mm.yy'
    });
    
    //goSearch();
});
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