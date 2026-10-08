# Laravel URL Shortener

A small URL shortener I built for a technical assignment. It supports multiple companies, each with its own users, and what you can see and do depends on your role.

Built with Laravel 12, Breeze for login, and MySQL (SQLite works too). The pages are plain HTML on purpose, since the assignment said styling wasn't needed.

## What it does

- Companies have users. A user is either an Admin or a Member. There is also one SuperAdmin who sits above all companies and doesn't belong to any.
- The SuperAdmin invites the first Admin of a company. Admins can then invite more Admins or Members into their own company.
- Admins and Members can turn a long URL into a short one like `http://127.0.0.1:8000/aB72xK`. The SuperAdmin can't create URLs.
- Anyone can open a short link, logged in or not, and get redirected to the original URL.

Invitations don't send email. After you send one, the link is shown on the dashboard and you pass it on yourself. I did it this way so the project runs without any mail setup.

## What you need

- PHP 8.2 or newer
- Composer
- Node.js and npm
- MySQL, or SQLite if you don't want to install anything
- Git

## Setting it up

```bash
git clone https://github.com/<your-username>/<your-repo>.git
cd <your-repo>

composer install
npm install
npm run build

cp .env.example .env
php artisan key:generate
```

On Windows PowerShell, use `copy .env.example .env` for the fourth step.

### Database

The easiest option is SQLite. In `.env` set:

```env
DB_CONNECTION=sqlite
```

then delete the other `DB_*` lines and create the file:

```bash
touch database/database.sqlite
```

(On Windows: `type nul > database\database.sqlite`)

If you'd rather use MySQL, create an empty database first and fill in the details:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=url_shortener
DB_USERNAME=root
DB_PASSWORD=
```

Also make sure the app URL matches how you'll run it:

```env
APP_URL=http://127.0.0.1:8000
```

### Migrations and seeders

```bash
php artisan migrate
php artisan db:seed --class=SuperAdminSeeder
php artisan db:seed --class=CompanySeeder
```

The two seeders are separate, so you can run either one without the other. `SuperAdminSeeder` uses a raw SQL insert (the assignment asked for that) and checks whether the account exists first, so running it twice won't create a duplicate. `CompanySeeder` adds a few sample companies: Tech Solutions Pvt Ltd, Digital Marketing Agency, ABC Software Solutions, Global IT Services and Creative Web Studio.

If you want a clean slate, `php artisan migrate:fresh --seed` wipes everything and runs the seeders again.

### Default SuperAdmin login

```
Email:    superadmin@example.com
Password: password
```

Please change this if you ever put the project anywhere real.

## Running it

```bash
php artisan serve
```

Open http://127.0.0.1:8000 and log in. Each role lands on its own dashboard: `/superadmin/dashboard`, `/admin/dashboard` or `/member/dashboard`.

## Trying it out

A quick way to see everything working:

1. Log in as the SuperAdmin and click Invite.
2. Pick an existing company (or type a new name) and enter the email of the person who will be its Admin.
3. A link shows up on the dashboard. Copy it right away, because it disappears when you refresh. It works once and expires after 7 days.
4. Open that link in a private window. Choose a name and password and the Admin account is created inside that company.
5. Log in as that Admin. From there you can invite another Admin or a Member, and create short URLs.
6. Paste a long URL, hit Generate, then open the short link in another browser. It should send you to the original page.

## Who can do what

The SuperAdmin can invite Admins into any company, create companies, and see every short URL from every company. They can't create short URLs.

An Admin can invite Admins and Members, but only into their own company. They can create short URLs and see all URLs created in their company.

A Member can create short URLs and sees only the ones they created themselves.

If you open a page your role isn't allowed to see, you get a 403.

## Routes

```
GET   /                           redirects to login
GET   /dashboard                  sends you to your role's dashboard

GET   /invitations/{token}        accept-invitation form (guests only)
POST  /invitations/{token}        creates the account

GET   /superadmin/dashboard
GET   /superadmin/invite-client
POST  /superadmin/invite-client

GET   /admin/dashboard
GET   /admin/invite
POST  /admin/invite

GET   /member/dashboard

POST  /short-urls                 create a short URL (admin, member)
GET   /{shortCode}                public redirect
```

The public `/{shortCode}` route is registered last in `routes/web.php` and only matches 6 letters or digits. That way it can't swallow `/login`, `/dashboard` and the other real routes. Run `php artisan route:list` if you want the full list.

## A few things worth knowing

The company is never read from a form. Whenever an Admin or Member does something, the company comes from `auth()->user()->company_id`, so nobody can act on another company by editing the request.

When an Admin sends an invite, the role is checked against `admin` and `member` only, so a tampered form can't create a SuperAdmin.

Invitation links are single use and expire. The company, email and role for the new account come from the invitation record in the database, not from what the person types in.

Short URLs only accept `http` and `https`, so things like `javascript:` links get rejected.

Role names are always lowercase (`superadmin`, `admin`, `member`). `sales` and `manager` exist as values but don't have any features yet.

## Tests

```bash
php artisan test
```

The feature tests cover these cases:

1. An Admin can create a short URL.
2. A Member can create a short URL.
3. A SuperAdmin can't create a short URL.
4. An Admin only sees URLs from their own company.
5. A Member only sees URLs they created.
6. A SuperAdmin sees URLs from every company.
7. A public short link redirects to the original URL.
8. Changing an ID in a request doesn't give access to another company's data.

They run against an in-memory SQLite database, so your own data isn't touched.
`



## AI usage

I used ChatGPT to understand the project requirements and plan the overall flow. I already had the logic and approach in my mind, and I used ChatGPT mainly to help turn my ideas and observations into a working implementation. I also used Claude to help with some frontend forms and tables. The overall logic, decisions, and implementation approach were mine, while AI was used as a supporting tool.
