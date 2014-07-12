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
          <td class="success">{{ link_to(Illuminate\Support\Facades\Config::get('stand-ci::route_prefix').'/builds/'.$build->id, $build->id) }}</td>
          <td class="success">Success</td>
          <td class="success">{{ $build->finished_at->diffTimeForHumans($build->started_at) }}</td>
          <td class="success">{{ $build->finished_at->diffForHumans() }}</td>
        @elseif ($build->status === Ngmy\StandCi\Repo\Build\BuildInterface::FAILURE)
          <td class="danger">{{ link_to(Illuminate\Support\Facades\Config::get('stand-ci::route_prefix').'/builds/'.$build->id, $build->id) }}</td>
          <td class="danger">Failure</td>
          <td class="danger">{{ $build->finished_at->diffTimeForHumans($build->started_at) }}</td>
          <td class="danger">{{ $build->finished_at->diffForHumans() }}</td>
        @else
          <td>{{ $build->id }}</td>
          <td>Building</td>
          <td>{{ Ngmy\StandCi\Library\StandCiCarbon::now()->diffTimeForHumans($build->started_at) }}</td>
          <td>{{ $build->finished_at }}</td>
        @endif
      </tr>
    @endforeach
  </tbody>
</table>
