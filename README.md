# The Auction Hub - lbaw24136


## The Auction Hub
The Auction Hub, a project designed to be the leading online auction platform for high-value luxury items built on a foundation of trust, authenticity and security. We offer an exclusive experience tailored for discerning customers, providing an easy-to-use platform for buying and selling exquisite goods with confidence.


## Intallation


To test our website just run the following command.


```
docker login gitlab.up.pt:5050
docker run -d --name lbaw24136 -p 8001:80  gitlab.up.pt:5050/lbaw/lbaw2425/lbaw24136
```
A container will be started with an image of our website connected to the production database. You can access it at `localhost:8001`.

As it uses a database associated to an university server, there maybe access restrictions, in that case you can use the local database and the test environment with:


```
npm run build
php artisan db:seed
php artisan serve
```

You can access it at `localhost:8000`.

### Usage

#### Administration Credentials

Here, [Administration URL](http://127.0.0.1:8001/admin/dashboard), you can access the admin dashboard, keep in mind you have to be logged in as an admin to access the page.

| Email | Password |
|----------|----------|
| admin@lbaw24.com | 12345678 |

#### User Credentials

| Type | Username | Password |
|------|----------|----------|
| Regular account | lbaw@lbaw.com | 12345678 |


See more details of this project in:
* [Wiki Home Page](https://github.com/tfcc13/FEUP-3Y1S-LBAW-The-Auction-Hub/wiki)
* [ER: Requirements Specification](https://github.com/tfcc13/FEUP-3Y1S-LBAW-The-Auction-Hub/wiki/er)
* [EBD: Database Specification](https://github.com/tfcc13/FEUP-3Y1S-LBAW-The-Auction-Hub/wiki/ebd)
* [EAP: Architecture Specification and Prototype](https://github.com/tfcc13/FEUP-3Y1S-LBAW-The-Auction-Hub/wiki/eap)
* [PA: Product and Presentation](https://github.com/tfcc13/FEUP-3Y1S-LBAW-The-Auction-Hub/wiki/pa)

# Team

* Afonso Pereira up202107138@up.pt

* Miguel Cabral up2022004996@up.pt

* Tiago Carvalho up202103339@up.pt 

***
GROUP24136,  22/12/2024

--- 

> Group: 6  
> Final Grade: 17.2  
 




