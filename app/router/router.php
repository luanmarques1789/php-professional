<?php

function routes(): array
{
  return require 'routes.php';
}

function router()
{
  $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
  $routes = routes();
  $matchedUri = matchExactUriInArrayRoutes($uri, $routes);


  if (empty($matchedUri)) {
    $matchedUri = matchArrayRoutesViaRegEx($uri, $routes);
  }

  echo "<br>";
  var_dump($matchedUri);
  die();
}

/**
 * Match static URIs
 */
function matchExactUriInArrayRoutes(string $uri, array $routes): array
{
  if (array_key_exists($uri, $routes)) {
    echo "Encontrou o URI: " . $uri;
    return [$uri = $routes[$uri]];
  }

  return [];
}

/**
 * Match dinamic URIs
 */
function matchArrayRoutesViaRegEx(string $uri, array $routes): array
{
  return array_filter($routes, function ($value) use ($uri) {
    $regex = str_replace('/', '\/', ltrim($value, '/'));
    return preg_match("/^$regex$/", ltrim($uri, '/'));
  },
    ARRAY_FILTER_USE_KEY);

}


?>