# Deploy Plugin

A simple way to deploy your application to a remote location.

## Requirements

- October CMS 2.1.20 or above
- PHP openssl extension
- PHP eval function

### Why is This Plugin Needed?

This plugin helps in cases where your remote server (production, staging, etc) does not have the ability to run the standard deployment workflow, either due to lack of computational resources or lack of service by the hosting provider. An example of this is shared hosting, where shell access is limited or composer does not have enough memory to execute.

### How It Works

The Deploy plugin works by creating a secure channel between your local developer environment and your hosting server. Plugins, themes and core files are then compressed and sent securely to your server and then installed remotely. This approach is similar to an update gateway, except files are pushed to the server instead.

## Documentation

Before starting, you should have set up a new site in your hosting manager and ideally have an empty database. You may also apply these instructions to an existing website, including legacy versions of October CMS, however, please make sure you have taken a complete backup in case something goes wrong.

#### Control Panel Setup

After installing this plugin, navigate to the Settings > Deploy in your October CMS control panel and click **Create Server**.

1. Enter the web address for your site (eg: https://mycpanelwebsite.tld/)
2. Generate a new RSA private key, or enter an existing one to set up an existing server
3. Download the Beacon ZIP files

#### Beacon Deployment

In your Beacon ZIP file, you should notice the following files:

- index.php
- bootstrap/app.php
- bootstrap/autoload.php
- bootstrap/beacon.php

You can upload these files anywhere and they will become a target for deployment of October CMS. You can use FTP or the file manager in your hosting control panel.

> **Important**: The directory where the files are uploaded must be writable by your web server (eg: permission 755 for apache).

#### Run Your First Deployment

Once you have the Beacon installed remotely and the server set up locally. It's time to perform your first deployment.

#### Using `.deployignore` to Ignore Files

There are times when you don't want specific files to be deployed, such as the `node_modules` directory used in plugins and themes. This is possible by creating a `.deployignore` file in the base directory of your plugin or theme. This file behaves the same as `.gitignore` file where you can configure Git to [ignore files you don't want to check in](https://docs.github.com/en/get-started/getting-started-with-git/ignoring-files).

The following `.deployignore` file will exclude the **node_modules** directory:

    node_modules/

The file must be located at the base directory of the theme or plugin. For example:

- **themes/demo/.deployignore**
- **plugins/acme/demo/.deployignore**

### License

This plugin is an official extension of the October CMS platform and is free to use if you have a platform license. See [EULA license](LICENSE.md) for more details.
