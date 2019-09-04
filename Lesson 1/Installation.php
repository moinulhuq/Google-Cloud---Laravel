<?php

Step 01: Create a project in the Google Cloud Platform Console.

	https://console.cloud.google.com/project

Step 02: Enable billing for your project (Do it by yourself).

Step 03: Install Laravel in your local PC.

	A) To install laravel you required "Composer" dependency manager. Get it and install it

		https://getcomposer.org/download/

	B) Then run this command to install laravel

		composer global require laravel/installer

	C) After that create laravel project under your local server folder 'htdocs' or	'www'

		laravel new blog

	D) Go to the blog directory

		cd blog

	E) Run the app with the following command:

		php artisan serve

	F) Visit http://localhost:8000 to see the Laravel Welcome page locally.

Step 04: Create 'app.yaml' in the root directory of Laravel project.

	app.yaml
	--------
	runtime: php72
	env_variables:
	  ## Put production environment variables here.
	  APP_KEY: YOUR_APP_KEY
	  APP_STORAGE: /tmp
	  VIEW_COMPILED_PATH: /tmp
	  SESSION_DRIVER: cookie

	You can find your YOUR_APP_KEY at '.env' file

Step 05: Right after that go and modify bootstrap/app.php by adding the following block of code before the return statement. This will allow you to set the storage path to /tmp for caching in production.

	# [START] Add the following block to `bootstrap/app.php`
	/*
	|--------------------------------------------------------------------------
	| Set Storage Path
	|--------------------------------------------------------------------------
	|
	| This script allows you to override the default storage location used by
	| the  application.  You may set the APP_STORAGE environment variable
	| in your .env file,  if not set the default location will be used
	|
	*/

	$app->useStoragePath(env('APP_STORAGE', base_path() . '/storage'));

	# [END]

Step 06: Finally, remove the beyondcode/laravel-dump-server composer dependency. This is a fix for an error which happens as a result of Laravel's caching in bootstrap/cache/services.php.
	composer remove --dev beyondcode/laravel-dump-server

Step 07: Download and Install Google Cloud SDK.
	
	https://cloud.google.com/sdk/docs/quickstart-windows

Step 08: Run the following command form your root directory to deploy your app:

	gcloud app deploy

Step 09: Visit http://YOUR_PROJECT_ID.appspot.com to see the Laravel welcome page. Replace YOUR_PROJECT_ID with the ID of your GCP project.
