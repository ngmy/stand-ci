@extends('stand-ci::builds.show')

@section('show_content')
  <iframe src="{!! asset($build->artifact.'/coverage/index.html') !!}" id="iframe-coverage">
  </iframe>
@stop
