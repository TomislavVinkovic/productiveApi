<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <title>Document</title>
</head>
<body>
    
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
          <a class="navbar-brand" href="{{ route('productive') }}">
            <img src="{{ asset('images/productive.png') }}" alt="" width="30" height="24" class="d-inline-block align-text-top">
            Productive API
          </a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
              <li class="nav-item">
                <a class="nav-link {{ Request::path() === 'projects' ? 'active': '' }}" href="{{ route('productive.projects') }}">Projects</a>
              </li>
            </ul>
          </div>
        </div>
      </nav>

    <div class="container-fluid">
        @yield('content', 'No content')
    </div>
    
    <script src="{{ asset('js/app.js') }}" defer></script>
</body>
</html>