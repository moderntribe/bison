# Bison

Starter Framework for Modern Tribe projects. It is built using the Laravel framework and FilamentPHP for the admin panel.

## Prerequisites
Make sure you have installed all the following prerequisites on your development machine:
- [Lando](https://lando.dev/) - The preferred method for local development, dependency management and automation tooling.
- [Composer](https://getcomposer.org/)
- [Node.js and NPM](https://nodejs.org/en/)

## Installation

To install and run the associated sites locally, you can follow the steps below.

### **Start Lando**

To begin, you can start Lando.

```bash
lando start
```

Now, you should be able to access the Laravel admin at `https://bison.lndo.site/`.

### **Access the Admin Panel**

If you are starting from a fresh installation, you may have to create a new admin user. To do this, enter the following command and follow the prompts:

```bash
lando make-user
```

Example Output:
```bash

 ┌ Name ────────────────────────────────────────────────────────┐
 │ Modern Tribe                                                 │
 └──────────────────────────────────────────────────────────────┘

 ┌ Email address ───────────────────────────────────────────────┐
 │ vendors@tri.be                                               │
 └──────────────────────────────────────────────────────────────┘

 ┌ Password ────────────────────────────────────────────────────┐
 │ ••••••••                                                     │
 └──────────────────────────────────────────────────────────────┘

   INFO  Success! vendors@tri.be may now log in at https://bison.lndo.site/auth/login.
```
