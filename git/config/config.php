<?php

/**
 * The configuration for the relying party site customization.
 */ 
$gitConfig = array(
  // The API key in the Google API console.
  'apiKey' => 'AIzaSyAFMVvQWfPD-p4207IUTL_MzjFtaLwfwa8',
  // The default URL after the user is logged in.
  'homeUrl' => 'https://famille.miradou.com',
  // The user signup page.
  'signupUrl' => 'https://famille.miradou.com/signupUrl',
  // Scan the these absolute directories when finding the implementations e.g. account service and
  // session manager. The multiple directories should be separated by a ,
  'externalClassPaths' => '/var/www/famille.miradou.com/git,/var/www/famille.miradou.com/git/session',
  // The class name that implements the gitAccountService interface. You can also set the
  // implementation instance by leaving it empty and invoking the setter method in the gitContext
  // class. NOTE: The class name should be the same as the file name without the '.php' suffix.
  'accountService' => 'AccountServiceImpl',
  // The class name that implements the gitSessionManager interface. Same as the account service,
  // there is a setter method in the gitContext class. NOTE: the class name should be the same as
  // the file name without the '.php' suffix.
  'sessionManager' => 'gitSessionBasedSessionManager',
  // needed by gitSessionBasedSessionManager:31
  'sessionUserKey' => 'sessionUserKey',
  'idpAssertionKey' => 'idpAssertionKey'
);
