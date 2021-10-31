# en0 Upload

A Firefox Send alternative. No client-side crypto, allowing for wget/curling the URL.

## Summary
en0 Upload was inspired by Firefox Send, but supports OAuth through Laravel Socialite and
can easily be adapted to nearly any OAuth provider. By default, this repository uses GitLab
OAuth to authenticate with the en0 GitLab environment. By default Upload uses Laravel's
`local` storage driver, but on our environment the `storage/uploads` folder is an NFS mount.
Upload should be functional out of the box using S3 just by changing the storage driver to S3.

## Features
- File uploads are restricted to authenticated users
- Authentication through OAuth with Laravel Socialite
- No E2E encryption

## Technologies used
- Laravel 8.0
- php 7.4
- Bootstrap 4
- MySQL 8 / MariaDB 10

## Setup

 a good guide on the basics of setting up a Laravel application to run under Nginx, follow [this tutorial on DigitalOcean](https://www.digitalocean.com/community/tutorials/how-to-install-and-configure-laravel-with-nginx-on-ubuntu-20-04)


### Application-specific configuration flags

| Configuration flag | explanation |
| --- | --- |
| AUTH_LOCAL | Enables authentication using the built-in authentication system. |
| AUTH_GITLAB | Enables authentication using a GitLab instance's OAuth provider. If you're using this option, we recommend running your own GitLab instance so you have control over who can create accounts and aren't giving GitLab's public users access. | 
| GITLAB_CLIENT_ID | Your application's OAuth client ID from GitLab | 
| GITLAB_CLIENT_SECRET | Your application's OAuth secret from GitLab |
| GITLAB_BASE_URL | The URL of your GitLab environment |


### Alternative filesystem drivers

Upload can use a variety of filesystem drivers, by default it uses Laravel's `local` filesystem driver, but it can interface with Amazon S3 compatible storage platforms (S3, DigitalOcean Spaces, Minio, etc.), FTP and SFTP. You can also use an NFS share by mounting it at `storage/app/uploads` and giving your web server's user account read and write access to it.

You can read about how to configure your instance to use alternative filesystem providers at [https://laravel.com/docs/8.x/filesystem](https://laravel.com/docs/8.x/filesystem)


## Security

Please contact `sec@en0.io` for security reports.

## License

GPLv3
