<!DOCTYPE html>
<!--[if IE 9]> <html class="ie9 no-js" lang="en"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<html class="no-js" lang="en">
<!--<![endif]-->

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>@yield('title') | A&A Atores</title>
  <link rel="stylesheet" href="{{url('polished/css/polished.min.css')}}">
  <link rel="stylesheet" href="{{url('polished/css/open-iconic-bootstrap.min.css')}}">
  <link rel="stylesheet" href="{{url('polished/css/report.css')}}">

  <link rel="icon" href="{{url('polished/assets/fav.png')}}">

  <style>
      @media print {
    button {
      display: none;
    }
  }
    }
  </style>

</head>

<body>


  <div id="invoice">
    <div class="invoice overflow-auto">
        <div style="min-width: 600px">
            <header>
                <div class="row">
                    <div class="col">
                        <a target="_blank" href="https://lobianijs.com">
                            <img src="{{url('polished/assets/ngapak.png')}}" data-holder-rendered="true" />
                            </a>
                            <button onclick="printPage()">Cetak</button>
                    </div>
                    <div class="col company-details">
                        <h1 class="invoice-id">A&A Store Online</h1>
                        <div>A&A Store Online 2024 &copy; Allright Reserved.</div>
                    </div>
                </div>
            </header>
            <main>
                @yield('content')
            </main>
            <footer>
                Invoice was created on a computer and is valid without the signature and seal.

            </footer>
        </div>
      </div>
        <!--DO NOT DELETE THIS div. IT is responsible for showing footer always at the bottom-->
        <div>
          
        </div>
        
      </div>

  @stack('modal')
</body>
@stack('js')
<script>
  function printPage() {
    window.print();
  }
</script>
</html>