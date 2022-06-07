<?php

function routes(): array
{
  return require 'routes.php';
}

function exatcMatchUriInArrayRoutes(string $uri, array $routes): array
{
  if (array_key_exists($uri, $routes)) {
    echo "Encontrou o URI: " . $uri;
    return [];
  }
  else {
    echo "Chorastes?";
  }

  return [];
}

function router()
{
  $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
  echo $uri;

  $routes = routes();
  $matchedUri = exatcMatchUriInArrayRoutes($uri, $routes);
// echo $matchedUri;
}
?>