<?php
  # Retrieve settings from Parameter Store
  error_log('Retrieving settings');
  require 'aws.phar';
  $token = file_get_contents('http://169.254.169.254/latest/api/token', false, stream_context_create([
    'http' => [
        'method' => 'PUT',
        'header' => 'X-aws-ec2-metadata-token-ttl-seconds: 21600',
    ]
  ]));
 
  $az = file_get_contents('http://169.254.169.254/latest/meta-data/placement/availability-zone', false, stream_context_create([
     'http' => [
         'header' => "X-aws-ec2-metadata-token: $token",
    ]
  ]));
  $region = substr($az, 0, -1);
  $ssm_client = new Aws\Ssm\SsmClient([
     'version' => 'latest',
     'region'  => $region
  ]);
  
  try {
    # Retrieve settings from Parameter Store
    $result = $ssm_client->GetParametersByPath(['Path' => '/example/', 'WithDecryption' => true]);

    # Extract individual parameters
    foreach($result['Parameters'] as $p) {
        $values[$p['Name']] = $p['Value'];
    }

    $ep = $values['/example/endpoint'];
    $un = $values['/example/username'];
    $pw = $values['/example/password'];
    $db = $values['/example/database'];
  }
  catch (Exception $e) {
    $ep = '';
    $db = '';
    $un = '';
    $pw = '';
  }

?>