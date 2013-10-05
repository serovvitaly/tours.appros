<div class="tabbable tabs-right">
  <ul class="nav nav-tabs">
    <li class="active"><a href="#lA" data-toggle="tab"><i class="icon-star"></i></a></li>
    <li class=""><a href="#lB" data-toggle="tab"><i class="icon-eye-open"></i></a></li>
  </ul>
  <div class="tab-content">
    <div class="tab-pane active" id="lA">
      
<!-- -->
      <div>
        Откуда:<br/>
        <input type="text" style="width: 166px">
        Куда:<br/>
        <input type="text" style="width: 166px">
      </div>
      <div>
        Диапазон дат заезда:<br/>
        <input name="after" type="text" class="datepicker" style="width: 74px;" value="<?= date('d.m.Y', time() + 3600*24*3) ?>">
        <input name="before" type="text" class="datepicker" style="width: 75px;" value="<?= date('d.m.Y', time() + 3600*24*10) ?>">
        
        Количество ночей:<br/>
        <input name="nightsMin" type="text" style="width: 74px;" value="6">
        <input name="nightsMax" type="text" style="width: 75px;" value="14">
      </div>  
      <div>
        Валюта:<br/>
        <select name="currency" style="width: 180px">
          <option value="5561">Доллар США</option>
          <option value="8390" selected="selected">Рубль</option>
          <option value="18864">Евро</option>
          <option value="46688">Гривна</option>
          <option value="50159">LAT</option>
          <option value="53570">Литовский лит</option>
          <option value="132329">Белорусский рубль</option>
        </select>
        
        Диапазон цен:<br/>
        <input name="priceMin" type="text" style="width: 74px;" value="0">
        <input name="priceMax" type="text" style="width: 75px;" value="999999">
      </div>
<!-- -->
      
    </div>
    <div class="tab-pane" id="lB">
      <p>Howdy, I'm in Section B.</p>
    </div>

  </div>
</div>