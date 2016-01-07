<?php

require_once __DIR__ . '/vendor/autoload.php';

use Silex\Application;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

$app = new Application;
$app['debug'] = false;

$app['redis'] = $app->share(function() {
    return new class {
        private $redis;
        public function __construct()
        {
            $this->redis = new Redis();
            $this->redis->connect(getenv('GITHUBCOUNTER_REDIS_1_PORT_6379_TCP_ADDR'));
            $this->redis->auth(getenv('REDIS_PASS'));
        }
        public function update($key)
        {
            $value = 0;

            if (true === $this->redis->exists($key)) {
                $value = $this->redis->get($key);
            }

            $this->redis->set($key, ($value + 1));
        }
        public function get($key)
        {
            return $this->redis->get($key);
        }
        public function __destruct()
        {
            $this->redis->close();
        }
    };
});

$app->get('/', function () {
   return new RedirectResponse('https://github.com/tommy-muehle/github-counter');
});

$app->get('/{vendor}/{repository}', function (Application $app, $vendor, $repository) {

    $key = sprintf('%s/%s', $vendor, $repository);
    $app['redis']->update($key);

    $content = '
        <svg xmlns="http://www.w3.org/2000/svg" width="95" height="20">
           <linearGradient id="b" x2="0" y2="100%">
               <stop offset="0" stop-color="#bbb" stop-opacity=".1"/>
               <stop offset="1" stop-opacity=".1"/>
           </linearGradient><mask id="a">
           <rect width="95" height="20" rx="3" fill="#fff"/>
           </mask>
           <g mask="url(#a)"><path fill="#555" d="M0 0h53v20H0z"/>
               <path fill="#53b7f9" d="M53 0h42v20H53z"/>
              <path fill="url(#b)" d="M0 0h95v20H0z"/>
          </g>
          <g fill="#fff" text-anchor="middle" font-family="DejaVu Sans,Verdana,Geneva,sans-serif" font-size="11">
              <text x="26.5" y="15" fill="#010101" fill-opacity=".3">hits</text>
              <text x="26.5" y="14">hits</text><text x="73" y="15" fill="#010101" fill-opacity=".3">
                 ' . $app['redis']->get($key) . '
              </text>
              <text x="73" y="14">
                ' . $app['redis']->get($key) . '
              </text>
          </g>
        </svg>
    ';

    return new Response($content, Response::HTTP_OK, [
        'Content-Type' => 'image/svg+xml;charset=utf-8',
        'Cache-Control' => 'no-cache',
        'Content-Disposition' => sprintf('inline; filename="%s.svg"', $repository),
        'Connection' => 'Keep-Alive'
    ]);
});

$app->run();
