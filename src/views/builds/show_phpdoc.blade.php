@extends('stand-ci::builds.show')

@section('show_content')
  <iframe src="{{ asset($build->artifact.'/phpdoc/index.html') }}" id="iframe-phpdoc">
  </iframe>
@stop
