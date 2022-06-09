 <?php

return [
  '/' => 'Home@index',
  '/user/perfil' => 'User@perfil',
  '/user/[a-z0-9]+' => 'User@index',
  '/user' => 'User@index',
];

?>