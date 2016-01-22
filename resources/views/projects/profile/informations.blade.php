<ul class="timeline">
    {{--*/ $class = 'timeline-inverted'; /*--}}
    @foreach($project->logs()->orderBy('time', 'desc')->get() as $log)
        {{--*/
        if ($class == 'timeline-inverted') $class = null;
        else $class = 'timeline-inverted';
        /*--}}
        <li class="{{ $class }}">
            <div class="timeline-badge {{ array_rand(array_flip(['info', 'success', 'warning', 'danger']), 1) }}"><i class="fa fa-flag"></i>
            </div>
            <div class="timeline-panel">
                <div class="timeline-heading">
                    <h4 class="timeline-title">{{ $log->action }}</h4>
                    <p><small class="text-muted"><i class="fa fa-clock-o"></i> {{ (new DateTime($log->time))->format('Y/m/d') }} via {{ $log->user->name }}</small></p>
                </div>
                <div class="timeline-body">
                    @if (count($log->change))
                        @foreach($log->change as $c)
                            @if (isset($c['title']))
                                <p> {{ $c['title'] or ''}}: <mark>「{{ $c['old'] }}」</mark>-&gt;<mark>「{{ $c['new'] }}」</mark></p>
                            @else
                                <p>{{ $c }}</p>
                            @endif
                        @endforeach
                    @endif
                </div>
            </div>
        </li>
    @endforeach
</ul>

<script type="text/javascript">
    require(['css!../css/timeline'], function() {});
</script>