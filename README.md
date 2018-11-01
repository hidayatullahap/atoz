### ATOZ
### Installation

Atoz requires 
- PHP v7.1+ to run.
- MySql database
- php composer

### How to run atoz into your machine:
1. Clone this project to your directory

```sh
$ git clone https://github.com/hidayatullahap/atoz.git
```
2. Move into atoz folder
```sh
$ cd atoz
```
3. Install project's depedency

```sh
$ composer install
```
4. Create new database for atoz name it atoz.
5. Copy .env.example to .env
```sh
$ cp .env.example .env
```
7. Open .env and edit it
```sh
$ nano .env
```
8. Edit this line as your database username, password and other requirement
```sh
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=
DB_DATABASE=atoz
DB_USERNAME=root
DB_PASSWORD=
```
9. Up the project and install plugin depedency
```sh
$ php artisan october:up
```
10. Congratulation atoz has been installed to your machine