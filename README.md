# Website Pemilhan Peralatan Camping-Laravel 11
## _Website ini merupakan Implementasi dari pengunaan Algoritma Content Based Filtering_

[![GitHub watchers](https://img.shields.io/github/watchers/Naereen/StrapDown.js.svg?style=social&label=Watch&maxAge=2592000)](https://GitHub.com/Naereen/StrapDown.js/watchers/) [![made-for-VSCode](https://img.shields.io/badge/Made%20for-VSCode-1f425f.svg)](https://code.visualstudio.com/)

## Fitur-Fitur

- Sistem Rekomendasi (Content Based Filtering, pendekatan TF-IDF)
- CRUD (Barang & Admin) 
- API (WhatsApp)


## Installasi
Gunakan Git, Jalankan..
```sh
git clone https://github.com/Roobbby/camping.git
```

Masuk ke Folder(Camping) dan buka code Editor lalu buka Terminal, Jalankan..

```sh
composer install 
```
> Copy env.example menjadi env 


Setelah itu, jalankan..
```sh
php artisan key:generate
```
>lalu setting, sesuaikan dengan database yang kalian gunakan
dan jalankan..

```sh
php artisan migrate
php artisan db:seed --class=AdminSeeder
php artisan ser
```
>default ADMIN username=Admin, Password=123456

#### Demo
will update soon..
