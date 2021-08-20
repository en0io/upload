# en0 Upload

## Technologies used

- Laravel 8.0
- php 7.4
- Bootstrap 4
- MySQL 8 / MariaDB 10

## Summary

en0 Upload was inspired by Firefox Send, but supports OAuth through Laravel Socialite and can easily be adapted to
nearly any OAuth provider. By default, this repository uses GitLab OAuth to authenticate with the en0 GitLab environment.
By default Upload uses Laravel's `local` storage driver, but on our environment the `storage/uploads` folder is an NFS mount.

## Features

- File uploads are restricted to authenticated users
- Authentication through OAuth with Laravel Socialite
- No E2E encryption

## Security

Please contact sec@en0.io for security reports.

## License

TBD
