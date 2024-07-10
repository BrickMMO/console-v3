<?php

/*
 * Dump data
 */
if(ENV_DEBUG)
{
    debug_pre($_GET);
    debug_pre($_POST);
    debug_pre($_SESSION);
    debug_pre($_COOKIE);
    // debug_pre(get_defined_constants());
}
