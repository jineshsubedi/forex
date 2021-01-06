<!DOCTYPE html>
<html>
<head>
  <title>Nepalese Currency Exchange - Forex</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
  <link rel="icon" href="{{asset('images/flag.png')}}" type="image/gif" sizes="16x16">
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <meta name="title" content="Nepali Currency Converter">
  <meta name="description" content="This site converts foreign currency to Nepalese currency and vice versa, also can be used to convert in any currency based on NRB standard rates.">
  <meta name="keywords" content="Foreign Currency Converter, converter, Nepalese Converter, Site Converter, NRB forex, forex, Currency, Currency converter, useful links, Nepali site, jinesh subedi, jinesh, subedi, jineshsubedi.com.np, forex.jineshsubedi.com.np, currency charts, monthly currency charts">
  <meta name="robots" content="index, follow">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="language" content="English">
  <meta name="revisit-after" content="1 days">
  <meta name="author" content="Jinesh subedi">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<style type="text/css">
  body{
    padding-top: 20px;
    background-color: #1a5ca6;
    color: #fff;
  }
  .convertSection{
    padding-top: 50px;
    border: 1px solid #fff;
    height: 400px;
  }
  .converter{
    background-color: #fff;
    width: 100%;
    height: 100px;
    padding: 15px;
    margin: 0 auto;
    margin-top: 30px;
  }
  table{
    background-color: aliceblue;
  }
  .chart{
    background-color: #fff;
  }
  .result{
    font-size: 20px;
  }
  .widget{
    border: 1px solid white;
    padding: 5px;
    margin-bottom: 10px;
  }
  p a{
    color: #fff;
  }
  h4 a{
    color: #fff;
  }
  h4 a:hover{
    color: #fff;
  }
  p a:hover{
    color: #ff1;
  }
  p a i{
    font-size: 20px;
  }
  .top-text{
      margin-top: 10px;
    }
  @media only screen and (max-width: 600px) {
    .converter{
      height: auto;
    }
    .convertSection{
      height: auto;
    }

  }
</style>
<body>
  <div id="fb-root"></div>
  <script defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v9.0&appId=2266965833629953&autoLogAppEvents=1" nonce="CLc5uShd"></script>
  <script type="text/javascript"> (function() { var css = document.createElement('link'); css.href = 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.4.1/css/all.min.css'; css.rel = 'stylesheet'; css.type = 'text/css'; document.getElementsByTagName('head')[0].appendChild(css); })(); </script>

  <div class="container">
    <div class="row">
      <div class="col-md-8">
          <h2>Currency Converter <img src="{{asset('images/flag.webp')}}" width="15px"></h2>
      </div>
      <div class="col-md-4 text-right form-group">
        <div class="row">
          <div clss="col-md-5 top-text">
            <p>showing exchange rate of </p>
          </div>
          <div class="col-md-7">
            <input type="text" class="form-control" name="filter_date" id="filter_date" value="{{$datas['date']}}" style="border: none;background-color: transparent;color: #fff;border-bottom: 1px solid #fff;">
          </div>
        </div>
      </div>
      <div class="col-md-12">
        <div class="container convertSection">
          <h2 class="text-center">Welcome to Real Time Currency Converter</h2>
          <p class="text-center">These are the standard rates by Nepal Rastra Bank <br> {{\Carbon\Carbon::parse($datas['date'])->format('d F, Y')}}</p>
          <form>
          <div class="row text-center form-group converter">
            @csrf
            <input type="hidden" name="exchange_date" value="{{$datas['date']}}" id="exchange_date">
            <div class="col-md-3 input-group-lg">
              <label class="label text-info">Input Currency</label>
              <input type="number" class="form-control" name="raw_money" id="raw_money" value="1" min="1" max="100000000">
            </div>
            <div class="col-md-3 input-group-lg">
              <label class="label text-info">From</label>
              <select class="form-control" name="from_currency" id="from_currency">
                @foreach($datas['currency'] as $currency)
                  @if($currency == 'USD')
                  <option value="{{$currency}}" selected>{{$currency}}</option>
                  @else
                  <option value="{{$currency}}">{{$currency}}</option>
                  @endif
                @endforeach
              </select>
            </div>
            <div class="col-md-3 input-group-lg">
              <label class="label text-info">To</label>
              <select class="form-control" name="to_currency" id="to_currency">
                @foreach($datas['currency'] as $currency)
                  @if($currency == 'NPR')
                  <option value="{{$currency}}" selected>{{$currency}}</option>
                  @else
                  <option value="{{$currency}}">{{$currency}}</option>
                  @endif
                @endforeach
              </select>
            </div>
            <div class="col-md-3 input-group-lg">
              <button type="button" class="btn btn-lg btn-danger" style="margin-top: 25px;" onclick="convert()">Convert</button>
            </div>
            <div></div>
          </div>
          </form>
          <div class="text-center">
              <div class="result" id="resultContainer">
                <p>Buying <span class="badge badge-warning">{{$datas['result']->buy}}</span>
                 - Selling <span class="badge badge-danger">{{$datas['result']->sell}}</span></p>
              </div>
          </div>
        </div>
      </div>
      <div class="col-md-8">
        <h2>Monthly Exchange Rates</h2><br>
        <div></div>
        <div class="chart" id="line-chart" style="width:100%;height: 250px;"></div>
        <br>
        <div class="">
          <h2>Nepal Currency Exchange Rate of <br>{{\Carbon\Carbon::parse($datas['date'])->format('d F, Y')}} </h2>
          <table class="table table-bordered table-striped table-hover" id="currencyExchangeRate">
            <tr>
              <thead>
              <th>Currency</th>
              <th>Unit</th>
              <th>Buying Rate</th>
              <th>Selling Rate</th>
              </thead>
            </tr>
            <tbody>
            @foreach($datas['forex'] as $forex)
            <tr>
              <td>{{$forex->name}} ({{$forex->iso3}})</td>
              <td>{{$forex->unit}}</td>
              <td>{{$forex->buy}}</td>
              <td>{{$forex->sell}}</td>
            </tr>
            @endforeach
            </tbody>
          </table>
        </div>
      </div>
      <div class="col-md-4">
        <h2>Widgets</h2>
        <br>
        <div class="widget">
          <h2>Useful Links</h2>
          <ul class="list-group list-group-flush">
            <li class="list-group-item"><a href="https://www.nrb.org.np/forex/" target="_blank">NRB exchange rates</a></li>
            <li class="list-group-item"><a href="https://www.hamropatro.com/" target="_blank">Hamro Patro</a></li>
            <li class="list-group-item"><a href="https://rollingnexus.com/" target="_blank">Rolling Nexus</a></li>
          </ul>
        </div>
        <div class="widget">
          <h2>Author</h2>
          <div class="row">
            <div class="well profile col-md-12 col-lg-12 col-xs-12 text-center">
              <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                <figure>
                     <img data-src="{{asset('images/jinesh.webp')}}" alt="" class="lazyload" style="width:80%;" id="user-img">
                </figure>
                <h4 style="text-align:center;"><strong id="user-name"><a href="http://jineshsubedi.com.np/">Jinesh Subedi</a></strong></h4>
                <p style="text-align: center; overflow-wrap: break-word; text-decoration: none;"><a href="maito:jinesh1094@gmail.com">jinesh1094@gmail.com</a></p>
                <p style="text-align: center;" id="user-role">Web Developer</p>
                <p>
                  <a href="https://www.facebook.com/jinesh1094" target="_blank"><i class="fab fa-facebook-square"></i></a>
                  <a href="https://twitter.com/JineshSubedi" target="_blank"><i class="fab fa-twitter-square"></i></a>
                  <a href="https://www.linkedin.com/in/jinesh-subedi-541550154/" target="_blank"><i class="fab fa-linkedin"></i></a>
                  <a href="https://www.instagram.com/jinesh.officials/" target="_blank"><i class="fab fa-instagram"></i></a>
                </p>
              </div>
            </div>
          </div>
        </div>
        <div class="widget">
          <div class="fb-page" data-href="https://www.facebook.com/jineshcast/" data-tabs="" data-width="" data-height="" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="https://www.facebook.com/jineshcast/" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/jineshcast/">Jineshsubedi.com.np</a></blockquote></div>
        </div>
      </div>
    </div>
  </div>
<script  src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script defer src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script defer src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<script defer src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script defer src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/lazysizes/5.2.2/lazysizes.min.js"></script>
<script>
  $( function() {
    $( "#filter_date" ).datepicker({
      dateFormat: "yy-mm-dd",
      showAnim: "fold",
      maxDate: "{{Date('Y-m-d')}}"
    });
  } );

  $('#filter_date').change(function(){
    var date = $(this).val()
    var url = '{{url("/")}}';

    if(date != ''){
      url += '?filter_date='+date
    }
    location = url;
  })
</script>
<script type="text/javascript">
  $(function(){
      @if(count($datas['rates_chart']) > 0)
        var line = new Morris.Line({
            element: 'line-chart',
            resize: true,

           data: [
            @foreach($datas["rates_chart"] as $dy)

              {
                y: '{{$dy["exchange_date"]}}', 
                item1: '{{$dy["item1"]}}',
                item2: '{{$dy["item2"]}}',
                item3: '{{$dy["item3"]}}',
                item4: '{{$dy["item4"]}}',
                item5: '{{$dy["item5"]}}',
                item6: '{{$dy["item6"]}}',
                item7: '{{$dy["item7"]}}',
                item8: '{{$dy["item8"]}}',
                item9: '{{$dy["item9"]}}',
                item10: '{{$dy["item10"]}}',
                item11: '{{$dy["item11"]}}',
                item12: '{{$dy["item12"]}}',
                item13: '{{$dy["item13"]}}',
                item14: '{{$dy["item14"]}}',
                item15: '{{$dy["item15"]}}',
                item16: '{{$dy["item16"]}}',
                item17: '{{$dy["item17"]}}',
                item18: '{{$dy["item18"]}}',
                item19: '{{$dy["item19"]}}',
                item20: '{{$dy["item20"]}}',
                item21: '{{$dy["item21"]}}'
              },

              @endforeach
           ],
          xkey: 'y',
            ykeys: ['item1', 'item2', 'item3', 'item4', 'item5', 'item6', 'item7', 'item8', 'item9', 'item10', 'item11', 'item12', 'item13', 'item14', 'item15', 'item16', 'item17', 'item18', 'item19', 'item20', 'item21'],
            xLabels: 'y',
            labels: ["INR","USD","EUR","GBP","CHF","AUD","CAD","SGD","JPY","CNY","SAR","QAR","THB","AED","MYR","KRW","SEK","DKK","HKD","KWD","BHD"],
            lineColors: ['#a20631','#1122ea','#f19c16','#6e6b7c','#a24a54','#2574a1','#27fa94','#607862','#057928','#2ffb2f','#cd39d7','#dfab07','#9e637b','#e6ae7a','#9ec88e','#f85489','#ae04fb','#a1eb7e','#945c03','#3bc946','#d5be05'],
            axes: true,
            grid: true,
            hideHover: 'auto'
        });
      @endif
  });
</script>
<script>
  var token = $('input[name=\'_token\']').val();
  $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
  function convert()
  {
    var currency = $('#raw_money').val();
    var from_currency = $('#from_currency').val();
    var to_currency = $('#to_currency').val();
    var exchange_date = $('#exchange_date').val();
    $.ajax({
       type:'POST',
       url:"{{ url('/convert_currency') }}",
       cache: false,
       dataType: 'json',
       data:{currency:currency, from_currency:from_currency, to_currency:to_currency, exchange_date: exchange_date},
       success:function(data){
          console.log(data);
          var resultHtml = '<p>Buying <span class="badge badge-warning">'+data.buy+'</span> - Selling <span class="badge badge-danger">'+data.sell+'</span></p>'
          $('#resultContainer').html(resultHtml);
       },
       error: function(error){
        console.log(error);
       }
    });
  }
</script>
</body>
</html>