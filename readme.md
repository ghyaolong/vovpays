## Laravel 5.5.* + Mysql 5.7 + PHP 7.2.* 

##安装步骤
1. 下载或克隆项目，进入项目根目录执行``composer install``,等待框架安装
2. 将.env.example修改为.env,并进行相关配置,然后在项目根目录执行``php artisan key:generate``
3. 手动创建数据库,执行``php artisan migrate:refresh --seed``迁移数据库表结构和数据

##使用扩展包：
1. 验证码 [mews/captcha](https://github.com/mewebstudio/captcha)


##使用前端资源：
1. AdminLTE
2. toastr.js
3. sweetalert

