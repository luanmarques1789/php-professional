<?php

use function PHPSTORM_META\type;

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
    $params = explodeUriInParams($uri, $matchedUri);
  }
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
  return array_filter(
    $routes,
    function ($route) use ($uri) {

      return preg_match("/^$route$/", $uri);
    },
    ARRAY_FILTER_USE_KEY
  );
}

/**
 * Explode URI in params
 * 
 * @return array an array with the params of the URI
 */
function explodeUriInParams(string $uri, array $matchedUri): array
{
  if (!empty($matchedUri)) {

    $matchedToGetParams = array_keys($matchedUri)[0];

    $cleanUri = ltrim($uri, "/");
    $cleanMatchedToGetParams = ltrim(str_replace("\\", "", $matchedToGetParams), "/");

    return array_diff(explode("/", $cleanUri), explode("/", $cleanMatchedToGetParams));
  }
  return [];
}
