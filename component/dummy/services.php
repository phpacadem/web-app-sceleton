<?php
 return [
     'dummy' => DI\factory(function (\Psr\Container\ContainerInterface $c) {
         return new Dummy\Dummy();

     }),
 ];