# ErrorException - Internal Server Error

Undefined variable $revenue

PHP 8.2.12
Laravel 12.37.0
127.0.0.1:8000

## Stack Trace

0 - resources\views\admin\dashboard.blade.php:41
1 - vendor\laravel\framework\src\Illuminate\Filesystem\Filesystem.php:123
2 - vendor\laravel\framework\src\Illuminate\Filesystem\Filesystem.php:124
3 - vendor\laravel\framework\src\Illuminate\View\Engines\PhpEngine.php:57
4 - vendor\laravel\framework\src\Illuminate\View\Engines\CompilerEngine.php:76
5 - vendor\laravel\framework\src\Illuminate\View\View.php:208
6 - vendor\laravel\framework\src\Illuminate\View\View.php:191
7 - vendor\laravel\framework\src\Illuminate\View\View.php:160
8 - vendor\laravel\framework\src\Illuminate\Http\Response.php:78
9 - vendor\laravel\framework\src\Illuminate\Http\Response.php:34
10 - vendor\laravel\framework\src\Illuminate\Routing\Router.php:939
11 - vendor\laravel\framework\src\Illuminate\Routing\Router.php:906
12 - vendor\laravel\framework\src\Illuminate\Routing\Router.php:821
13 - vendor\laravel\framework\src\Illuminate\Pipeline\Pipeline.php:180
14 - app\Http\Middleware\AdminMiddleware.php:31
15 - vendor\laravel\framework\src\Illuminate\Pipeline\Pipeline.php:219
16 - vendor\laravel\framework\src\Illuminate\Routing\Middleware\SubstituteBindings.php:50
17 - vendor\laravel\framework\src\Illuminate\Pipeline\Pipeline.php:219
18 - vendor\laravel\framework\src\Illuminate\Auth\Middleware\Authenticate.php:63
19 - vendor\laravel\framework\src\Illuminate\Pipeline\Pipeline.php:219
20 - vendor\laravel\framework\src\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken.php:87
21 - vendor\laravel\framework\src\Illuminate\Pipeline\Pipeline.php:219
22 - vendor\laravel\framework\src\Illuminate\View\Middleware\ShareErrorsFromSession.php:48
23 - vendor\laravel\framework\src\Illuminate\Pipeline\Pipeline.php:219
24 - vendor\laravel\framework\src\Illuminate\Session\Middleware\StartSession.php:120
25 - vendor\laravel\framework\src\Illuminate\Session\Middleware\StartSession.php:63
26 - vendor\laravel\framework\src\Illuminate\Pipeline\Pipeline.php:219
27 - vendor\laravel\framework\src\Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse.php:36
28 - vendor\laravel\framework\src\Illuminate\Pipeline\Pipeline.php:219
29 - vendor\laravel\framework\src\Illuminate\Cookie\Middleware\EncryptCookies.php:74
30 - vendor\laravel\framework\src\Illuminate\Pipeline\Pipeline.php:219
31 - vendor\laravel\framework\src\Illuminate\Pipeline\Pipeline.php:137
32 - vendor\laravel\framework\src\Illuminate\Routing\Router.php:821
33 - vendor\laravel\framework\src\Illuminate\Routing\Router.php:800
34 - vendor\laravel\framework\src\Illuminate\Routing\Router.php:764
35 - vendor\laravel\framework\src\Illuminate\Routing\Router.php:753
36 - vendor\laravel\framework\src\Illuminate\Foundation\Http\Kernel.php:200
37 - vendor\laravel\framework\src\Illuminate\Pipeline\Pipeline.php:180
38 - vendor\laravel\framework\src\Illuminate\Foundation\Http\Middleware\TransformsRequest.php:21
39 - vendor\laravel\framework\src\Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull.php:31
40 - vendor\laravel\framework\src\Illuminate\Pipeline\Pipeline.php:219
41 - vendor\laravel\framework\src\Illuminate\Foundation\Http\Middleware\TransformsRequest.php:21
42 - vendor\laravel\framework\src\Illuminate\Foundation\Http\Middleware\TrimStrings.php:51
43 - vendor\laravel\framework\src\Illuminate\Pipeline\Pipeline.php:219
44 - vendor\laravel\framework\src\Illuminate\Http\Middleware\ValidatePostSize.php:27
45 - vendor\laravel\framework\src\Illuminate\Pipeline\Pipeline.php:219
46 - vendor\laravel\framework\src\Illuminate\Foundation\Http\Middleware\PreventRequestsDuringMaintenance.php:109
47 - vendor\laravel\framework\src\Illuminate\Pipeline\Pipeline.php:219
48 - vendor\laravel\framework\src\Illuminate\Http\Middleware\HandleCors.php:48
49 - vendor\laravel\framework\src\Illuminate\Pipeline\Pipeline.php:219
50 - vendor\laravel\framework\src\Illuminate\Http\Middleware\TrustProxies.php:58
51 - vendor\laravel\framework\src\Illuminate\Pipeline\Pipeline.php:219
52 - vendor\laravel\framework\src\Illuminate\Foundation\Http\Middleware\InvokeDeferredCallbacks.php:22
53 - vendor\laravel\framework\src\Illuminate\Pipeline\Pipeline.php:219
54 - vendor\laravel\framework\src\Illuminate\Http\Middleware\ValidatePathEncoding.php:26
55 - vendor\laravel\framework\src\Illuminate\Pipeline\Pipeline.php:219
56 - vendor\laravel\framework\src\Illuminate\Pipeline\Pipeline.php:137
57 - vendor\laravel\framework\src\Illuminate\Foundation\Http\Kernel.php:175
58 - vendor\laravel\framework\src\Illuminate\Foundation\Http\Kernel.php:144
59 - vendor\laravel\framework\src\Illuminate\Foundation\Application.php:1220
60 - public\index.php:20
61 - vendor\laravel\framework\src\Illuminate\Foundation\resources\server.php:23

## Request

GET /admin/dashboard

## Headers

* **host**: 127.0.0.1:8000
* **user-agent**: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0
* **accept**: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8
* **accept-language**: en-US,en;q=0.5
* **accept-encoding**: gzip, deflate, br, zstd
* **connection**: keep-alive
* **referer**: http://127.0.0.1:8000/admin/menus
* **cookie**: XSRF-TOKEN=eyJpdiI6IjZSckZlaVJKV3lGR1JqT242YmZCRUE9PSIsInZhbHVlIjoiSXdEYytUWkNjcVlhdFNudm9PWkhoUDE5U2dqRGlyamtjaVZvVHQveWdzRHErSHkrbWl5ZjdxVkE3Y1lkdVdOc2gyMWZGbnAxL2h5dWMzQTNHaTRDWSsxMHlESExwZmZhR25DMHhUb0VzWC81K2pyQWRhbHlIVkU1VE1GQmdkc2wiLCJtYWMiOiJjYmNjODVkMTdkOWRkMjAzZjliMzliMzJhYjU1ODQxZDY2N2NlZWM3NmQ1NDUzNmNmMDcxMjkzNzQ3NGNhMjY4IiwidGFnIjoiIn0%3D; laravel-session=eyJpdiI6Ik5JeUtzRFd4QjRTak5RZExORThzK3c9PSIsInZhbHVlIjoiK25oY2p0dXJhZStndzYwaUMvdzJ4ZlkxUlFjOHg0OERoRThEWkVrVmdPSXpKUmR5eDRFZTYvQWc1UWErcm81cURwWXZqVk1JMEI0MW42Q2Y5WlN4RGZ2VkhPN0xXcmtCbXlYV1dkamFJUWxHYjRBTnB6WlJxZC9RWnY2ZVN1SVEiLCJtYWMiOiJhMzk2NjgyMjYyMjgyNThjYmRjOGI1ZjIzOGEwZjcyMTQyZmJmNGRmNzRlZDljMTY2MjdiZDA0Nzk5MzllN2E1IiwidGFnIjoiIn0%3D
* **upgrade-insecure-requests**: 1
* **sec-fetch-dest**: document
* **sec-fetch-mode**: navigate
* **sec-fetch-site**: same-origin
* **sec-fetch-user**: ?1
* **priority**: u=0, i

## Route Context

controller: App\Http\Controllers\AdminController@index
route name: admin.dashboard
middleware: web, auth, admin

## Route Parameters

No route parameter data available.

## Database Queries

* mysql - select * from `sessions` where `id` = 'iQ4pS59LUMAY4AnGio5wauKJShXh6YdrGbbuVfdT' limit 1 (21.09 ms)
* mysql - select * from `users` where `id` = 1 limit 1 (1.42 ms)
* mysql - select count(*) as aggregate from `orders` (1.16 ms)
* mysql - select count(*) as aggregate from `menus` (1.19 ms)
* mysql - select count(*) as aggregate from `users` where `role` = 'user' (1.27 ms)
* mysql - select * from `orders` order by `created_at` desc limit 5 (1.32 ms)
