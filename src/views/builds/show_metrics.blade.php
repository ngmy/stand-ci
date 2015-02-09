@extends('stand-ci::builds.show')

@section('show_content')
  <iframe src="{!! asset($build->artifact.'/metrics.html') !!}" id="iframe-metrics">
  </iframe>
@stop
