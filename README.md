finance_testcase
================

Установка:

 git clone https://github.com/shcherbanich/finance_testcase.git

 cd finance_testcase

 composer install --optimize-autoloader

 bower install

 php app/console router:debug --env=prod

 php app/console assets:install --symlink

 php app/console doctrine:database:create --if-not-exists

 php app/console doctrine:schema:update  --force

 php app/console doctrine:fixtures:load


Субд mysql, php 5.4+

Можно:

    1. Регистрироваться  /registration
    2. Авторизироваться  /login
    3. Просматривать список своих акций /shares
    4. Добавлять акцию /shares/new
    5. Просматривать стоимость портфеля от времени за 2 последних года /shares/{id}
    6. Удалять акцию из списка
