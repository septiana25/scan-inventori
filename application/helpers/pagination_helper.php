<?php
defined('BASEPATH') or exit('No direct script access allowed');

if (!function_exists('get_pagination_template')) {
    function get_pagination_template()
    {
        return [
            'full_tag_open' => '<nav aria-label="Page navigation"><ul class="pagination justify-content-center">',
            'full_tag_close' => '</ul></nav>',
            'first_link' => 'Pertama',
            'last_link' => 'Terakhir',
            'next_link' => '&raquo;',
            'prev_link' => '&laquo;',
            'num_tag_open' => '<li class="page-item">',
            'num_tag_close' => '</li>',
            'cur_tag_open' => '<li class="page-item active" aria-current="page"><a class="page-link" href="#">',
            'cur_tag_close' => '</a></li>',
            'first_tag_open' => '<li class="page-item">',
            'first_tag_close' => '</li>',
            'last_tag_open' => '<li class="page-item">',
            'last_tag_close' => '</li>',
            'next_tag_open' => '<li class="page-item">',
            'next_tag_close' => '</li>',
            'prev_tag_open' => '<li class="page-item">',
            'prev_tag_close' => '</li>',
        ];
    }
}
