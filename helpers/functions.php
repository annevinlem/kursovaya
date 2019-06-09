<?php


function queryToArray($query)
{
    $result = [];

    while ($row = $query->fetch_assoc())
    {
        $result[] = $row;
    }

    return $result;
}

function queueToHtml($queue_array, $block_action)
{
    $returned_html = '';

    foreach ($queue_array as $item)
    {
        $returned_html .= '<div class="col-md-12">';
        $returned_html .= '<div class="item clearfix" data-id="'. $item['queue_id'] .'">';
        $returned_html .= '<span class="talon-number">Талон №'. $item['num'] .'</span>';
        $returned_html .= '<span class="status">'. $item['status'] .'</span>';
        $returned_html .= '<div class="action clearfix '. ($block_action && $item['status_id'] == 1 ? 'block' : '') .'">';

        if ($item['status_id'] == 1)
        {
            $returned_html .= '<span class="invite">Пригласить</span>';
        }
        elseif ($item['status_id'] == 2)
        {
            $returned_html .= '<span class="come">Пришёл</span><span class="not_come">Не пришёл</span>';
        }
        elseif ($item['status_id'] == 3)
        {
            $returned_html .= '<span class="end">Закончить прием</span>';
        }

        $returned_html .= '</div>';
        $returned_html .= '</div>';
        $returned_html .= '</div>';
    }

    return $returned_html;
}