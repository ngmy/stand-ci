@extends('stand-ci::builds.show')

@section('show_content')
  <iframe src="{!! asset($build->artifact.'/phpcs.html') !!}" id="iframe-phpcs">
  </iframe>
@stop
