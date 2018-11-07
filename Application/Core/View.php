<?php

namespace Core;

class View 
{
    function generate($template_view, $content_view, $data = null)
    {
        include 'application/views/layouts/' . $template_view;
    }
}