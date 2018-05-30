Two-factor authentication with Yii2 and Telegram
------------------------------------------------

![Screen recorder authentication](https://github.com/gavrikpavel/yii2-auth-telegram/Example.gif)

### About

This code allows you to add two-factor authentication to your site using API Telegram to confirm registration.
Just put your @nickname.

This project was developed on the [Yii 2.0 Basic Application Template](https://github.com/yiisoft/yii2-app-basic).
The structure of the project didn't change, except     
* components/bot      contains minimal Telegram bot API
* The controller with the business logic of authorization is AuthController

### Preparation

**Add necessary requirements to the composer**
```
"require": {
  "yiisoft/yii2-redis": "~2.0.0",
  "yiisoft/yii2-queue": "~2.0.0"
},
```
Read more about the extensions for links: [yii2-queue](https://github.com/yiisoft/yii2-queue), [yii2-redis](https://github.com/yiisoft/yii2-redis)

**Add necessary table and columns to bd**
Creating new table _Update_. More in migrations
```
yii migrate/create update_table

```

Add new colums in _User_
```
$this->addColumn('user', 'username_tlgrm', $this->string()->unique());
$this->addColumn('user', 'confirm_token', $this->int());
```
**Add your Telegram token**
Add your Telegram token to `components/bot/TelegramBotTrait.php`
``` php
private $token = '***Bot Token***';
```

