-- MySQL dump 10.16  Distrib 10.1.44-MariaDB, for debian-linux-gnu (x86_64)
--
-- ------------------------------------------------------
-- Server version	10.0.38-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Dumping data for table `schedule_ver`
--

LOCK TABLES `schedule_ver` WRITE;
/*!40000 ALTER TABLE `schedule_ver` DISABLE KEYS */;
INSERT INTO `schedule_ver` VALUES ('2013-04-02 20:00:00','0.1.0','pre-alpha','<ul>\r\n<li>Первый публичный релиз, содержащий в себе тестовые образцы расписания для потока двух групп ЭВМ 2010-2015.</li>\r\n</ul>',1),('2013-04-13 20:00:00','0.1.1','pre-alpha','<ul>\r\n<li>Оптимизация, добавление возможности смотреть подробности по выбранному занятию (преподаватель, аудитория, корпус, периодичность занятия)</li>\r\n<li>Создан раздел для преподавателей</li>\r\n<li>Создана мобильная версия, выводящая расписание по одному дню с функцией перелистывания по дням</li>\r\n<li>Создан раздел для вывода расписания, вызываемый кликом по ячейке с датой в таблице развёрнутого расписания</li>\r\n<li>Проект был представлен на студенческой научной конференции 17 апреля 2013-го года, посвящённой 90-летию гражданской авиации.\r\nВсе предварительные данные набирались в базу данных вручную.</li>\r\n</ul>',1),('2013-08-09 20:00:00','0.2.0','pre-alpha','<ul>\r\n<li>Реализован автомат считывания данных напрямую с Excel-файла с официальным расписанием</li>\r\n<li>Составлен почти полный список преподавателей, аудиторий и существующих студенчеких потоков на основе считанной с Excel-файлов информации</li>\r\n<li>Возможность открыть ежедневную карточку расписания непосредственно со страницы выбора группы</li>\r\n<li>Исправлены ошибки с подгруппами \"ин-яз\"</li>\r\n<li>Исправлены ошибки с выводом совпадающих занятий у разных групп на странице преподавателя</li>\r\n<li>Создание \"умной\" формы, которая не даст возможности выбрать подгруппу, для которой не существует расписания</li>\r\n<li>При отсуствии актуального расписания на выбранную группу вместо пустой таблицы будет выводится старое расписание</li>\r\n</ul>',1),('2013-08-21 19:45:16','0.2.3','aplha','<ul>\r\n<li>Добавлена возможность быстрого доступа к последнему расписанию за счёт использования cookies</li>\r\n<li>Начиная с 16 августа 2013, система в полном автоматическом режиме скачивает обновления расписаний и обновляет данные. Скрипты выполняют свою работу каждый день, в 20:00 часов</li>\r\n<li>Добавлен быстрый переход к определённому дню в листочке на день</li>\r\n<li>Исправлены ошибки с отображением преподавательских расписаний</li>\r\n<li>Добавлена версия для печати развёрнутого расписания - можно распечатать развёрнутое расписание полностью, аккуратно и качественно</li>\r\n<li>Возможность скачать оригинальный Excel-файл, с которого было прочитано расписание</li>\r\n<li>Устранена запись в Cookies данных несуществующих расписаний, при открытии которых выводится соответствующее уведомление</li>\r\n<li>Добавлен стилизованный вывод сообщений об ошибках</li>\r\n<li>Исправлена ошибка вывода расписаний без подгрупп в мобильной версии</li>\r\n<li>Исправлена ошибка, из-за которой неправильно расшифровывалось имя группы из имени файла, где были поставлены лишние пробелы</li>\r\n<li>Улучшена работа мобильной версии, особенно на медленных соединениях</li>\r\n</ul>',1),('2013-08-27 14:50:59','0.2.4','aplha','<ul>\r\n<li>Улучшен дизайн</li>\r\n<li>Исправлены ошибки с Coockie на мобильной версии</li>\r\n<li>Добавлен быстрый переход к определённому дню на мобильной версии</li>\r\n<li>Улучшена надёжность процесса самообновления расписаний</li>\r\n<li>В развёрнутом расписании, столбцы шестой и седьмой пар не выводятся вообще, если в расписании у потока нет шестых/седьмых пар</li>\r\n<li>Быстрые ссылки - список прямых ссылок на расписания выбранного потока. Облегчает доступ к нужному расписанию из различных публикаций в интернете, минуя страницу выбора группы/подгруппы</li>\r\n<li>Ссылки \"Версия для печати\" и \"Скачать оригинальный Excel-файл\" теперь и в \"листочке на день\"</li>\r\n<li>Добавлена помощь по выбору своей группы для первокурсников, не знакомых с системой именования групп</li>\r\n<li>Добавлена мобильная версия страницы \"О проекте\". Теперь можно читать информацию о проекте не перключаясь в полную версию сайта</li>\r\n<li>Автопереход к выбранному в календаре дню, без необходимости нажимать кнопку \"Go!\"</li>\r\n<li>Исправлена недоработка с тремя и более подгруппами, до этого был максимум две подгруппы, теперь все подгруппы, если их больше, будут прочитаны</li>\r\n</ul>',1),('2013-09-04 09:47:32','0.2.5','aplha','<ul>\r\n<li>Исправлен вывод поправок в карточках на день</li>\r\n<li>Исправлен вывод карточки на день для преподавателя: теперь если у преподавателя есть занятие у нескольких групп, то выводится по принципу \"одно занятие - одна ячейка\", при наличии нескольких групп, выводится список групп</li>\r\n<li>Добавлена форма обратной связи</li>\r\n<li>Устранена уязвимость, которая позволяла злоумышленнику проводить SQL и XSS-инъекции на страницах с расписанием</li>\r\n<li>Добавлена страница информации о выбранном занятии для мобильной версии</li>\r\n<li>Улучшено качество обработки файлов с неправильными именами файлов (например файл с именем \"БТП (АБ 4-1).xls\" будет загружен как \"АБ 4-1.xls\")</li>\r\n</ul>',1),('2013-09-24 20:29:14','0.2.6','aplha','<ul>\r\n<li>Исправлена серьёзная ошибка, возникающая при считывании \"Часов наставника\" из расписаний</li>\r\n<li>Даты теперь выводятся в более удобночитаемой форме (ДД Мес ГГГГ) вместо ГГГГ-ММ-ДД</li>\r\n</ul>',1),('2013-12-14 19:16:31','0.2.7','aplha','<ul>\r\n<li>Добавлено мобильное расписание для преподавателей. Теперь расписание преподавателя доступно и со смартфона</li>\r\n<li>Добавлена возможность пользователей отправлять недостающую или обновлённую информацию о преподавателях и аудиториях непосредственно через окно подробной информации о занятии</li>\r\n</ul>',1),('2014-08-27 20:19:02','0.2.8','aplha','<ul>\r\n<li>Исправлен баг сепаратора, который неверно распределял расписания (часть занятий были записаны в весенный семестр)</li>\r\n<li>Экспериментальный раздел по аудиториям, доступный по адресу http://sd.studga.ru/d/chroom (доступно только настольное/развёрнутое расписание)</li>\r\n</ul>',1),('2018-02-26 03:43:45','0.3.0','alpha','<ul>\r\n<li>Демон-сортировщик был полностью переписан на с нуля (на С++ вместо PHP).</li>\r\n<ul>\r\n<li>Поддержка точной проверки правильности данных</li>\r\n<li>Сверх-скорость процесса полной перезаписи базы данных расписания</li>\r\n<li>Повышена безопасность и стабильность за счёт предварительных проверок данных приходящих файлов.</li>\r\n<li>Добавлена папка для складывания в неё подозрительных или неверных файлов для возможности ручного анализа</li>\r\n</ul>\r\n<li>В коде больше не используется устаревший плагин mysql в пользу плагина mysqli</li>\r\n</ul>\r\n',1),('2018-03-04 22:55:28','0.3.1','alpha','<ul>\r\n<li>Обновлена капча на всех формах, теперь она больше не будет глючит</li>\r\n<li>Заменён SMTP-клиент</li>\r\n</ul>\r\n',0),('2018-03-04 22:55:35','0.3.1','alpha','<ul>\r\n<li>Обновлена капча на всех формах, теперь она больше не будет глючить</li>\r\n<li>Заменён SMTP-клиент</li>\r\n</ul>\r\n',1);
/*!40000 ALTER TABLE `schedule_ver` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-08-01 13:19:34
