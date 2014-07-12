@extends('stand-ci::builds.show')

@section('show_content')
  <div class="container">
    @if ($build->status === Ngmy\StandCi\Repo\Build\BuildInterface::SUCCESS)
      <h3>Build Succeeded</h3>
    @else
      <h3>Build Failed</h3>
    @endif
    <div>
      Duration: {{ $build->finished_at->diffTimeForHumans($build->started_at) }}
    </div>
    <div>
      Finished: {{ $build->finished_at->diffForHumans() }}
    </div>
  </div>

  <iframe src="{{ asset($build->artifact.'/phpunit_overview.html') }}" id="iframe-phpunit-overview">
  </iframe>

  <iframe src="{{ asset($build->artifact.'/phpcs_overview.html') }}" id="iframe-phpcs-overview">
  </iframe>

  <iframe src="{{ asset($build->artifact.'/phpmd_overview.html') }}" id="iframe-phpmd-overview">
  </iframe>
@stop
