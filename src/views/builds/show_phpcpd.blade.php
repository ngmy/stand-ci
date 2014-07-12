@extends('stand-ci::builds.show')

@section('show_content')
  <iframe src="{{ asset($build->artifact.'/phpcpd.html') }}" id="iframe-phpcpd">
  </iframe>
@stop
