<html>
  <head>
    {!! Illuminate\Html\HtmlFacade::style('//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css') !!}
    {!! Illuminate\Html\HtmlFacade::style('/packages/ngmy/stand-ci/css/main.css') !!}
  </head>
  <body>
    <nav class="navbar navbar-default" role="navigation">
      <div class="container-fluid">
        <div class="navbar-header">
          {!! link_to(config('ngmy-stand-ci')['route_prefix'].'/builds', 'Stand CI', array('class' => 'navbar-brand')) !!}
        </div>
      </div><!-- /.container-fluid -->
    </nav>

    @yield('content')

    <footer class="footer">
      <div class="container text-center">
        <p class="text-muted credit">Stand CI is Copyright &copy; 2015 by <a href="https://twitter.com/ngmy">@ngmy</a> hosted on <a href="https://github.com/ngmy/stand-ci">GitHub</a>.</p>
      </div>
    </footer>

    {!! Illuminate\Html\HtmlFacade::script('//code.jquery.com/jquery-1.11.0.min.js') !!}
    {!! Illuminate\Html\HtmlFacade::script('/packages/ngmy/stand-ci/js/jquery.pjax.js') !!}
    {!! Illuminate\Html\HtmlFacade::script('/packages/ngmy/stand-ci/js/jquery.query-object.js') !!}
    {!! Illuminate\Html\HtmlFacade::script('/packages/ngmy/stand-ci/js/stand-ci.common.js') !!}
    @yield('scripts')
  </body>
</html>
