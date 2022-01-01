<?php

  $teamid = "";
  $bundleid = "";
  $devicetoken = "";
  $apns = "api.sandbox.push.apple.com";
  $authkeyid = "";
  $authkeyfile = "";

// You must fill out all of the above variables.

  $now = time ();
  $authheader = base64_encode ("{ \"alg\": \"ES256\", \"kid\": \"$authkeyid\" }");
  $jwtheader = str_replace ("=", "", str_replace ("+/", "-_", $authheader));

  $teampkg = base64_encode ("{ \"iss\": \"$teamid\", \"iat\": $now }");
  $jwtclaims = str_replace ("=", "", str_replace ("+/", "-_", $teampkg));

  $jwtheaderclaims = $jwtheader . "." . $jwtclaims;

  $pkey = openssl_pkey_get_private ("file://$authkeyfile");
  $signheaderclaims = openssl_sign ($jwtheaderclaims, $signature, $pkey, "sha256");

  $jwtsignedheaderclaimsb64 = base64_encode ($signature);
  $jwtsignedheaderclaims = str_replace ("=", "", str_replace ("+/", "-_", $jwtsignedheaderclaimsb64));

  $authtoken = $jwtheader . "." . $jwtclaims . "." . $jwtsignedheaderclaims;

  $url = "https://" . $apns . "/3/device/" . $devicetoken;
  $ch = curl_init ();

  curl_setopt ($ch, CURLOPT_HTTPHEADER,
    array(
     "Content-Type:application/json",
     "apns-topic: $bundleid",
     "apns-push-type: alert",
     "authorization: bearer $authtoken"));

  $message = "{\"aps\":{\"alert\":\"testing123\"}}";

  curl_setopt_array ($ch, [
        CURLOPT_URL            =>$url,
        CURLOPT_POSTFIELDS     =>$message,
        CURLOPT_POST           =>1,
        CURLOPT_HEADER         =>true,
        CURLOPT_RETURNTRANSFER =>true,
        CURLOPT_HTTP_VERSION   =>CURL_HTTP_VERSION_2_0]);

  $result = curl_exec($ch);

  print_r ($result);
  curl_close ($ch);


?>
