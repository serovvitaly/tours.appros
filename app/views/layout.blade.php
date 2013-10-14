<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>{{ isset($title) ? $title : 'Поиск туров' }}</title>
  
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
  <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>

  <link rel="stylesheet" type="text/css" href="/packages/jquery/Buttons/css/buttons.css">
  <script src="/packages/jquery/Buttons/js/buttons.js"></script>
  
  <link rel="stylesheet" type="text/css" href="/packages/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="/skins/base/css/style.css">
  <link rel="stylesheet" type="text/css" href="/skins/base/css/ui/datepicker.css">
</head>
<body>
  <div class="container">
  
    <div class="row" id="top-main-menu">
      <ul>
        <li class="active"><a href="#" onclick="return false;"><i class="icon-user"></i> Поиск предложений</a></li>
        <li><a href="#" onclick="return false;"><i class="icon-user"></i> Интересная карта</a></li>
        <li><a href="#" onclick="return false;"><i class="icon-user"></i> Общая информация</a></li>
      </ul>
    </div>
  
    @yield('content')
  </div>
  
  <script src="/packages/jquery/jquery-tmpl/jquery.tmpl.min.js"></script>
  <script src="/packages/bootstrap/js/bootstrap.min.js"></script>
  
</body>
</html>