<?php

function routes()
{
  return [
    '/' => 'Home@index',
    '/user/' => 'User@index',
  ];
}

function router()
{
  $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
  echo $uri;
}
?>