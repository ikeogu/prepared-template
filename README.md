<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
Basic Laravel setup with Authencation with passport, roles and permission, media library, and php stan for analysis, and php pest for unit tesrt
</p>

## About Laravel

This is a Basic laravel setup repo for you to focus on just building rather than setting up development. it has  such as:

- [All Authentication functions and API with passport, OTP, and email verifications].
- [Spatie roles and permission is added to handle roles and permissions].
- Spatie media library to handle image and file uploads, add the trait to the model needed,
- Integrated  phpstan for analysis; this helps analyze your code base to standard.
- php pest for unit and feature test.
- Maintained S.O.L.I.D principle
- Third-party integrations with Paystack


Laravel is accessible, and powerful, and provides tools required for large, robust applications.

## Run the following commands to get started


- git clone repo
- composer install
- setup database in .env
- open the RolePermissionSeeder to modify roles to your taste and permission, following the arrays sample
- run php artisan migrate
- you can run composer pest to run the existing auth test
- run composer analyze to analyse your codebase

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
