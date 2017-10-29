Packtpub Free Daily Book
=================================

Packtpub daily is a script written in PHP that helps you claim your every day free eBook from [packtpub.com](https://www.packtpub.com/packt/offers/free-learning).

## How to use it
1. Copy and edit env.example.php to env.php and set your credentials
2. Run main.php using the following command:
```
php main.php
```
> Tip: You can add it to your system cronjobs to automaticaly claim your free eBook every day.

The following example shows how to claim your eBook every day at 6am:

```
0 6 * * * /usr/bin/php /path/to/files/packtpub-downloader.php >/dev/null 2>&1