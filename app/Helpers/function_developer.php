<?php

function create_folder_thumb($thumb_size)
{
    if ($thumb_size) {
        return public_path() . "/thumbs/" . "/$thumb_size/";
    }
    return FALSE;
}
