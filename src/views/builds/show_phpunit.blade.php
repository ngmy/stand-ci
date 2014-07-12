@extends('stand-ci::builds.show')

@section('show_content')
  <iframe src="{{ asset($build->artifact.'/phpunit.html') }}" id="iframe-phpunit">
  </iframe>
@stop
