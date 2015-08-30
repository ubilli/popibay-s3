<?php

$s3 = AWS::get('s3');
  $s3->putObject(array(
    'Bucket'     => 'popibay-bucket-s3',
    'Key'        => 'popibay/sitemap_remote.xml',
    'Body' => 'sitemap.xml'
  ));

?>