
# 💰 vwallet - manage wallet transaction

Wallet to record incoming or outgoing transactions based on transaction's categories. Powered by laravel 9 and tabler template. 


## ⚡ Features

- Transaction transfer between wallet
- Dashboard Widget
- Planned Payment **[TODO]**
- Mobile API


## 🚀 Ship vwallet

vwallet require PHP >= 8.0.

Simply you can clone this repository:

```bash
git clone https://github.com/vantanto/vwallet.git
cd vwallet
```

Install dependencies using composer

```bash
composer install
```

Copy and Setup database in `.env` file

```bash
cp .env.example .env
```

Generate key & Run migration, seeding & Start local developement

```bash
php artisan key:generate
php artisan migrate --seed
php artisan serve
```

You can now access the server at http://localhost:8000
## 📝 Credit

#### Special Thanks
- [Laravel](https://laravel.com/)
- [Tabler](https://tabler.io/)

This project is [MIT](https://github.com/vantanto/vwallet/blob/master/LICENSE) licensed.