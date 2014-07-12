@extends('stand-ci::builds.show')

@section('show_content')
  <iframe src="{{ asset($build->artifact.'/phpmd.html') }}" id="iframe-phpmd">
  </iframe>
@stop
