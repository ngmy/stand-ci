@extends('stand-ci::builds.show')

@section('show_content')
  <iframe src="{{ asset($build->artifact.'/phpcb/index.html') }}" id="iframe-phpcb">
  </iframe>
@stop
