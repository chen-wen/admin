# 使用说明

## 创建数据库

首先创建你的数据库，并配置.env 文件并顺利连上数据库

命令行执行以下命令，并创建初始数据
```
php artisan migrate:install
php artisan migrate
php artisan db:seed
```

然后，启动你的应用，然后输入账号：demo@demo.com 密码:secret 登录系统



一个权限管理完善的系统就搭建完了