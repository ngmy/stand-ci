<html>
  <head>
    {{ Illuminate\Support\Facades\HTML::style('//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css') }}
    {{ Illuminate\Support\Facades\HTML::style('/packages/ngmy/stand-ci/css/main.css') }}
  </head>
  <body>
    <nav class="navbar navbar-default" role="navigation">
      <div class="container-fluid">
        <div class="navbar-header">
          {{ link_to(Illuminate\Support\Facades\Config::get('stand-ci::route_prefix').'/builds', 'Stand CI', array('class' => 'navbar-brand')) }}
        </div>
      </div><!-- /.container-fluid -->
    </nav>

    @yield('content')

    <footer class="footer">
      <div class="container text-center">
        <p class="text-muted credit">Stand CI is Copyright &copy; 2015 by <a href="https://twitter.com/ngmy">@ngmy</a> hosted on <a href="https://github.com/ngmy/stand-ci">GitHub</a>.</p>
      </div>
    </footer>

    {{ Illuminate\Support\Facades\HTML::script('//code.jquery.com/jquery-1.11.0.min.js') }}
    {{ Illuminate\Support\Facades\HTML::script('/packages/ngmy/stand-ci/js/jquery.pjax.js') }}
    {{ Illuminate\Support\Facades\HTML::script('/packages/ngmy/stand-ci/js/stand-ci.common.js') }}
    @yield('scripts')
  </body>
</html>
