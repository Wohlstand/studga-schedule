CREATE TABLE `mstuca_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `title` varchar(255) DEFAULT '',
  `title_2` varchar(255) DEFAULT '',
  `title_3` varchar(255) DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=4096;

CREATE TABLE `mstuca_sessions` (
  `username` varchar(20) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Логин',
  `session_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'MD5-хэшики',
  `ip` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'IPv4 IPv6',
  `useragent` varchar(1024) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Браузер',
  `session_timestart` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Время начала сессии',
  `loghash` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Хэш суммы логина и пароля',
  PRIMARY KEY (`session_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AVG_ROW_LENGTH=204;

CREATE TABLE `mstuca_users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Счётчик',
  `username` varchar(255) NOT NULL COMMENT 'Имя пользователя',
  `password` varchar(255) DEFAULT NULL COMMENT 'Хэш пароля 1',
  `password_c` varchar(255) DEFAULT NULL COMMENT 'Хэш пароля 2',
  `password_u` varchar(255) DEFAULT NULL COMMENT 'Пароль, зашифрованный функцией PASSWORD()',
  `password_n` varchar(255) DEFAULT NULL COMMENT 'Незашифрованный пароль, нужен для служб, проверяющих пароль напрямую',
  `crypto` varchar(255) NOT NULL DEFAULT 'SHA1' COMMENT 'Алгоритм шифрования (MD5 или SHA1)',
  `grp` int(11) NOT NULL DEFAULT '0' COMMENT 'Групповые привелегии',
  `email` varchar(255) DEFAULT NULL COMMENT 'Запасной e-mail',
  `firstname` varchar(255) DEFAULT NULL COMMENT 'Имя',
  `firstname_hide` int(1) unsigned zerofill DEFAULT '0',
  `lastname` varchar(255) DEFAULT NULL COMMENT 'Фамилия',
  `lastname_hide` int(10) unsigned zerofill DEFAULT '0000000000',
  `nickname` varchar(255) DEFAULT NULL COMMENT 'Ник пользователя',
  `birth` date DEFAULT NULL COMMENT 'Дата рождения',
  `birth_s` int(1) DEFAULT '0' COMMENT 'Параметр показа своей даты рождения',
  `city` varchar(255) DEFAULT NULL,
  `photo` varchar(1024) NOT NULL DEFAULT '' COMMENT 'Код фотографии y_xxxxxx.ext',
  `dateofreg` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Дата регистрации',
  `checked` int(1) DEFAULT '0' COMMENT 'Проверен свежесозданный аккаунт?',
  `country` varchar(255) DEFAULT NULL,
  `lector` int(100) unsigned DEFAULT '0' COMMENT 'Привязка к преподавателю',
  `flow` int(100) unsigned DEFAULT '0' COMMENT 'Привязка к потоку',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=1260;

CREATE TABLE `news_feed` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `title` varchar(1024) NOT NULL,
  `content` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

CREATE TABLE `pages` (
  `id` int(99) NOT NULL,
  `mass` int(4) unsigned zerofill DEFAULT '0000',
  `book` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `section` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `page_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `page_title` varchar(1024) COLLATE utf8_unicode_ci DEFAULT '',
  `page_data` text COLLATE utf8_unicode_ci,
  `main` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AVG_ROW_LENGTH=12288;

CREATE TABLE `pages_books` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `book_name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `book_title` varchar(1024) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AVG_ROW_LENGTH=16384;

CREATE TABLE `schedule_daycount` (
  `id_day` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Семестры. Указывает начало отсчёта чёт/нечёт-а',
  `couples` int(1) unsigned DEFAULT '0' COMMENT 'Чёт-1/нечёт0 первой недели',
  `daystart` date DEFAULT NULL COMMENT 'День начала семестра',
  `dayend` date DEFAULT NULL COMMENT 'Дата окончания семестра',
  `desc` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_day`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=16384;

CREATE TABLE `schedule_disciplyne` (
  `id_disciplyne` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `dysc_name` varchar(255) DEFAULT NULL COMMENT 'Название предмета',
  PRIMARY KEY (`id_disciplyne`)
) ENGINE=InnoDB AUTO_INCREMENT=1508 DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=2340;

INSERT INTO `schedule_disciplyne` (`id_disciplyne`,`dysc_name`) VALUES
('0', '*Отменяется*');

CREATE TABLE `schedule_facult` (
  `id_facult` int(99) NOT NULL AUTO_INCREMENT,
  `fac_name` varchar(255) DEFAULT NULL COMMENT 'Полное название факультета',
  `fac_name_s` varchar(255) DEFAULT NULL COMMENT 'Абравиатура',
  `fac_dean` int(11) DEFAULT NULL COMMENT 'Декан',
  `fac_dean_tel` varchar(255) DEFAULT NULL COMMENT 'телефон декана',
  `fac_depdean` int(11) DEFAULT NULL,
  `fac_meth_tel` varchar(255) DEFAULT NULL COMMENT 'телефон методистов',
  `fac_deanrooms` varchar(255) DEFAULT NULL COMMENT 'массив - комнаты деканата',
  `fac_desc` text COMMENT 'Описание факультета',
  `fac_gr_names` varchar(255) DEFAULT NULL COMMENT 'Список имён групп',
  PRIMARY KEY (`id_facult`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

INSERT INTO `schedule_facult` (`id_facult`,`fac_name`,`fac_name_s`,`fac_dean`,`fac_dean_tel`,`fac_depdean`,`fac_meth_tel`,`fac_deanrooms`,`fac_desc`,`fac_gr_names`) VALUES
(1,'Механический факультет','М',NULL,NULL,NULL,NULL,NULL,NULL,'\"АБ\" \"АБб\" \"М\" \"Мб\" \"БТП\" \"БТПб\" \"ГСМ\" \"МАГ\" \"МБ\" \"МБб\" \"МГ\" \"МГб\" \"МАГб\" \"ММаг\" \"ЭВС\" \"ЭВСм\"'),
(2,'Факультет авиационных систем и комплексов','ФАСК',NULL,NULL,NULL,NULL,NULL,'','\"АК\" \"АКб\" \"РС\" \"РСб\" \"РТ\" \"РТб\" \"АКМаг\" \"ЭВСак\"'),
(3,'Факультет прикладной математики и вычислительной техники','ФПМиВТ',18,NULL,2,NULL,NULL,NULL,'\"ЭВМ\" \"ЭВМб\" \"БИ\" \"БИб\" \"ПМ\" \"ПМб\" \"БИТ\" \"БИТб\"'),
(4,'Факультет управления на воздушном транспорте','ФУВТ',NULL,NULL,NULL,NULL,NULL,NULL,'\"ОП\" \"ОПБ\" \"ОПб\" \"ОБП\" \"ОБПб\" \"ОПбЭС\" \"СО\" \"СОб\" \"УВД\" \"УВДб\" \"УВДБ\" \"ЭК\" \"ЭКб\" \"ЭКБ\" \"ЭКБб\"'),
(5,'Заочный факультет','ЗФ',NULL,NULL,NULL,NULL,NULL,NULL,'\"АКЗб\" \"МЗб\" \"РТз\"');

CREATE TABLE `schedule_facult_spec` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `fac_id` int(11) NOT NULL,
  `spec_name` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8 COMMENT='Специальности по факультетам';

INSERT INTO `schedule_facult_spec` (`id`,`fac_id`,`spec_name`) VALUES
(1,1,'АБ'),
(2,1,'АБб'),
(3,1,'М'),
(4,1,'Мб'),
(5,1,'БТП'),
(6,1,'БТПб'),
(7,1,'ГСМ'),
(8,1,'МАГ'),
(9,1,'МБ'),
(10,1,'МБб'),
(11,1,'МГ'),
(12,1,'МГб'),
(13,1,'МАГб'),
(14,1,'ММаг'),
(15,1,'ЭВС'),
(16,1,'ЭВСм'),
(17,2,'АК'),
(18,2,'АКб'),
(19,2,'РС'),
(20,2,'РСб'),
(21,2,'РТ'),
(22,2,'РТб'),
(23,2,'АКМаг'),
(24,2,'ЭВСак'),
(25,3,'ЭВМ'),
(26,3,'ЭВМб'),
(27,3,'БИ'),
(28,3,'БИб'),
(29,3,'ПМ'),
(30,3,'ПМб'),
(31,3,'БИТ'),
(32,3,'БИТб'),
(33,4,'ОП'),
(34,4,'ОПБ'),
(35,4,'ОПб'),
(36,4,'ОБП'),
(37,4,'ОБПб'),
(38,4,'ОПбЭС'),
(39,4,'СО'),
(40,4,'СОб'),
(41,4,'УВД'),
(42,4,'УВДб'),
(43,4,'УВДБ'),
(44,4,'ЭК'),
(45,4,'ЭКб'),
(46,4,'ЭКБ'),
(47,4,'ЭКБб'),
(48,5,'АКЗб'),
(49,5,'МЗб'),
(50,5,'РТз');

CREATE TABLE `schedule_files` (
  `filename` varchar(255) NOT NULL,
  `hash` varchar(255) DEFAULT NULL,
  `last_mod` varchar(255) DEFAULT '',
  `flow` int(99) DEFAULT '0',
  `group` int(11) DEFAULT '0',
  `deleted` tinyint(1) DEFAULT '0',
  `synonym` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`filename`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `schedule_flows` (
  `id_flow` int(11) NOT NULL AUTO_INCREMENT,
  `id_courator` varchar(255) DEFAULT NULL COMMENT 'Кураторы групп',
  `gr_name` varchar(10) DEFAULT NULL COMMENT 'Специальность',
  `gr_year-start` year(4) DEFAULT NULL COMMENT 'Год первого курса',
  `gr_year-end` year(4) DEFAULT NULL COMMENT 'Год выпуска',
  `id_facult` int(99) DEFAULT NULL COMMENT 'Факультет',
  `id_prof` int(99) DEFAULT NULL,
  `group_q` tinyint(4) DEFAULT '2' COMMENT 'Количество групп',
  `is_updating` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Флаг процесса обновления расписания',
  `latest_upd` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Последнее обновление базы данных',
  PRIMARY KEY (`id_flow`)
) ENGINE=InnoDB AUTO_INCREMENT=220 DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=8192;

CREATE TABLE `schedule_houses` (
  `id_house` int(29) NOT NULL AUTO_INCREMENT,
  `house_name` varchar(255) NOT NULL,
  PRIMARY KEY (`id_house`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

INSERT INTO `schedule_houses` (`id_house`,`house_name`) VALUES
(1,'Первый корпус'),
(2,'Второй корпус'),
(3,'Третий корпус'),
(4,'Четвёртый корпус'),
(5,'Пятый корпус'),
(6,'Главный \"Новый\" корпус'),
(7,'Учебный Авиационно-Технический Центр МГТУ ГА'),
(8,'УБЭРТОС'),
(0,'(Не определён)');

CREATE TABLE `schedule_lectors` (
  `id_lector` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `lcr_fullname` varchar(255) DEFAULT NULL COMMENT 'Полное имя преподавателя',
  `lcr_shtname` varchar(255) DEFAULT NULL COMMENT 'Фамилия и инициалы преподавателя',
  `lcr_rank-l` varchar(255) DEFAULT NULL COMMENT 'Учёная степень',
  `lcr_rank-sc` varchar(255) DEFAULT NULL COMMENT 'Учёное звание',
  `lcr_photo` varchar(255) DEFAULT NULL COMMENT 'Фотография преподавателя',
  `lcr_birthday` date DEFAULT NULL COMMENT 'Дата рождения преподавателя',
  `lcr_offsite` text COMMENT 'Официальный сайт преподавателя',
  PRIMARY KEY (`id_lector`),
  KEY `id_lector` (`id_lector`)
) ENGINE=InnoDB AUTO_INCREMENT=590 DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=5461;

CREATE TABLE `schedule_links` (
  `id` int(99) NOT NULL AUTO_INCREMENT,
  `link` varchar(2048) DEFAULT NULL,
  `descr` text,
  `synonym` varchar(255) DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=502 DEFAULT CHARSET=utf8;

CREATE TABLE `schedule_ltype` (
  `id_ltype` int(11) NOT NULL AUTO_INCREMENT,
  `lt_name` varchar(255) DEFAULT NULL,
  `lt_name_sh` varchar(50) DEFAULT '',
  PRIMARY KEY (`id_ltype`),
  KEY `id_ltype` (`id_ltype`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=5461;

INSERT INTO `schedule_ltype` (`id_ltype`,`lt_name`,`lt_name_sh`) VALUES
(0,'*Отмена занятия*','*Отмена занятия*'),
(1,'Лекция','Лекция'),
(2,'Практическое занятие','Пр.Зан.'),
(3,'Лабораторная работа','Лаб.раб.'),
(4,'Спорт','Спорт'),
(5,'Зачёт','Зачёт'),
(6,'Диффиренциальный зачёт','Дифф.Зачёт'),
(7,'Консультация','Консультация'),
(8,'Экзамен','Экзамен'),
(9,'Семинар','Семинар'),
(10,'Час наставника','Час наставника'),
(11,'Зачёт / Диф.зачёт','Зачет(диф.зач.)'),
(12,'Защита КП(КР)','Защита КП(КР)');

CREATE TABLE `schedule_profs` (
  `id_prof` int(99) NOT NULL AUTO_INCREMENT,
  `prof_name` varchar(255) DEFAULT NULL COMMENT 'Название специальности',
  `prof_shname` varchar(10) DEFAULT NULL COMMENT 'Абравиатура специальности',
  `prof_grmane` varchar(255) DEFAULT NULL,
  `prof_number` int(11) DEFAULT NULL COMMENT 'Код специальности',
  `id_facule` int(99) DEFAULT NULL,
  `prof_desc` text COMMENT 'Описание специальности',
  PRIMARY KEY (`id_prof`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='Специальности';

CREATE TABLE `schedule_rooms` (
  `id_room` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Комнаты, аудитории, где проходят занятия',
  `room_number` varchar(255) DEFAULT NULL COMMENT 'Номер корпуса',
  `id_house` int(48) DEFAULT NULL COMMENT 'Корпус',
  `room_stage` int(11) DEFAULT NULL,
  `room_desc` varchar(255) DEFAULT NULL COMMENT 'Краткое описание аудитории',
  `room_220v` text COMMENT 'Наличие рабочих розеток 220v',
  `room_photo` varchar(255) DEFAULT NULL COMMENT 'Фотография из аудитории',
  PRIMARY KEY (`id_room`)
) ENGINE=InnoDB AUTO_INCREMENT=277 DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=780;

CREATE TABLE `schedule_students` (
  `id_student` int(11) NOT NULL AUTO_INCREMENT,
  `id_group` int(11) DEFAULT NULL,
  `id_subgrp_e` int(11) DEFAULT NULL,
  `id_sungrp_l` int(11) DEFAULT NULL,
  `st_fullname` varchar(255) DEFAULT NULL COMMENT 'ФИО студента',
  `st_birthday` date DEFAULT NULL COMMENT 'Дата рождения',
  `st_birthcity` varchar(255) DEFAULT NULL COMMENT 'Родной город',
  `st_hostel` int(1) DEFAULT '0' COMMENT 'Общежитие?',
  `st_photo` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_student`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=16384;

CREATE TABLE `schedule_subgroups` (
  `id_subgroup` int(11) NOT NULL AUTO_INCREMENT,
  `id_group` varchar(255) DEFAULT NULL,
  `sgr_type` varchar(1) DEFAULT NULL COMMENT 'E или L (Английский или лабораторные)',
  `sgr_number` int(2) NOT NULL,
  PRIMARY KEY (`id_subgroup`),
  KEY `id_subgroup` (`id_subgroup`),
  KEY `id_group` (`id_group`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=2048;

CREATE TABLE `schedule_ver` (
  `DateOfVer` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `version` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL COMMENT 'Alhpa, Beta, Unstable, Stable',
  `descr` text,
  `visible` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`DateOfVer`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `sent_info` (
  `id` int(100) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(255) DEFAULT NULL,
  `object_id` int(100) unsigned DEFAULT NULL,
  `info1` varchar(1024) DEFAULT NULL,
  `info2` varchar(1024) DEFAULT NULL,
  `info3` varchar(1024) DEFAULT NULL,
  `comment` text,
  `ip` varchar(255) DEFAULT NULL,
  `useragent` varchar(2048) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8;


DELIMITER $$
CREATE  PROCEDURE `Flows_ClearEmpties`()
    NO SQL
    COMMENT 'Удаляет пустые потоки, у которых нет расписаний'
DELETE FROM `schedule_flows` WHERE id_flow NOT IN (SELECT id_flow FROM `schedule__maindata` WHERE `schedule__maindata`.id_flow=`schedule_flows`.id_flow)$$
DELIMITER ;

DELIMITER $$
CREATE  PROCEDURE `Flows_CountEmpties`()
    NO SQL
    COMMENT 'Показывает количество потоков без расписаний'
SELECT count(*) FROM `schedule_flows` WHERE id_flow NOT IN (SELECT id_flow FROM `schedule__maindata` WHERE `schedule__maindata`.id_flow=`schedule_flows`.id_flow)$$
DELIMITER ;

DELIMITER $$
CREATE  PROCEDURE `Flows_CountReal`()
    NO SQL
    COMMENT 'Показывает количетсво непустых потоков'
SELECT count(*) FROM `schedule_flows` WHERE id_flow IN (SELECT id_flow FROM `schedule__maindata` WHERE `schedule__maindata`.id_flow=`schedule_flows`.id_flow)$$
DELIMITER ;

CREATE TABLE `schedule__maindata` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_disciplyne` int(11) unsigned DEFAULT NULL COMMENT 'Название предмета',
  `id_lector` int(11) unsigned DEFAULT NULL COMMENT 'Преподаватель',
  `id_flow` int(11) DEFAULT NULL COMMENT 'Поток',
  `id_group` varchar(255) DEFAULT NULL COMMENT 'Массив: делитель - пробел. Группа, для которой проводится занятие',
  `id_subgrp` varchar(255) DEFAULT '' COMMENT 'Массив: L000 - ID подгруппы лабораторных E000 - ID подгруппы английского',
  `id_day` int(11) unsigned DEFAULT NULL COMMENT 'Семестр',
  `id_ltype` int(11) unsigned DEFAULT NULL COMMENT 'Вид занятия',
  `issubgrp` int(1) unsigned NOT NULL DEFAULT '0' COMMENT 'Это занятие одной из подгрупп или всей группы?',
  `id_room` int(11) unsigned DEFAULT NULL COMMENT 'Аудитория проведения занятия',
  `diration` int(1) NOT NULL DEFAULT '1' COMMENT 'Повтор занятия (число пар)',
  `lection` int(1) DEFAULT '0' COMMENT 'Номер пары (1,2,3,4,5,6,7)',
  `period-start` date DEFAULT NULL COMMENT 'Период проведения занятия',
  `period-end` date DEFAULT NULL,
  `exceptions` varchar(255) DEFAULT NULL COMMENT 'Массив дат, в которые занятие не проводится',
  `weekday` int(1) DEFAULT NULL COMMENT 'День недели записи занятия',
  `onlydays` varchar(255) DEFAULT NULL COMMENT 'Массив: Конкретные даты, в которые будет проводится занятие',
  `couples` int(1) DEFAULT '0' COMMENT '0 - любой день; 1 - только чётные; 2 - только нечётные',
  `exam_time` varchar(6) DEFAULT NULL,
  `change` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `change_time` timestamp NULL DEFAULT NULL,
  `change_user` int(99) DEFAULT NULL,
  `change_reason` text,
  PRIMARY KEY (`id`),
  KEY `id_disciplyne` (`id_disciplyne`),
  KEY `id_room` (`id_room`),
  KEY `id_day` (`id_day`),
  KEY `id_group` (`id_group`),
  KEY `id_subgrp` (`id_subgrp`),
  KEY `period` (`period-start`,`period-end`),
  KEY `weekday` (`weekday`),
  KEY `onlydays` (`onlydays`),
  KEY `couples` (`couples`),
  CONSTRAINT `id_disciplyne` FOREIGN KEY (`id_disciplyne`) REFERENCES `schedule_disciplyne` (`id_disciplyne`)
) ENGINE=InnoDB AUTO_INCREMENT=17584 DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=1820;

