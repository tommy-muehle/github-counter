# github-counter

[![No Maintenance Intended](http://unmaintained.tech/badge.svg)](http://unmaintained.tech/)

Generate your own "hits" (How idiots track success) badge to your repositories and track page views.

## How it works

If an user look at your [README](README.md) or other markdown file, that include the badge, a request 
to the counter application with the repository key is sent. The [application](app/app.php) saves the 
page-view in the related [redis database](redis) and returns the updated badge.

## Requirements and Install

For the easiest install you need a [docker](https://www.docker.com/)'able hosting plattform or service.
Personal i'm using [DigitalOcean](https://www.digitalocean.com/) for this.

Alternately you can only take the [application part](app).

### Installation steps with docker and docker-compose:

* Install dependencies via [Composer](https://getcomposer.org/) for the application

```
$ cd app
$ composer install --no-dev
```

* Set a password for redis [here](env/common.env)
* Update the [nginx vhost file](nginx/sites-enabled/counter_vhost) (server_name)
* Add certs for your domain [here](nginx/certs) (private.key and ssl-bundle.crt)
* (optional) Update [redis.conf](redis/conf/redis.conf) (password is set automatically)

After this just run the following commands:

```
$ docker-compose build
```

and 

```
$ docker-compose up -d
```

## Demo

Look at the top of this document and reload. :-)

## Debugging and customizing

If something went wrong you can first set the debug mode for the [Silex](http://silex.sensiolabs.org/) 
application.

```
$app['debug'] = true;
```

And if you want some more fancy badges update the svg part in the [application](app/app.php#L52).

```
<svg xmlns="http://www.w3.org/2000/svg" width="95" height="20">
...
</svg>
```

## ToDo 

* add a data-container for redis database
