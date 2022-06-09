<?php

function routes(): array
{
  return require 'routes.php';
}

function router()
{
  $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
  echo "URI ${uri}<br>";
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
 * Static routes: match static URIs
 */
function matchExactUriInArrayRoutes(string $uri, array $routes): array
{
  if (array_key_exists($uri, $routes)) {
    echo "Rotas estáticas: " . $uri;
    return [$uri = $routes[$uri]];
  }

  return [];
}

/**
 * Dinamic routes: match dinamic URIs
 */
function matchArrayRoutesViaRegEx(string $uri, array $routes): array
{
  return array_filter($routes, function ($route) use ($uri) {
    echo "Route: ${route}<br>";

    return preg_match("/^$route$/", $uri);
  },
    ARRAY_FILTER_USE_KEY);
}


?>