-- phpMyAdmin SQL Dump
-- version 3.3.2deb1
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Июн 04 2010 г., 19:01
-- Версия сервера: 5.1.41
-- Версия PHP: 5.3.2-1ubuntu4.2

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `pma`
--

-- --------------------------------------------------------

--
-- Структура таблицы `Admins`
--

CREATE TABLE IF NOT EXISTS `Admins` (
  `ID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `User_ID` int(11) unsigned NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `User_ID` (`User_ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `Admins`
--

INSERT INTO `Admins` (`ID`, `User_ID`) VALUES
(1, 1),
(2, 2);

-- --------------------------------------------------------

--
-- Структура таблицы `CalendarMessage`
--

CREATE TABLE IF NOT EXISTS `CalendarMessage` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `From` int(11) NOT NULL,
  `To` int(11) NOT NULL,
  `Date` date NOT NULL,
  `Message_ID` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Дамп данных таблицы `CalendarMessage`
--

INSERT INTO `CalendarMessage` (`ID`, `From`, `To`, `Date`, `Message_ID`) VALUES
(1, 1, 1, '0000-00-00', 3),
(2, 1, 1, '0000-00-00', 4),
(3, 1, 1, '0000-00-00', 5),
(4, 1, 1, '2010-05-06', 6),
(5, 1, 1, '2010-06-14', 7),
(6, 1, 1, '2010-05-16', 8),
(7, 1, 1, '2010-05-09', 9),
(8, 1, 1, '2010-05-16', 10),
(9, 1, 1, '2010-06-19', 11),
(10, 4, 1, '2010-05-17', 1),
(11, 1, 1, '2010-05-17', 12),
(12, 1, 1, '2010-05-17', 2),
(13, 1, 1, '2010-05-16', 2),
(14, 1, 1, '2010-05-16', 2),
(15, 4, 1, '2010-05-22', 2),
(16, 1, 1, '2010-05-05', 13),
(17, 1, 1, '2010-06-01', 14);

-- --------------------------------------------------------

--
-- Структура таблицы `configs`
--

CREATE TABLE IF NOT EXISTS `configs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key` varchar(40) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `value` varchar(40) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Дамп данных таблицы `configs`
--

INSERT INTO `configs` (`id`, `key`, `value`) VALUES
(1, 'language_default', 'ua'),
(2, 'languages', 'ua||ru||en||'),
(3, 'message_per_page', '5'),
(4, 'new_news', '5'),
(5, 'quotes_count', '1');

-- --------------------------------------------------------

--
-- Структура таблицы `Files`
--

CREATE TABLE IF NOT EXISTS `Files` (
  `ID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `Title` varchar(20) CHARACTER SET utf8 NOT NULL,
  `Filepath` varchar(80) CHARACTER SET utf8 NOT NULL,
  `Master` int(11) NOT NULL,
  `Date` date NOT NULL,
  `Semester` int(5) NOT NULL,
  `Description` text CHARACTER SET utf8 NOT NULL,
  `Subject_ID` int(10) unsigned NOT NULL,
  `Cover` varchar(80) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `Subject_ID` (`Subject_ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Дамп данных таблицы `Files`
--

INSERT INTO `Files` (`ID`, `Title`, `Filepath`, `Master`, `Date`, `Semester`, `Description`, `Subject_ID`, `Cover`) VALUES
(4, 'test', 'static/uploaded/files/oop.zip', 1, '2010-04-16', 4, '1', 3, 'static/uploaded/covers/ineedokulist1.jpg'),
(5, 'rew', 'static/uploaded/files/oop0.zip', 1, '2010-04-19', 1, '1', 1, 'static/uploaded/covers/'),
(6, 'rew', 'static/uploaded/files/oop1.zip', 1, '2010-04-19', 1, '1', 1, 'static/uploaded/covers/'),
(7, 'test', 'static/uploaded/files/pptp_vpn_configure.zip', 1, '2010-05-03', 1, '1', 1, 'static/uploaded/covers/img_close.gif'),
(8, 'qwerty', 'static/uploaded/files/pptp_vpn_configure0.zip', 1, '2010-05-03', 1, '1', 1, 'static/uploaded/covers/firefox.png'),
(9, 'sss', 'static/uploaded/files/ckeditor_3.0.2.tar.gz', 1, '2010-05-03', 1, '1', 1, 'static/uploaded/covers/img_close0.gif'),
(10, 'testtets', 'static/uploaded/files/pptp_vpn_configure1.zip', 1, '2010-05-10', 5, '1', 2, 'static/uploaded/covers/firefox0.png');

-- --------------------------------------------------------

--
-- Структура таблицы `Groups`
--

CREATE TABLE IF NOT EXISTS `Groups` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Title` varchar(6) NOT NULL,
  `Course` date NOT NULL,
  `Sheduler_Path` varchar(30) NOT NULL,
  `Extranumeral` tinyint(1) NOT NULL,
  `SP` varchar(100) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Дамп данных таблицы `Groups`
--

INSERT INTO `Groups` (`ID`, `Title`, `Course`, `Sheduler_Path`, `Extranumeral`, `SP`) VALUES
(1, 'KM-72', '2007-09-01', '', 0, '1 1||2 1||3 1'),
(2, 'KM-73', '2007-09-01', '', 0, '1 1||2 2||3 1||4 1'),
(3, 'КМ-71', '2010-06-02', '', 0, '1 1||2 1||3 1');

-- --------------------------------------------------------

--
-- Структура таблицы `Message`
--

CREATE TABLE IF NOT EXISTS `Message` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Whom` int(10) unsigned NOT NULL,
  `From` int(10) unsigned NOT NULL,
  `Date_Create` date NOT NULL,
  `Date_Delete` date NOT NULL,
  `Email` varchar(20) NOT NULL,
  `Flag` enum('s','r','n') NOT NULL,
  `Text_ID` int(10) NOT NULL,
  `Subject` text NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `Whom` (`Whom`,`From`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `Message`
--

INSERT INTO `Message` (`ID`, `Whom`, `From`, `Date_Create`, `Date_Delete`, `Email`, `Flag`, `Text_ID`, `Subject`) VALUES
(1, 1, 2, '2010-05-05', '2010-10-10', 'vanish.com@mail.ru', 's', 1, 'TEST'),
(2, 1, 2, '2010-05-05', '2010-05-28', 'vanish.com@mail.ru', 's', 2, 'testtetstest');

-- --------------------------------------------------------

--
-- Структура таблицы `MessageText`
--

CREATE TABLE IF NOT EXISTS `MessageText` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Text` text NOT NULL,
  `Subject` varchar(100) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- Дамп данных таблицы `MessageText`
--

INSERT INTO `MessageText` (`ID`, `Text`, `Subject`) VALUES
(1, 'testesttestesttestesttestesttestesttestesttestesttestesttestesttestesttestest', ''),
(2, 'Стабільний розвиток України неможливий без висококваліфікованих фахівців, що мають поглиблену підготовку в галузях застосування математичних методів до науково-технічних та виробничих задач, що володіють сучасними комп’ютерними технологіями та відповідними засобами, які дають змогу розробляти нові технології та методи розв’язку прикладних задач. Тому напрями наукової діяльності нашої кафедри спрямовані на вирішення проблем прикладної математики та інформатики, розробки математичного, програмного та технічного забезпечення нових інформаційних технологій. Наші студенти отримують підготовку високого рівня, що орієнтована на практичне використання математичних методів і засобів сучасних IT-технологій для вирішення широкого кола інженерних задач в галузях виробничої, господарчої, екологічної та економічної діяльності.\r\n\r\n', ''),
(3, 'vava', 'vava'),
(4, 'vavavav', 'vav'),
(5, 'test', 'test'),
(6, 'test', 'test'),
(7, 'sesion', 'sesion'),
(8, 'testtestsetsetsetetstststs', 'test'),
(9, 'dddddddddd', 'afdsfasdddddd'),
(10, 'dd', 'dd'),
(11, 'test', 'test'),
(12, 'test', 'test'),
(13, 'test', 'test'),
(14, 'fas', 'sfa');

-- --------------------------------------------------------

--
-- Структура таблицы `obj_comments`
--

CREATE TABLE IF NOT EXISTS `obj_comments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_post` int(10) unsigned NOT NULL,
  `id_user` int(10) unsigned NOT NULL,
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `text` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=35 ;

--
-- Дамп данных таблицы `obj_comments`
--

INSERT INTO `obj_comments` (`id`, `id_post`, `id_user`, `date`, `text`) VALUES
(15, 7, 1, '0000-00-00 00:00:00', 'Ура!!'),
(34, 7, 1, '2010-05-03 23:57:30', 'jkjk');

-- --------------------------------------------------------

--
-- Структура таблицы `obj_news`
--

CREATE TABLE IF NOT EXISTS `obj_news` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_user` int(10) unsigned NOT NULL,
  `title_ru` varchar(255) NOT NULL,
  `text_ru` text NOT NULL,
  `date` datetime NOT NULL,
  `date_edit` int(10) unsigned NOT NULL,
  `comments` enum('n','y') NOT NULL DEFAULT 'y',
  `active` enum('n','y') NOT NULL DEFAULT 'n',
  `comments_count` int(10) unsigned NOT NULL,
  `views` int(10) unsigned NOT NULL,
  `title_ua` varchar(255) NOT NULL,
  `text_ua` text NOT NULL,
  `title_en` varchar(255) NOT NULL,
  `text_en` text NOT NULL,
  `internal` enum('y','n') CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT 'n',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=24 ;

--
-- Дамп данных таблицы `obj_news`
--

INSERT INTO `obj_news` (`id`, `id_user`, `title_ru`, `text_ru`, `date`, `date_edit`, `comments`, `active`, `comments_count`, `views`, `title_ua`, `text_ua`, `title_en`, `text_en`, `internal`) VALUES
(7, 1, 'Запуск сайта', 'Сайт запущен в тестовом режиме', '2010-04-13 21:10:00', 1270499281, 'y', 'y', 2, 75, 'Запуск сайта', 'Сайт запущен&lt;br&gt;&lt;span style=&quot;color: rgb(204, 51, 0);&quot;&gt;в тестовом режиме&lt;/span&gt;', 'Site is running', 'Site running in test mo', 'n'),
(23, 1, 'test', 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa &lt;br&gt;', '2010-05-04 14:42:35', 0, 'y', 'y', 0, 0, 'test', '&amp;nbsp;aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', 'test', 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa &lt;br&gt;', 'n');

-- --------------------------------------------------------

--
-- Структура таблицы `obj_staticpages`
--

CREATE TABLE IF NOT EXISTS `obj_staticpages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_parent` int(10) unsigned NOT NULL,
  `position` int(10) unsigned NOT NULL,
  `title_ru` varchar(250) NOT NULL,
  `title_ua` varchar(250) NOT NULL,
  `title_en` varchar(250) NOT NULL,
  `text_ru` text NOT NULL,
  `text_ua` text NOT NULL,
  `text_en` text NOT NULL,
  `active` enum('n','y') NOT NULL,
  `hat` varchar(30) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `module` varchar(100) DEFAULT NULL,
  `menu` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=70 ;

--
-- Дамп данных таблицы `obj_staticpages`
--

INSERT INTO `obj_staticpages` (`id`, `id_parent`, `position`, `title_ru`, `title_ua`, `title_en`, `text_ru`, `text_ua`, `text_en`, `active`, `hat`, `module`, `menu`) VALUES
(1, 0, 1, 'Главная страница', 'Головна сторінка', 'Main page', 'Приветствуем Вас на сайте кафедры прикладной математики Национального  технического университета Украины &quot;Киевский политехнический институт&quot;!rnСтабильное развитие Украины невозможно без высококвалифицированных  специалистов, обладающих углублённой подготовкой в областях применения  математических методов к научно-техническим и производственным задачам,  владеющих современными компьютерными технологиями и соответствующими  средствами, позволяющими разрабатывать новые технологии и методы решения  прикладных задач. Поэтому направления научной деятельности нашей  кафедры направлены на решение проблем прикладной математики и  информатики, разработки математического, программного и технического  обеспечения новых информационных технологий.rnНаши студенты получают подготовку высокого уровня, ориентированную на  практическое использование математических методов и средства  современных ІТ-технологий для решения широкого круга инженерных задач в  областях производственной, хозяйственной, экологической и экономической  деятельности.rnНаши выпускники работают аналитиками и программистами:rnrnв информационных и аналитических отделах банков;rnв компьютерных отделах офисов фирм и предприятий;rnв научно-аналитических подразделениях СБУ, МВД, таможенной и  налоговой служб Украины;rnв научно-исследовательских институтах Национальной академии наук  Украины;rnв других государственных и частных учреждениях и предприятиях.rnrnНа сайте Вы сможете найти всю нужную информацию, а также сможете  присоединиться к активной гражданской жизни не выходя из собственного  жилья!rn&amp;nbsp;rnАдминистрация сайта ПМАrnrn', 'Вітаємо Вас на сайті кафедри прикладної математики Національного  технічного університету України «Київський політехнічний інститут»Стабільний розвиток України неможливий без висококваліфікованих  фахівців, що мають поглиблену підготовку в галузях застосування  математичних методів до науково-технічних та виробничих задач, що  володіють сучасними комп’ютерними технологіями та відповідними засобами,  які дають змогу розробляти нові технології та методи розв’язку  прикладних задач. Тому напрями наукової діяльності нашої кафедри  спрямовані на вирішення проблем прикладної математики та інформатики,  розробки математичного, програмного та технічного забезпечення нових  інформаційних технологій.rnНаші студенти отримують підготовку високого рівня, що орієнтована на  практичне використання математичних методів і засобів сучасних  IT-технологій для вирішення широкого кола інженерних задач в галузях  виробничої, господарчої, екологічної та економічної діяльності.rnНаші випускники працюють аналітиками і програмістами:rnrnв інформаційних та аналітичних відділах банків;rnу комп’ютерних відділах офісів фірм та підприємств;rnу науково-аналітичних підрозділах СБУ, МВС, митної та податкової  служб України;rn у науково-дослідницьких інститутах Національної академії наук  України;rnв інших державних та приватних установах та підприємствах.rnrnНа сайті Ви зможете знайти всю потрібну інформацію, а також зможете  долучитися до активного громадського життя не виходячи з власної  домівки!rn&amp;nbsp;rnАдміністрація сайту ПМАrnrn', 'Welcome to the website of the Applied Mathematics Department of the National Technical University of Ukraine &quot;Kyiv Polytechnic Institute&quot;!rnThe stable development of Ukraine is impossible without qualified specialists that possess the fundamental grounding necessary for implementing mathematical methods in scientific and industrial spheres. Such specialists are also capable of new computer technologies and appropriate means of developing new technologies and methods for solving real-life problems. That is why the scientific researches in our Department are mainly held in the fields of solving applied math and computer science problems, and developing the mathematical background, software and hardware for new information technologies.rnOur students gain a high-level grounding that is directed to the practical use of mathematical methods and means of modern IT for solving wide range if engineering problems in the fields of industrial, ecological and economical spheres.rnOur Alumni work as analysts and programmers:rnrnat information and analyst bank departments;rnat computer departments in firms and companies;rnat scientific and analytic departments of the SSU, MIF, custom and tax services of Ukraine;rnat scientific institutes of the National Academy of Science of Ukraine;rnat the other organizations, both state and private.rnrnYou can find all the important information here at the website. Also, you can join active social life even without living you very apartment!rn&amp;nbsp;rnPMA website administrationrnrn', 'y', 'main', NULL, '1'),
(60, 0, 9, 'Международная деятельность', 'Міжнародна діяльність', 'International', '', '', '', 'y', 'international', NULL, '60'),
(18, 5, 3, 'Выпускникам кафедры', 'Випускникам кафедри', 'Alumni List', '', '', '', 'y', 'abitur', NULL, '5'),
(4, 0, 100, 'Научная работа', 'Наукова робота', 'Research', '<p>TEXT of page 4 ru Bwahahahhaha!!!</p>', '<p>TEXT<em> of<span style="text-decoration: underline;"> pa<strong>ge 4<span style="text-decoration: line-through;"> ua TEXT o</span></strong></span></em></p>\r\n<p><em><span style="text-decoration: underline;"><strong><span style="text-decoration: line-through;">f page 4 ru Bwa</span>hah</strong>ahha</span></em>ha!!!</p>', '<p>TEXT of page 4 en</p>', 'y', 'science', NULL, '4'),
(5, 0, 2, 'Для абитуриентов', 'Для абітурієнтів', 'For entrants', 'Вssssssssssssітаємо Вас на сайті кафедри прикладної математики Національного технічного університету України «Київського політехнічного інституту».Стабільний розвиток України неможливий без висококваліфікованих фахівців, що мають поглиблену підготовку в галузях застосування математичних методів до науково-технічних та виробничих задач, що володіють сучасними комп’ютерними технологіями та відповідними засобами, які дають змогу розробляти нові технології та методи розв’язку прикладних задач. Тому напрями наукової діяльності нашої кафедри спрямовані на вирішення проблем прикладної математики та інформатики, розробки математичного, програмного та технічного забезпечення нових інформаційних технологій.Наші студенти отримують підготовку високого рівня, що орієнтована на практичне використання математичних методів і засобів сучасних IT-технологій для вирішення широкого кола інженерних задач в галузях виробничої, господарчої, екологічної та економічної діяльності.Наші випускники працюють аналітиками і програмістами:\r\n\r\nв інформаційних та аналітичних відділах банків;\r\nв комп’ютерних відділах офісів фірм та підприємств;\r\nв науково-аналітичних підрозділах СБУ, МВС, митної та податкової служб України;\r\nв науково-дослідницьких інститутах Національної академії наук України;\r\nв інших державних та недержавних установах та підприємствах.', 'TEdsssssssssssssssz&lt;br&gt;zzzzzzzzzzzzzzzzzzzz', 'TEXT of page 5 en', 'y', 'abitur', NULL, '5'),
(17, 5, 2, 'Заочное отделение', 'Заочне відділення', 'Сorrespondence department', '', '', '', 'y', 'abitur', NULL, '5'),
(7, 0, 3, 'Для студентов', 'Для студентів', '&quot;For students&quot;', 'TEXT of page 7 ru', '&quot;TEXT of page 7 ua adsf af asfasfasfaf af f adf kkkkkkkkkkkkkkkkkkkkkkkkk&quot;', 'TEXT of page 7 en', 'y', 'student', NULL, '7'),
(8, 7, 0, 'Списки групп', 'Списки груп', 'Groups lists', '<p>TEXT of page 8 ru</p>', '<p>TEXT of page 8 ua</p>', '<p>TEXT of page 8 en</p>', 'y', 'student', NULL, '7'),
(9, 8, 1, '1 курс', '1 курс', '1 course', '<p>TEXT of page 9 ru</p>', '<p>TEXT of page 9 ua</p>', '<p>TEXT of page 9 en</p>', 'y', 'student', NULL, '7'),
(23, 8, 4, '4 курс', '4 курс', '4 course', '', '', '', 'y', 'student', NULL, '7'),
(24, 8, 5, '5 курс', '5 курс', '5 course', '', '', '', 'y', 'student', NULL, '7'),
(11, 8, 2, '2 курс', '2 курс', '2 course', '<p>TEXT of page 11 ru</p>', '<p>TEXT of page 11 ua</p>', '<p>TEXT of page 11 en</p>', 'y', 'student', NULL, '7'),
(12, 0, 4, 'Про преподавателей', 'Про викладачів', 'About Lecturers', 'TEXT of page 12 ru', 'TEXT of page 12 ua', 'TEXT of page 12 en', 'y', 'prepod', NULL, '12'),
(13, 0, 3, 'Для выпускников', 'Для випускників', 'For Alumni', 'TEXT of page 13 ru', 'TEXT of page 13 ua', 'TEXT of page 13 en', 'y', 'free', NULL, '13'),
(16, 5, 1, 'Привала прийома', 'Правила прийому', 'Rules income', '&amp;nbsp;', '&amp;nbsp;', '&amp;nbsp;', 'y', 'abitur', NULL, '5'),
(22, 8, 3, '3 курс', '3 курс', '3 course', '', '', '', 'y', 'student', NULL, '7'),
(19, 5, 4, 'Карта КПИ', 'Мапа КПИ', 'KPI Map', '', '', '', 'y', 'abitur', NULL, '5'),
(25, 8, 6, '6 курс', '6 курс', '6 course', '', '', '', 'y', 'student', NULL, '7'),
(26, 7, 0, 'Расписание занятий', 'Розклад заннять', 'Schedule', '', '', '', 'y', 'student', NULL, '7'),
(27, 26, 0, 'Зачеты и экзамены', 'Заліки та екзамени', 'Tests and exams', '', '', '', 'y', 'student', NULL, '7'),
(28, 7, 0, 'Вспомогательные структуры', 'Допоміжні структури', 'Supporting structure', '', '', '', 'y', 'student', NULL, '7'),
(29, 28, 0, 'Поликлиника', 'Поліклініка', 'Policlinic', '', '', '', 'y', 'student', NULL, '7'),
(30, 28, 0, 'Библиотека', 'Бібліотека', 'Library', '', '', '', 'y', 'student', NULL, '7'),
(31, 28, 0, 'Банкоматы', 'Банкомати', 'ATMs', '', '', '', 'y', 'student', NULL, '7'),
(32, 28, 0, 'Аптеки', 'Аптеки', 'Pharmacies', '', '', '', 'y', 'student', NULL, '7'),
(33, 28, 0, 'Парикмахерские', 'Перукарні', 'Hairdresser`s', '&amp;nbsp;', '&lt;br&gt;', '&amp;nbsp;', 'y', 'student', NULL, '7'),
(34, 28, 0, 'Украинско-японский центр', 'Україно-японський центр', 'Ukraine-Japan Center', '', '', '', 'y', 'student', NULL, '7'),
(35, 7, 0, 'Общежитие', 'Гуртожиток', 'Hostel', '', '', '', 'y', 'student', NULL, '7'),
(36, 35, 0, 'Студенческий быт', 'Студентський побут', 'Student life', '', '', '', 'y', 'student', '', '7'),
(37, 35, 0, 'День посвящения в первокурсники', 'День посвяти першокурсників', 'The day of initiation of freshmen', '', '', '', 'y', 'student', NULL, '7'),
(38, 35, 0, 'Контактная информация', 'Контактна інформація', 'Contact', '', '', '', 'y', 'student', NULL, '7'),
(39, 7, 0, 'Студенческая жизнь', 'Студентське життя', 'Student life', '', '', '', 'y', 'student', NULL, '7'),
(40, 39, 0, 'Cтудсовет', 'Студрада', 'Student Council', '', '', '', 'y', 'student', NULL, '7'),
(41, 39, 0, 'Профсоюз', 'Профспілка', 'Professionalyny Union', '', '', '', 'y', 'student', '', '7'),
(42, 39, 0, 'Отдых', 'Відпочинок', 'Rest', '', '', '', 'y', 'student', NULL, '7'),
(43, 39, 0, 'Cпортивные секции', 'Спортивні секції', 'Sporting Section', '', '', '', 'y', 'student', NULL, '7'),
(44, 39, 0, 'Кружки', 'Кружки', 'Mugs', '', '', '', 'y', 'student', NULL, '7'),
(45, 7, 0, 'Официальные документы', 'Офіційні документи', 'Official Documents', '', '', '', 'y', 'student', NULL, '7'),
(47, 45, 0, 'Бакалаврам и магистрам', 'Бакалаврам та магістрам', 'Bachelors and masters', '', '', '', 'y', 'student', NULL, '7'),
(48, 45, 0, 'Заявления в деканат', 'Заяви до деканату', 'Statements in Deanery', '', '', '', 'y', 'student', NULL, '7'),
(49, 45, 0, 'Правила сдачи сессии', 'Правила здачі сесії', 'Terms of delivery session', '', '', '', 'y', 'student', NULL, '7'),
(50, 45, 0, 'Заседания кафедры', 'Засідання кафедри', 'Meetings Department', '', '', '', 'y', 'student', NULL, '7'),
(51, 45, 0, 'Военный институт', 'Військовий інститут', 'Military Institute', '', '', '', 'y', 'student', NULL, '7'),
(52, 45, 0, 'Успеваемость', 'Успішність', 'Progress', '', '', '', 'y', 'student', NULL, '7'),
(53, 45, 0, 'О заочниках', 'Про заочників', 'Of students by correspondence', '', '', '', 'y', 'student', NULL, '7'),
(54, 12, 0, 'Преподаватели', 'Викладачі', 'Teachers', '', '', '', 'y', 'prepod', NULL, '12'),
(55, 12, 0, 'Рейтинг преподавателей', 'Рейтинг викладачів', 'Rating Teachers', '', '', '', 'y', 'prepod', NULL, '12'),
(56, 12, 0, 'Учебные программы дисциплин', 'Навчальні програми дисциплін', 'Curriculum subjects', '', '', '', 'y', 'prepod', NULL, '12'),
(57, 12, 0, 'История кафедры', 'Історія кафедри', 'History Department', '', '', '', 'y', 'prepod', NULL, '12'),
(58, 13, 0, 'Списки групп', 'Списки групп', 'Groups Lists', '', '', '', 'y', 'free', NULL, '13'),
(59, 13, 0, 'Анкета для выпускников', 'Анкета для випускників', 'Questionnaire for graduates', '', '', '', 'y', 'free', NULL, '13');

-- --------------------------------------------------------

--
-- Структура таблицы `Professors`
--

CREATE TABLE IF NOT EXISTS `Professors` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `User_ID` int(10) unsigned NOT NULL,
  `Subjects` varchar(200) NOT NULL,
  `Lector` tinyint(1) NOT NULL,
  `University` varchar(100) NOT NULL,
  `Year_finish` date NOT NULL,
  `stepen` varchar(50) NOT NULL,
  `consultacii` varchar(100) NOT NULL,
  `sciense_interest` varchar(200) NOT NULL,
  `family` text NOT NULL,
  `work` text NOT NULL,
  `hoby` text NOT NULL,
  `animal` varchar(100) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `User_ID` (`User_ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Дамп данных таблицы `Professors`
--

INSERT INTO `Professors` (`ID`, `User_ID`, `Subjects`, `Lector`, `University`, `Year_finish`, `stepen`, `consultacii`, `sciense_interest`, `family`, `work`, `hoby`, `animal`) VALUES
(1, 1, '3||2', 0, 'НТУУ КПИ ФПМ', '2020-05-20', 'Доктор', 'Каждый день', 'Программирование', '', 'WTM Studio', '', '');

-- --------------------------------------------------------

--
-- Структура таблицы `Quotes`
--

CREATE TABLE IF NOT EXISTS `Quotes` (
  `id` int(11) NOT NULL DEFAULT '0',
  `quote_ru` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `quote_ua` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `quote_en` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `auther_ru` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `auther_ua` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `auther_en` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Дамп данных таблицы `Quotes`
--

INSERT INTO `Quotes` (`id`, `quote_ru`, `quote_ua`, `quote_en`, `auther_ru`, `auther_ua`, `auther_en`) VALUES
(1, 0xd0a2d0bed0bbd18cd0bad0be20d0b4d0b2d0b520d0b2d0b5d189d0b820d0b1d0b5d181d0bad0bed0bdd0b5d187d0bdd18b3a20d092d181d0b5d0bbd0b5d0bdd0bdd0b0d18f20d0b820d187d0b5d0bbd0bed0b2d0b5d187d0b5d181d0bad0b0d18f20d0b3d0bbd183d0bfd0bed181d182d18c2c20d0bdd0be20d0bdd0b020d181d187d191d18220d0bfd0b5d180d0b2d0bed0b920d18f20d0bdd0b520d183d0b2d0b5d180d0b5d0bd2e, 0xd08420d182d196d0bbd18cd0bad0b820d0b4d0b2d19620d0bdd0b5d181d0bad196d0bdd187d0b5d0bdd0bdd19620d180d0b5d187d1963a20d092d181d0b5d181d0b2d196d18220d19620d0bbd18ed0b4d181d18cd0bad0b020d0b4d183d180d196d181d182d18c2e203c62722f3ed0a5d0bed187d0b020d189d0bed0b4d0be20d092d181d0b5d181d0b2d196d182d18320d18f20d0bdd0b520d186d196d0bbd0bad0bed0bc20d0b2d0bfd0b5d0b2d0bdd0b5d0bdd0b8d0b92e, 0x4f6e6c792074776f207468696e67732061726520696e66696e6974652c2074686520756e69766572736520616e642068756d616e207374757069646974792c20616e642049276d206e6f7420737572652061626f75742074686520666f726d65722e, 'Альберт Эйнштейн', 'Альберт Ейнштейн', 'Albert Einstein');

-- --------------------------------------------------------

--
-- Структура таблицы `Ratings`
--

CREATE TABLE IF NOT EXISTS `Ratings` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Tablename` varchar(30) NOT NULL,
  `Date_create` date NOT NULL,
  `Professor_ID` int(10) unsigned NOT NULL,
  `Group_ID` int(10) unsigned NOT NULL,
  `SubProf_ID` int(10) unsigned NOT NULL,
  `Subject_ID` int(10) unsigned NOT NULL,
  `Max_Rating` int(6) NOT NULL,
  `Col_Caption` varchar(60) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `Professor_ID` (`Professor_ID`,`Group_ID`,`SubProf_ID`,`Subject_ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=45 ;

--
-- Дамп данных таблицы `Ratings`
--


-- --------------------------------------------------------

--
-- Структура таблицы `Students`
--

CREATE TABLE IF NOT EXISTS `Students` (
  `ID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `User_ID` int(11) NOT NULL,
  `Group_ID` int(11) NOT NULL,
  `Rank` enum('student','praepostor','trade-union') NOT NULL DEFAULT 'student',
  `Phone` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `User_ID` (`User_ID`,`Group_ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Дамп данных таблицы `Students`
--

INSERT INTO `Students` (`ID`, `User_ID`, `Group_ID`, `Rank`, `Phone`) VALUES
(1, 1, 1, 'student', ''),
(2, 10, 1, 'student', ''),
(3, 4, 2, 'student', ''),
(4, 11, 3, 'student', '');

-- --------------------------------------------------------

--
-- Структура таблицы `Subjects`
--

CREATE TABLE IF NOT EXISTS `Subjects` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Title_ua` varchar(40) NOT NULL,
  `Semester` varchar(60) NOT NULL,
  `Title_ru` varchar(40) NOT NULL,
  `Title_en` varchar(40) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `Title` (`Title_ua`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Дамп данных таблицы `Subjects`
--

INSERT INTO `Subjects` (`ID`, `Title_ua`, `Semester`, `Title_ru`, `Title_en`) VALUES
(1, 'ііііііііі', '10||5', 'ыыыыыыы', 'test'),
(2, 'Математичний аналіз', '', 'Математический анализ', 'Matemati4eskiy analiz'),
(3, 'Лінійна алгебра', '', 'Линейная алгебра', 'Lineyna9 algebra'),
(4, 'іііі', '1||3||2', 'ыыыыы', 'test');

-- --------------------------------------------------------

--
-- Структура таблицы `Users`
--

CREATE TABLE IF NOT EXISTS `Users` (
  `ID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `Name` varchar(20) NOT NULL,
  `Surname` varchar(20) NOT NULL,
  `Patronymic` varchar(20) NOT NULL,
  `Login` varchar(20) NOT NULL,
  `Password` varchar(60) NOT NULL,
  `Email` varchar(30) DEFAULT NULL,
  `Sex` enum('M','F') NOT NULL,
  `Birthday` date NOT NULL,
  `Contact` text NOT NULL,
  `Phone` varchar(20) DEFAULT NULL,
  `Photo` varchar(40) NOT NULL,
  `State` enum('P','S') NOT NULL DEFAULT 'S',
  `Description` text NOT NULL,
  `Language` enum('ua','en','ru') NOT NULL DEFAULT 'ua',
  `Session` char(150) NOT NULL,
  `IP_Login` varchar(25) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `Email` (`Email`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

--
-- Дамп данных таблицы `Users`
--

INSERT INTO `Users` (`ID`, `Name`, `Surname`, `Patronymic`, `Login`, `Password`, `Email`, `Sex`, `Birthday`, `Contact`, `Phone`, `Photo`, `State`, `Description`, `Language`, `Session`, `IP_Login`) VALUES
(1, 'Иван', 'Скрипка', 'Андреевич', 'vanish', 'e3571bfa766e709908f403f0461e169e', 'vanish.com@mal.ru', 'M', '2010-05-20', '', '', 'rock_tux0.png', 'P', '', 'ua', '74c58910a2265610902d570506a0b62e', '127.0.1.1'),
(2, 'Иван', 'Скрипка', 'Андреевич', 'test', '00afd5fc58239813aad7829aabe75b04', 'vanish.com90@gmail.com', 'M', '1990-05-20', '', '0503965771', 'rock_tux.png', 'S', '', 'ua', '', ''),
(11, 'dd', 'dd', 'dd', 'dd', '1aabac6d068eef6a7bad3fdf50a05cc8', 'vanish', 'M', '0000-00-00', '', NULL, '', 'S', '', 'ua', '', ''),
(4, 'Наталья', 'Красницкая', 'Викторовна', 'nata', 'a817d533ed72329657a2a92db23ec63b', 'blackhear_nata@mail.ru', 'F', '1990-11-09', '', '', 'images2.jpeg', 'S', '', 'ua', 'f25299dfee9118d5b7b2855b00fcf2ae', '127.0.0.1'),
(10, 'test', 'test', 'test', 'test', '098f6bcd4621d373cade4e832627b4f6', 'vanish.com@mail.ru', 'M', '0000-00-00', '', '0503965771', 'browser.png', 'S', '', 'ua', 'bb18b06bba73ad20b9c4202fc48ebbd5', '127.0.0.1'),
(12, '', '', '', 'vanish', 'e3571bfa766e709908f403f0461e169e', NULL, 'M', '0000-00-00', '', NULL, '', 'S', '', 'ua', '', ''),
(13, '', '', '', 'vanish', 'e3571bfa766e709908f403f0461e169e', NULL, 'M', '0000-00-00', '', NULL, '', 'S', '', 'ua', '', '');
