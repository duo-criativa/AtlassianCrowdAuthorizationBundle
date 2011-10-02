# Atlassian Crowd Authorization SSO for Symfony2

## Overview

The Atlassian Crowd Authorization SSO for Symfony2 allows your Symfony2 application
to authenticate your users with a Atlassian Crowd SSO server.

## Requirements

 * PHP 5.3+

## Dependancies

 * [AtlassianCrowdAuthorizationPHP](https://github.com/duo-criativa/AtlassianCrowdAuthorizationPHP)
 * [Buzz](https://github.com/kriswallsmith/Buzz)

## Installation

1. Add bundle, AtlassianCrowdAuthorizationPHP and Buzz library dependancy to `vendor` dir:

    * Using vendors script

        Add the following to the `deps` file:

            [Buzz]
                git=git://github.com/kriswallsmith/Buzz.git
                target=/Buzz

            [AtlassianCrowdAuthorizationPHP]
                git=git://github.com/duo-criativa/AtlassianCrowdAuthorizationPHP.git
                target=/Duo/AtlassianCrowdAuthorizationPHP

        Run the vendors script:

            $ php bin/vendors install

    * Using git submodules:

            $ git submodule add git://github.com/kriswallsmith/Buzz.git vendor/Buzz
            $ git submodule add git://github.com/duo-criativa/AtlassianCrowdAuthorizationPHP.git vendor/Duo/AtlassianCrowdAuthorizationPHP
            $ git submodule add git://github.com/duo-criativa/AtlassianCrowdAuthorizationBundle.git vendor/Duo/AtlassianCrowdAuthorizationBundle

2. Add the namespaces to your autoloader:

        // app/autoload.php
        $loader->registerNamespaces(array(
            // ..
            'Buzz'      => __DIR__.'/../vendor/Buzz/lib',
            'Duo\\AtlassianCrowdAuthorization'    => __DIR__.'/../vendor/Duo/AtlassianCrowdAuthorizationPHP/lib',
            'Duo\\AtlassianCrowdAuthorization'    => __DIR__.'/../vendor/Duo/AtlassianCrowdAuthorizationPHP/lib',
        ));

3. Add bundle to application kernel:

        // app/ApplicationKernel.php
        public function registerBundles()
        {
            return array(
                // ...
                new Duo\AtlassianCrowdAuthorizationBundle\AtlassianCrowdAuthorizationBundle(),
            );
        }

## Usage

Add to your config.yml

    factories:
        - "%kernel.root_dir%/../vendor/Duo/AtlassianCrowdAuthorizationBundle/Resources/config/security_factories.xml"

update the firewalls section of config.yml

    firewalls:
        secured_area:
            pattern:    ^/
            duo_atlassian_crowd_authorization: true


## TODO

 * todo
