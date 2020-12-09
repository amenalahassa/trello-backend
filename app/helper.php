<?php

function getObjectFromArray($n, $m)
{
    $element['key'] = $n;
    $element['label'] = $m;
    return $element;
}

function CastDate($date)
{
    $current = explode(".", $date)[0];
    $current = explode(" ", $current);
    $day = $current[0];
    $time = $current[1];
    return formatDateFrench($day) . " à " . $time;
}

function formatDateFrench ($date, $comma = ",")
{
    return ucfirst(\Carbon\Carbon::parse($date)->formatLocalized('%A %d' . $comma . ' %B %Y'));
}

