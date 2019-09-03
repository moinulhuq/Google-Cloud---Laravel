<?php

Step 01: Create database instance from

	https://console.cloud.google.com/sql/instances

Step 02: Click on Create instance then select Mysql second generation link and give a name to that instance and password. You can leave Location (Region, Zone) and Database version as it is.

Step 03: Right after that install the Cloud SQL proxy client on your local machine. The Cloud SQL proxy is used to connect to your Cloud SQL instance when running locally.

	https://cloud.google.com/sql/docs/mysql/connect-external-app#install

From the upper URL look for windows version computable exe file and download it. Copy this "cloud_sql_proxy_x64.exe" to 'C:\Users\Admin\AppData\Local\Google\Cloud SDK\google-cloud-sdk\bin' and rename to "cloud_sql_proxy.exe".
	
Step 04: Next enable the Cloud SQL Admin API in order to use the Cloud SQL Proxy Client.

	https://console.cloud.google.com/flows/enableapi?apiid=sqladmin&redirect=https:%2F%2Fconsole.cloud.google.com&_ga=2.199835369.-67568842.1566946175

Select your project from dropdown and then click continue.

Step 05: Then try to get the "connectionName" using the following command

	gcloud sql instances describe YOUR_INSTANCE_NAME | findstr connectionName

Step 06: Start the Cloud SQL proxy and replace YOUR_CONNECTION_NAME with the connection name you retrieved in the previous step.

	cloud_sql_proxy -instances=YOUR_CONNECTION_NAME=tcp:3306

use ctrl+c to return to cmd window

Step 07: Use 'gcloud' cmd to create a database for the application.

	gcloud sql databases create laravel --instance=YOUR_INSTANCE_NAME

Step 08: After that run the database migrations for Laravel using the following command it will create local database table

	php artisan session:table
	php artisan migrate --force

Step 09: Then get the databse dump from phpmyadmin and save it for later step

Step 10: Click on the 'Instance' name from

	https://console.cloud.google.com/sql/instances

Select database tab to see wheter the 'laravel' databse created or not

Step 11: If created then goto

	https://console.cloud.google.com/storage

Select YOUR_PROJECT_NAME.appspot.com and then click on 'Upload files' to upload your database dump file to that bucket

Step 12: Goto your 'Instance' page again and select your instance name from 

	https://console.cloud.google.com/sql/instances

then click on import to import that dump file from bucket.

Step 13: Modify your 'app.yaml' file with the following contents:

	runtime: php72

	env_variables:
	  ## Put production environment variables here.
	  APP_KEY: YOUR_APP_KEY
	  APP_STORAGE: /tmp
	  VIEW_COMPILED_PATH: /tmp
	  CACHE_DRIVER: database
	  SESSION_DRIVER: database
	  ## Set these environment variables according to your CloudSQL configuration.
	  DB_DATABASE: YOUR_DB_DATABASE
	  DB_USERNAME: YOUR_DB_USERNAME
	  DB_PASSWORD: YOUR_DB_PASSWORD
	  DB_SOCKET: "/cloudsql/YOUR_CONNECTION_NAME"

Step 14: Replace YOUR_DB_DATABASE, YOUR_DB_USERNAME, YOUR_DB_PASSWORD, and YOUR_CONNECTION_NAME with the values you created for your Cloud SQL instance above.

Step 15: Then deploy this file to the server using this cmd.

	gcloud app deploy

Step 16: Visit http://YOUR_PROJECT_ID.appspot.com to see the Laravel welcome page.
