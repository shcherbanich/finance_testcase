finance_testcase
================

Установка:

 git clone https://github.com/shcherbanich/finance_testcase.git

 cd finance_testcase

 composer install --optimize-autoloader

 php app/console router:debug --env=prod

 php app/console assets:install --symlink

 php app/console doctrine:database:create --if-not-exists

 php app/console doctrine:schema:update --force

 php app/console doctrine:fixtures:load --purge-with-truncate


Субд mysql, php 5.4+

Можно:

    1. Регистрироваться  /registration
    2. Авторизироваться  /login
    3. Просматривать список своих акций /shares
    4. Добавлять акцию /shares/new
    5. Просматривать стоимость портфеля от времени за 2 последних года /shares/{id}
    6. Удалять акцию из списка

Затрачено времени:

    Делал с перерывами, так как сейчас много работы. В перерывах между делами читал документацию,
    в целом потрачено часов 7 на создание сайта, так как с данным фреймворком я ранее фактически не работал.

    Пункты 1 и 2 - с них я начал, затрачено 3 часа, так как попутно разбирался с особенностями фреймворка

    Пункты 3,4,6 - основной каркас бандла shares сгенерирован автоматически через консоль, дальше были незначительные правки + создание шаблона.
    На данные пункты потрачено примерно 2 часа.

    Пункт 5 - затрачен час. Получить методы для работы с Yahoo Finance и понять их было крайне просто, основное время было затрачено на создание обертки
        и немного на подключение генератора графиков.

    Остальное время потрачено на проверку корректности работы сайта.


