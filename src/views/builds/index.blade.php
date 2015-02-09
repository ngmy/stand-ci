@extends('stand-ci::layouts.master')

@section('content')
  <div class="container">
    <div id="pjax-container">
      @if ($isLock)
        <button id="build-btn" type="button" class="btn btn-primary btn-lg" disabled>Now Building</button>
      @else
        <button id="build-btn" type="button" class="btn btn-primary btn-lg">Build</button>
      @endif

      <h3>Build History</h3>

      <table class="table table-striped">
        <thead>
          <tr>
            <th><div align="center">Build</div></th>
            <th><div align="center">Status</div></th>
            <th><div align="center">Duration</div></th>
            <th><div align="center">Finished</div></th>
          </tr>
        </thead>
        <tbody>
          @foreach ($builds as $build)
            <tr>
              @if ($build->status === Ngmy\StandCi\Repo\Build\BuildInterface::SUCCESS)
                <td class="success">{!! link_to(config('ngmy-stand-ci')['route_prefix'].'/builds/'.$build->id, $build->id) !!}</td>
                <td class="success">Success</td>
                <td class="success">{!! $build->finished_at->diffTimeForHumans($build->started_at) !!}</td>
                <td class="success">{!! $build->finished_at->diffForHumans() !!}</td>
              @elseif ($build->status === Ngmy\StandCi\Repo\Build\BuildInterface::FAILURE)
                <td class="danger">{!! link_to(config('ngmy-stand-ci')['route_prefix'].'/builds/'.$build->id, $build->id) !!}</td>
                <td class="danger">Failure</td>
                <td class="danger">{!! $build->finished_at->diffTimeForHumans($build->started_at) !!}</td>
                <td class="danger">{!! $build->finished_at->diffForHumans() !!}</td>
              @else
                <td>{!! $build->id !!}</td>
                <td>Building</td>
                <td>{!! Ngmy\StandCi\Library\StandCiCarbon::now()->diffTimeForHumans($build->started_at) !!}</td>
                <td>{!! $build->finished_at !!}</td>
              @endif
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    <div class="pagination-centered">
      {!! $builds->render() !!}
    </div>
  </div>
@stop

@section('scripts')
  <script>
    $(function () {
      $(document).on('click', '#build-btn', function () {
        $.ajax({
          type: 'POST',
          url: 'builds',
          data: {
            _token: '{!! csrf_token() !!}'
          }
        });
        $('#build-btn').prop('disabled', true);
        $('#build-btn').html('Now Building');
      });
    });

    $.pjax.defaults.scrollTo = false;
    setInterval(function () {
      var url = 'builds';
      var page = $.query.get('page');
      if (page !== '') {
         url += $.query.set('page', page);
      }
      $.pjax({
        timeout: 10000,
        push: false,
        maxCacheLength: 0,
        url: url,
        container: '#pjax-container'
      });
    }, 5000);
  </script>
@stop
