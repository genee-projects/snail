<ul class="timeline">
    {{--*/ $class = 'timeline-inverted'; /*--}}
    @foreach($project->logs()->orderBy('time', 'desc')->get() as $log)
        {{--*/
        if ($class == 'timeline-inverted') $class = null;
        else $class = 'timeline-inverted';
        /*--}}
        <li class="{{ $class }}">
            <div class="timeline-badge {{ \App\Clog::$level_class[$log->level] }}"><i class="fa fa-flag"></i>
            </div>
            <div class="timeline-panel">
                <div class="timeline-heading">
                    <h4 class="timeline-title">{{ $log->action }}</h4>
                    <p><small class="text-muted"><i class="fa fa-clock-o"></i> {{ $log->time->format('Y/m/d') }} via <strong>{{ $log->user->name }}</strong></small></p>
                </div>
                <div class="timeline-body">
                    @if (count($log->change))
                        @foreach($log->change as $c)
                            @if (isset($c['title']))
                                <p> {{ $c['title'] or ''}}:
                                    @if (isset($c['old']))
                                    <mark>「{{ $c['old'] }}」</mark>-&gt;<mark>「{{ $c['new'] }}」</mark>
                                    @endif
                                </p>
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