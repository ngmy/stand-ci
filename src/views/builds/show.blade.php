@extends('stand-ci::layouts.master')

@section('content')
  <div class="container">
    <ul class="nav nav-pills">
      <li @if (Illuminate\Support\Facades\Input::get('tab') === 'overview' || is_null(Illuminate\Support\Facades\Input::get('tab'))) class="active" @endif>{!! link_to(config('ngmy-stand-ci')['route_prefix'].'/builds/'.$build->id.'?tab=overview', 'Overview') !!}</li>
      <li @if (Illuminate\Support\Facades\Input::get('tab') === 'phpunit') class="active" @endif>{!! link_to(config('ngmy-stand-ci')['route_prefix'].'/builds/'.$build->id.'?tab=phpunit', 'Tests') !!}</li>
      <li @if (Illuminate\Support\Facades\Input::get('tab') === 'coverage') class="active" @endif>{!! link_to(config('ngmy-stand-ci')['route_prefix'].'/builds/'.$build->id.'?tab=coverage', 'Coverage') !!}</li>
      <li @if (Illuminate\Support\Facades\Input::get('tab') === 'metrics') class="active" @endif>{!! link_to(config('ngmy-stand-ci')['route_prefix'].'/builds/'.$build->id.'?tab=metrics', 'Metrics') !!}</li>
      <li @if (Illuminate\Support\Facades\Input::get('tab') === 'phpcb') class="active" @endif>{!! link_to(config('ngmy-stand-ci')['route_prefix'].'/builds/'.$build->id.'?tab=phpcb', 'Code') !!}</li>
      <li @if (Illuminate\Support\Facades\Input::get('tab') === 'phpdoc') class="active" @endif>{!! link_to(config('ngmy-stand-ci')['route_prefix'].'/builds/'.$build->id.'?tab=phpdoc', 'Documentation') !!}</li>
      <li @if (Illuminate\Support\Facades\Input::get('tab') === 'phpcs') class="active" @endif>{!! link_to(config('ngmy-stand-ci')['route_prefix'].'/builds/'.$build->id.'?tab=phpcs', 'PHPCS') !!}</li>
      <li @if (Illuminate\Support\Facades\Input::get('tab') === 'phpmd') class="active" @endif>{!! link_to(config('ngmy-stand-ci')['route_prefix'].'/builds/'.$build->id.'?tab=phpmd', 'PHPMD') !!}</li>
      <li @if (Illuminate\Support\Facades\Input::get('tab') === 'phpcpd') class="active" @endif>{!! link_to(config('ngmy-stand-ci')['route_prefix'].'/builds/'.$build->id.'?tab=phpcpd', 'PHPCPD') !!}</li>
    </ul>
  </div>

  <div>
    @yield('show_content')
  </div>
@stop
