@isset( $day )

<div class="month">
        <a class="btn btn-original" href=
        @if($month - 1 < 1 )
            {{ "/" . $page . "/" . ($year - 1) .'-12-' . $day }}
        @else
            {{ "/" . $page . "/". $year . "-" . ( $month -1 ) ."-" . $day}}
        @endif 
        >前月へ</a>
        <a class="btn btn-original" href=
        @if($month + 1 > 12 )
            {{ "/" . $page . "/" . ($year + 1) .'-1-'. $day }}
        @else
            {{ "/" . $page . "/".$year . "-" . ( $month +1 ) ."-" . $day}}
        @endif 
        ">次月へ</a>
</div>
@endisset
@empty($day)
<div class="month">
        <a class="btn btn-original" href=
        @if($month - 1 < 1 )
            {{ "/" . $page . "/" . ($year - 1) .'-12' }}
        @else
            {{ "/" . $page . "/". $year . "-" . ( $month -1 ) }}
        @endif 
        >前月へ</a>
        <a class="btn btn-original" href=
        @if($month + 1 > 12 )
            {{ "/" . $page . "/" . ($year + 1) .'-1' }}
        @else
            {{ "/" . $page . "/".$year . "-" . ( $month +1 ) }}
        @endif 
        ">次月へ</a>
</div>
@endempty
