<?php


Kirby::plugin('wagnerpaul/deploy-content', [
    'siteMethods' => [
        'flush_dir' => function ($dir) {
          if (!is_dir($dir))  return ;

          $dir = new RecursiveDirectoryIterator($dir, FilesystemIterator::SKIP_DOTS);
          $dir = new RecursiveIteratorIterator($dir,RecursiveIteratorIterator::CHILD_FIRST);
          
          foreach ( $dir as $file ) { 
              $file->isDir() ?  rmdir($file) : unlink($file);
          }
        },
        'push_dir' => function ($src,$dst) {    
            if (!is_dir($src))  return ; 
            $dir = opendir($src);
            @mkdir($dst);
            while(( $file = readdir($dir)) ) {
              if (( $file != '.' ) && ( $file != '..' )) {
                if ( is_dir($src . '/' . $file) ) {
                  $this->push_dir($src .'/'. $file, $dst .'/'. $file);
                }
                else {
                  copy($src .'/'. $file,$dst .'/'. $file);
                }
              }
            }
            closedir($dir);
        }
    ],
    'routes' => function ($kirby) {
        return [

            [
                'pattern' => getenv('DEPLOY_CONTENT_HOOK').'/start',
                'method' => 'POST',
                'action'  => function () {
                  $key = kirby()->request()->get('key');
                  if (option('env') !== 'prod' && $key === getenv('DEPLOY_CONTENT_KEY')) {
                    $response = Response::json(['status' => 'start'], 200);
                  } else {
                    $response = Response::json(['status' => 'error'], 400);
                  }
                  return $response;
                }
            ],

        ];
      },
      'hooks' => [
          //after our progress has started do the directory copying
          'route:after' => function ($route, $path, $method) {
            $endpointAndHook = getenv('WEBHOOKS_ENDPOINT').'/'.getenv('DEPLOY_CONTENT_HOOK');
            if (option('env') !== 'prod' && $path === $endpointAndHook.'/progress' && $method === 'POST') {
              $kirby = kirby();
              $site = $kirby->site();
              $site->flush_dir('/app/content-prod');
              $site->push_dir('/app/content','/app/content-prod');
              $site->flush_dir('/app/storage-prod/cache');


                $url = kirby()->site()->url().'/'.$endpointAndHook.'/success';
                $data = ['status' => 'success'];
                $options = [
                    'basicAuth'=> getenv('BASIC_AUTH_USER').':'.getenv('BASIC_AUTH_PASSWORD'),
                    'method'  => 'POST',
                    'data'    => json_encode($data)
                 ];
                $response = Remote::request($url, $options);  
            }
          },


      ]
  
]);
