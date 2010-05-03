-- phpMyAdmin SQL Dump
-- version 2.10.3
-- http://www.phpmyadmin.net
-- 
-- Хост: localhost
-- Время создания: Май 03 2010 г., 16:27
-- Версия сервера: 5.0.51
-- Версия PHP: 5.2.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- 
-- База данных: `pma`
-- 

-- --------------------------------------------------------

-- 
-- Структура таблицы `admins`
-- 

DROP TABLE IF EXISTS `admins`;
CREATE TABLE `admins` (
  `ID` int(11) unsigned NOT NULL auto_increment,
  `User_ID` int(11) unsigned NOT NULL,
  PRIMARY KEY  (`ID`),
  KEY `User_ID` (`User_ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- 
-- Дамп данных таблицы `admins`
-- 

INSERT INTO `admins` VALUES (1, 1);

-- --------------------------------------------------------

-- 
-- Структура таблицы `configs`
-- 

DROP TABLE IF EXISTS `configs`;
CREATE TABLE `configs` (
  `id` int(11) NOT NULL auto_increment,
  `key` varchar(40) character set utf8 collate utf8_bin NOT NULL,
  `value` varchar(40) character set utf8 collate utf8_bin NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

-- 
-- Дамп данных таблицы `configs`
-- 

INSERT INTO `configs` VALUES (1, 0x6c616e67756167655f64656661756c74, 0x7561);
INSERT INTO `configs` VALUES (2, 0x6c616e677561676573, 0x75617c7c72757c7c656e7c7c);
INSERT INTO `configs` VALUES (3, 0x6d6573736167655f7065725f70616765, 0x35);
INSERT INTO `configs` VALUES (4, 0x6e65775f6e657773, 0x35);

-- --------------------------------------------------------

-- 
-- Структура таблицы `files`
-- 

DROP TABLE IF EXISTS `files`;
CREATE TABLE `files` (
  `ID` int(11) unsigned NOT NULL auto_increment,
  `Title` varchar(20) character set utf8 NOT NULL,
  `Filepath` varchar(80) character set utf8 NOT NULL,
  `Master` int(11) NOT NULL,
  `Date` date NOT NULL,
  `Semester` int(5) NOT NULL,
  `Description` text character set utf8 NOT NULL,
  `Subject_ID` int(10) unsigned NOT NULL,
  `Cover` varchar(80) character set utf8 NOT NULL,
  PRIMARY KEY  (`ID`),
  KEY `Subject_ID` (`Subject_ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

-- 
-- Дамп данных таблицы `files`
-- 

INSERT INTO `files` VALUES (4, 'test', 'static/uploaded/files/oop.zip', 1, '2010-04-16', 4, '1', 3, 'static/uploaded/covers/ineedokulist1.jpg');
INSERT INTO `files` VALUES (5, 'rew', 'static/uploaded/files/oop0.zip', 1, '2010-04-19', 1, '1', 1, 'static/uploaded/covers/');
INSERT INTO `files` VALUES (6, 'rew', 'static/uploaded/files/oop1.zip', 1, '2010-04-19', 1, '1', 1, 'static/uploaded/covers/');

-- --------------------------------------------------------

-- 
-- Структура таблицы `groups`
-- 

DROP TABLE IF EXISTS `groups`;
CREATE TABLE `groups` (
  `ID` int(10) unsigned NOT NULL auto_increment,
  `Title` varchar(6) NOT NULL,
  `Course` date NOT NULL,
  `Sheduler_Path` varchar(30) NOT NULL,
  `Extranumeral` tinyint(1) NOT NULL,
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Дамп данных таблицы `groups`
-- 


-- --------------------------------------------------------

-- 
-- Структура таблицы `message`
-- 

DROP TABLE IF EXISTS `message`;
CREATE TABLE `message` (
  `ID` int(10) unsigned NOT NULL auto_increment,
  `Whom` int(10) unsigned NOT NULL,
  `From` int(10) unsigned NOT NULL,
  `Date_Create` date NOT NULL,
  `Date_Delete` date NOT NULL,
  `Email` varchar(20) NOT NULL,
  `Flag` enum('s','r','n') NOT NULL,
  `Text_ID` int(10) NOT NULL,
  PRIMARY KEY  (`ID`),
  KEY `Whom` (`Whom`,`From`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Дамп данных таблицы `message`
-- 


-- --------------------------------------------------------

-- 
-- Структура таблицы `messagetext`
-- 

DROP TABLE IF EXISTS `messagetext`;
CREATE TABLE `messagetext` (
  `ID` int(10) unsigned NOT NULL auto_increment,
  `Text` text NOT NULL,
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Дамп данных таблицы `messagetext`
-- 


-- --------------------------------------------------------

-- 
-- Структура таблицы `obj_comments`
-- 

DROP TABLE IF EXISTS `obj_comments`;
CREATE TABLE `obj_comments` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `id_post` int(10) unsigned NOT NULL,
  `id_user` int(10) unsigned NOT NULL,
  `date` datetime NOT NULL default '0000-00-00 00:00:00',
  `text` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=33 ;

-- 
-- Дамп данных таблицы `obj_comments`
-- 

INSERT INTO `obj_comments` VALUES (15, 7, 1, '0000-00-00 00:00:00', 'Ура!!');
INSERT INTO `obj_comments` VALUES (31, 7, 1, '2010-04-16 22:45:28', '');
INSERT INTO `obj_comments` VALUES (32, 7, 1, '2010-04-19 11:14:08', 'Yep, it''s good!');

-- --------------------------------------------------------

-- 
-- Структура таблицы `obj_news`
-- 

DROP TABLE IF EXISTS `obj_news`;
CREATE TABLE `obj_news` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `id_user` int(10) unsigned NOT NULL,
  `title_ru` varchar(255) NOT NULL,
  `text_ru` text NOT NULL,
  `date` datetime NOT NULL,
  `date_edit` int(10) unsigned NOT NULL,
  `comments` enum('n','y') NOT NULL default 'y',
  `active` enum('n','y') NOT NULL default 'n',
  `comments_count` int(10) unsigned NOT NULL,
  `views` int(10) unsigned NOT NULL,
  `title_ua` varchar(255) NOT NULL,
  `text_ua` text NOT NULL,
  `title_en` varchar(255) NOT NULL,
  `text_en` text NOT NULL,
  `internal` enum('y','n') character set utf8 collate utf8_bin NOT NULL default 'n',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

-- 
-- Дамп данных таблицы `obj_news`
-- 

INSERT INTO `obj_news` VALUES (7, 1, 'Запуск сайта', '<p>Сайт запущен в тестовом режиме</p>', '2010-04-13 21:10:00', 1270499281, 'y', 'y', 2, 75, 'Запуск сайта', 'Сайт запущен в тестовом режиме', 'Site is running', '<p>Site running in test mo</p>', 0x6e);

-- --------------------------------------------------------

-- 
-- Структура таблицы `obj_staticpages`
-- 

DROP TABLE IF EXISTS `obj_staticpages`;
CREATE TABLE `obj_staticpages` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `id_parent` int(10) unsigned NOT NULL,
  `position` int(10) unsigned NOT NULL,
  `date` int(10) unsigned NOT NULL,
  `date_mod` int(10) unsigned NOT NULL,
  `title_ru` varchar(250) NOT NULL,
  `title_ua` varchar(250) NOT NULL,
  `title_en` varchar(250) NOT NULL,
  `text_ru` text NOT NULL,
  `text_ua` text NOT NULL,
  `text_en` text NOT NULL,
  `active` enum('n','y') NOT NULL,
  `views` int(11) unsigned NOT NULL default '0',
  `hat` varchar(30) character set utf8 collate utf8_bin NOT NULL,
  `module` varchar(100) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=61 ;

-- 
-- Дамп данных таблицы `obj_staticpages`
-- 

INSERT INTO `obj_staticpages` VALUES (1, 0, 0, 1256815214, 1270487071, 'Главная страница', 'Головна сторiнка', 'Main page', '<p style="text-align: justify;">Приветствуем Вас на сайте кафедры прикладной математики Национального  технического университета Украины "Киевский политехнический институт"!</p><p style="text-align: justify;">Стабильное развитие Украины невозможно без высококвалифицированных  специалистов, обладающих углублённой подготовкой в областях применения  математических методов к научно-техническим и производственным задачам,  владеющих современными компьютерными технологиями и соответствующими  средствами, позволяющими разрабатывать новые технологии и методы решения  прикладных задач. Поэтому направления научной деятельности нашей  кафедры направлены на решение проблем прикладной математики и  информатики, разработки математического, программного и технического  обеспечения новых информационных технологий.</p><p style="text-align: justify;">Наши студенты получают подготовку высокого уровня, ориентированную на  практическое использование математических методов и средства  современных ІТ-технологий для решения широкого круга инженерных задач в  областях производственной, хозяйственной, экологической и экономической  деятельности.</p><p style="text-align: justify;">Наши выпускники работают аналитиками и программистами:</p><ul style="text-align: justify;"><li>в информационных и аналитических отделах банков;</li><li>в компьютерных отделах офисов фирм и предприятий;</li><li>в научно-аналитических подразделениях СБУ, МВД, таможенной и  налоговой служб Украины;</li><li>в научно-исследовательских институтах Национальной академии наук  Украины;</li><li>в других государственных и частных учреждениях и предприятиях.</li></ul><p style="text-align: justify;">На сайте Вы сможете найти всю нужную информацию, а также сможете  присоединиться к активной гражданской жизни не выходя из собственного  жилья!</p><p style="text-align: justify;">&nbsp;</p><p style="text-align: right;"><em>Администрация сайта ПМА</em></p><ul></ul>', '<p style="text-align: justify;">Вітаємо Вас на сайті кафедри прикладної математики Національного  технічного університету України «Київський політехнічний інститут»!</p><p style="text-align: justify;">Стабільний розвиток України неможливий без висококваліфікованих  фахівців, що мають поглиблену підготовку в галузях застосування  математичних методів до науково-технічних та виробничих задач, що  володіють сучасними комп’ютерними технологіями та відповідними засобами,  які дають змогу розробляти нові технології та методи розв’язку  прикладних задач. Тому напрями наукової діяльності нашої кафедри  спрямовані на вирішення проблем прикладної математики та інформатики,  розробки математичного, програмного та технічного забезпечення нових  інформаційних технологій.</p><p style="text-align: justify;">Наші студенти отримують підготовку високого рівня, що орієнтована на  практичне використання математичних методів і засобів сучасних  IT-технологій для вирішення широкого кола інженерних задач в галузях  виробничої, господарчої, екологічної та економічної діяльності.</p><p style="text-align: justify;">Наші випускники працюють аналітиками і програмістами:</p><ul style="text-align: justify;"><li>в інформаційних та аналітичних відділах банків;</li><li>у комп’ютерних відділах офісів фірм та підприємств;</li><li>у науково-аналітичних підрозділах СБУ, МВС, митної та податкової  служб України;</li><li> у науково-дослідницьких інститутах Національної академії наук  України;</li><li>в інших державних та приватних установах та підприємствах.</li></ul><p style="text-align: justify;">На сайті Ви зможете знайти всю потрібну інформацію, а також зможете  долучитися до активного громадського життя не виходячи з власної  домівки!</p><p style="text-align: justify;">&nbsp;</p><p style="text-align: right;"><em>Адміністрація сайту ПМА</em></p><ul></ul>', '<p style="text-align: justify;">Welcome to the website of the Applied Mathematics Department of the National Technical University of Ukraine "Kyiv Polytechnic Institute"!</p><p style="text-align: justify;">The stable development of Ukraine is impossible without qualified specialists that possess the fundamental grounding necessary for implementing mathematical methods in scientific and industrial spheres. Such specialists are also capable of new computer technologies and appropriate means of developing new technologies and methods for solving real-life problems. That is why the scientific researches in our Department are mainly held in the fields of solving applied math and computer science problems, and developing the mathematical background, software and hardware for new information technologies.</p><p style="text-align: justify;">Our students gain a high-level grounding that is directed to the practical use of mathematical methods and means of modern IT for solving wide range if engineering problems in the fields of industrial, ecological and economical spheres.</p><p style="text-align: justify;">Our Alumni work as analysts and programmers:</p><ul style="text-align: justify;"><li>at information and analyst bank departments;</li><li>at computer departments in firms and companies;</li><li>at scientific and analytic departments of the SSU, MIF, custom and tax services of Ukraine;</li><li>at scientific institutes of the National Academy of Science of Ukraine;</li><li>at the other organizations, both state and private.</li></ul><p style="text-align: justify;">You can find all the important information here at the website. Also, you can join active social life even without living you very apartment!</p><p style="text-align: justify;">&nbsp;</p><p style="text-align: right;"><em>PMA website administration<br></em></p><ul></ul>', 'y', 1797, 0x6d61696e, NULL);
INSERT INTO `obj_staticpages` VALUES (60, 0, 9, 1269695095, 1269695256, 'Международная деятельность', 'Міжнародна діяльність', 'International', '', '', '', 'y', 38, 0x696e7465726e6174696f6e616c, NULL);
INSERT INTO `obj_staticpages` VALUES (18, 5, 3, 1269639610, 1269640015, 'Выпускникам кафедры', 'Випускникам кафедри', 'Alumni List', '', '', '', 'y', 2, 0x616269747572, NULL);
INSERT INTO `obj_staticpages` VALUES (4, 0, 100, 1256816202, 1268517397, 'Научная работа', 'Наукова робота', 'Research', '<p>TEXT of page 4 ru Bwahahahhaha!!!</p>', '<p>TEXT<em> of<span style="text-decoration: underline;"> pa<strong>ge 4<span style="text-decoration: line-through;"> ua TEXT o</span></strong></span></em></p>\r\n<p><em><span style="text-decoration: underline;"><strong><span style="text-decoration: line-through;">f page 4 ru Bwa</span>hah</strong>ahha</span></em>ha!!!</p>', '<p>TEXT of page 4 en</p>', 'y', 81, 0x736369656e6365, NULL);
INSERT INTO `obj_staticpages` VALUES (5, 0, 1, 1256816202, 1269779804, 'Для абитуриентов', 'Для абітурієнтів', 'For entrants', '<p><strong>\r\n<p>Вітаємо Вас на сайті кафедри прикладної математики Національного технічного університету України &laquo;Київського політехнічного інституту&raquo;.<br />Стабільний розвиток України неможливий без висококваліфікованих фахівців, що мають поглиблену підготовку в галузях застосування математичних методів до науково-технічних та виробничих задач, що володіють сучасними комп&rsquo;ютерними технологіями та відповідними засобами, які дають змогу розробляти нові технології та методи розв&rsquo;язку прикладних задач. Тому напрями наукової діяльності нашої кафедри спрямовані на вирішення проблем прикладної математики та інформатики, розробки математичного, програмного та технічного забезпечення нових інформаційних технологій.<br />Наші студенти отримують підготовку високого рівня, що орієнтована на практичне використання математичних методів і засобів сучасних IT-технологій для вирішення широкого кола інженерних задач в галузях виробничої, господарчої, екологічної та економічної діяльності.<br />Наші випускники працюють аналітиками і програмістами:</p>\r\n<ul>\r\n<li><br />в інформаційних та аналітичних відділах банків;</li>\r\n<li>в комп&rsquo;ютерних відділах офісів фірм та підприємств;</li>\r\n<li>в науково-аналітичних підрозділах СБУ, МВС, митної та податкової служб України;</li>\r\n<li>в науково-дослідницьких інститутах Національної академії наук України;</li>\r\n<li>в інших державних та недержавних установах та підприємствах.</li>\r\n</ul>\r\n</strong></p>\r\n<p>&nbsp;</p>\r\n<p>&nbsp;</p>\r\n<p>&nbsp;</p>', '<p>TEXT of page 5 ua</p>', '<p>TEXT of page 5 en</p>', 'y', 429, 0x616269747572, NULL);
INSERT INTO `obj_staticpages` VALUES (17, 5, 2, 1269639556, 1269639972, 'Заочное отделение', 'Заочне відділення', 'Сorrespondence department', '', '', '', 'y', 12, 0x616269747572, NULL);
INSERT INTO `obj_staticpages` VALUES (7, 0, 1, 1256816202, 1268517148, 'Для студентов', 'Для студентів', 'For students', '<p>TEXT of page 7 ru</p>', '<p>TEXT of page 7 ua</p>', '<p>TEXT of page 7 en</p>', 'y', 829, 0x73747564656e74, NULL);
INSERT INTO `obj_staticpages` VALUES (8, 7, 0, 1256816202, 1269640564, 'Списки групп', 'Списки груп', 'Groups lists', '<p>TEXT of page 8 ru</p>', '<p>TEXT of page 8 ua</p>', '<p>TEXT of page 8 en</p>', 'y', 142, 0x73747564656e74, NULL);
INSERT INTO `obj_staticpages` VALUES (9, 8, 1, 1256816202, 1269640837, '1 курс', '1 курс', '1 course', '<p>TEXT of page 9 ru</p>', '<p>TEXT of page 9 ua</p>', '<p>TEXT of page 9 en</p>', 'y', 167, 0x73747564656e74, NULL);
INSERT INTO `obj_staticpages` VALUES (23, 8, 4, 1269640713, 1269640885, '4 курс', '4 курс', '4 course', '', '', '', 'y', 0, 0x73747564656e74, NULL);
INSERT INTO `obj_staticpages` VALUES (24, 8, 5, 1269640763, 1269640874, '5 курс', '5 курс', '5 course', '', '', '', 'y', 1, 0x73747564656e74, NULL);
INSERT INTO `obj_staticpages` VALUES (11, 8, 2, 1256816202, 1269640825, '2 курс', '2 курс', '2 course', '<p>TEXT of page 11 ru</p>', '<p>TEXT of page 11 ua</p>', '<p>TEXT of page 11 en</p>', 'y', 49, 0x73747564656e74, NULL);
INSERT INTO `obj_staticpages` VALUES (12, 0, 2, 1256816244, 1268517269, 'Про преподавателей', 'Про викладачів', 'About Lecturers', 'TEXT of page 12 ru', 'TEXT of page 12 ua', 'TEXT of page 12 en', 'y', 205, 0x707265706f64, NULL);
INSERT INTO `obj_staticpages` VALUES (13, 0, 3, 1256816244, 1268517326, 'Для выпускников', 'Для випускників', 'For Alumni', 'TEXT of page 13 ru', 'TEXT of page 13 ua', 'TEXT of page 13 en', 'y', 110, 0x66726565, NULL);
INSERT INTO `obj_staticpages` VALUES (16, 5, 1, 1269639425, 1269639959, 'Как поступить', 'Як вступити', 'How to join', '', '', '', 'y', 23, 0x616269747572, NULL);
INSERT INTO `obj_staticpages` VALUES (22, 8, 3, 1269640699, 1269640851, '3 курс', '3 курс', '3 course', '', '', '', 'y', 28, 0x73747564656e74, NULL);
INSERT INTO `obj_staticpages` VALUES (19, 5, 4, 1269639657, 1269639938, 'Карта КПИ', 'Мапа КПИ', 'KPI Map', '', '', '', 'y', 5, 0x616269747572, NULL);
INSERT INTO `obj_staticpages` VALUES (20, 16, 0, 1269639707, 1269639707, 'Правила поступления', 'Правила вступу', 'Rules income', '', '', '', 'y', 9, 0x616269747572, NULL);
INSERT INTO `obj_staticpages` VALUES (21, 16, 0, 1269639870, 1269639870, 'Специальность ПМА', 'Спеціальність ПМА', 'Specialty PMA', '', '', '', 'y', 4, 0x616269747572, NULL);
INSERT INTO `obj_staticpages` VALUES (25, 8, 6, 1269640815, 1269640815, '6 курс', '6 курс', '6 course', '', '', '', 'y', 1, 0x73747564656e74, NULL);
INSERT INTO `obj_staticpages` VALUES (26, 7, 0, 1269641736, 1269641736, 'Расписание занятий', 'Розклад заннять', 'Schedule', '', '', '', 'y', 5, 0x73747564656e74, NULL);
INSERT INTO `obj_staticpages` VALUES (27, 26, 0, 1269641780, 1269641780, 'Зачеты и экзамены', 'Заліки та екзамени', 'Tests and exams', '', '', '', 'y', 6, 0x73747564656e74, NULL);
INSERT INTO `obj_staticpages` VALUES (28, 7, 0, 1269641835, 1269641835, 'Вспомогательные структуры', 'Допоміжні структури', 'Supporting structure', '', '', '', 'y', 5, 0x73747564656e74, NULL);
INSERT INTO `obj_staticpages` VALUES (29, 28, 0, 1269641890, 1269641890, 'Поликлиника', 'Поліклініка', 'Policlinic', '', '', '', 'y', 1, 0x73747564656e74, NULL);
INSERT INTO `obj_staticpages` VALUES (30, 28, 0, 1269641916, 1269641916, 'Библиотека', 'Бібліотека', 'Library', '', '', '', 'y', 3, 0x73747564656e74, NULL);
INSERT INTO `obj_staticpages` VALUES (31, 28, 0, 1269641961, 1269643119, 'Банкоматы', 'Банкомати', 'ATMs', '', '', '', 'y', 1, 0x73747564656e74, NULL);
INSERT INTO `obj_staticpages` VALUES (32, 28, 0, 1269641998, 1269643161, 'Аптеки', 'Аптеки', 'Pharmacies', '', '', '', 'y', 0, 0x73747564656e74, NULL);
INSERT INTO `obj_staticpages` VALUES (33, 28, 0, 1269642048, 1269643061, 'Парикмахерские', 'Перукарні', 'Hairdressers', '', '', '', 'y', 0, 0x73747564656e74, NULL);
INSERT INTO `obj_staticpages` VALUES (34, 28, 0, 1269642093, 1269643090, 'Украинско-японский центр', 'Україно-японський центр', 'Ukraine-Japan Center', '', '', '', 'y', 1, 0x73747564656e74, NULL);
INSERT INTO `obj_staticpages` VALUES (35, 7, 0, 1269642173, 1269642173, 'Общежитие', 'Гуртожиток', 'Hostel', '', '', '', 'y', 4, 0x73747564656e74, NULL);
INSERT INTO `obj_staticpages` VALUES (36, 35, 0, 1269642229, 1269642229, 'Студенческий быт', 'Студентський побут', 'Student life', '', '', '', 'y', 1, 0x73747564656e74, '');
INSERT INTO `obj_staticpages` VALUES (37, 35, 0, 1269642272, 1269642272, 'День посвящения в первокурсники', 'День посвяти першокурсників', 'The day of initiation of freshmen', '', '', '', 'y', 0, 0x73747564656e74, NULL);
INSERT INTO `obj_staticpages` VALUES (38, 35, 0, 1269642313, 1269642313, 'Контактная информация', 'Контактна інформація', 'Contact', '', '', '', 'y', 4, 0x73747564656e74, NULL);
INSERT INTO `obj_staticpages` VALUES (39, 7, 0, 1269642361, 1269642361, 'Студенческая жизнь', 'Студентське життя', 'Student life', '', '', '', 'y', 12, 0x73747564656e74, NULL);
INSERT INTO `obj_staticpages` VALUES (40, 39, 0, 1269642415, 1269642415, 'Cтудсовет', 'Студрада', 'Student Council', '', '', '', 'y', 2, 0x73747564656e74, NULL);
INSERT INTO `obj_staticpages` VALUES (41, 39, 0, 1269642500, 1269642500, 'Профсоюз', 'Профспілка', 'Professionalyny Union', '', '', '', 'y', 2, 0x73747564656e74, '');
INSERT INTO `obj_staticpages` VALUES (42, 39, 0, 1269642537, 1269642537, 'Отдых', 'Відпочинок', 'Rest', '', '', '', 'y', 2, 0x73747564656e74, NULL);
INSERT INTO `obj_staticpages` VALUES (43, 39, 0, 1269642585, 1269642585, 'Cпортивные секции', 'Спортивні секції', 'Sporting Section', '', '', '', 'y', 5, 0x73747564656e74, NULL);
INSERT INTO `obj_staticpages` VALUES (44, 39, 0, 1269642657, 1269642657, 'Кружки', 'Кружки', 'Mugs', '', '', '', 'y', 6, 0x73747564656e74, NULL);
INSERT INTO `obj_staticpages` VALUES (45, 7, 0, 1269642726, 1269642726, 'Официальные документы', 'Офіційні документи', 'Official Documents', '', '', '', 'y', 8, 0x73747564656e74, NULL);
INSERT INTO `obj_staticpages` VALUES (46, 45, 0, 1269642769, 1269642769, 'Торба', 'Торба', 'Torba', '', '', '', 'y', 1, 0x73747564656e74, 'fileshare');
INSERT INTO `obj_staticpages` VALUES (47, 45, 0, 1269642829, 1269642829, 'Бакалаврам и магистрам', 'Бакалаврам та магістрам', 'Bachelors and masters', '', '', '', 'y', 0, 0x73747564656e74, NULL);
INSERT INTO `obj_staticpages` VALUES (48, 45, 0, 1269642869, 1269642869, 'Заявления в деканат', 'Заяви до деканату', 'Statements in Deanery', '', '', '', 'y', 0, 0x73747564656e74, NULL);
INSERT INTO `obj_staticpages` VALUES (49, 45, 0, 1269642917, 1269642917, 'Правила сдачи сессии', 'Правила здачі сесії', 'Terms of delivery session', '', '', '', 'y', 0, 0x73747564656e74, NULL);
INSERT INTO `obj_staticpages` VALUES (50, 45, 0, 1269642961, 1269642961, 'Заседания кафедры', 'Засідання кафедри', 'Meetings Department', '', '', '', 'y', 0, 0x73747564656e74, NULL);
INSERT INTO `obj_staticpages` VALUES (51, 45, 0, 1269643006, 1269643006, 'Военный институт', 'Військовий інститут', 'Military Institute', '', '', '', 'y', 0, 0x73747564656e74, NULL);
INSERT INTO `obj_staticpages` VALUES (52, 45, 0, 1269643225, 1269643225, 'Успеваемость', 'Успішність', 'Progress', '', '', '', 'y', 0, 0x73747564656e74, NULL);
INSERT INTO `obj_staticpages` VALUES (53, 45, 0, 1269643335, 1269643335, 'О заочниках', 'Про заочників', 'Of students by correspondence', '', '', '', 'y', 9, 0x73747564656e74, NULL);
INSERT INTO `obj_staticpages` VALUES (54, 12, 0, 1269643390, 1269643390, 'Преподаватели', 'Викладачі', 'Teachers', '', '', '', 'y', 5, 0x707265706f64, NULL);
INSERT INTO `obj_staticpages` VALUES (55, 12, 0, 1269643433, 1269643433, 'Рейтинг преподавателей', 'Рейтинг викладачів', 'Rating Teachers', '', '', '', 'y', 2, 0x707265706f64, NULL);
INSERT INTO `obj_staticpages` VALUES (56, 12, 0, 1269643543, 1269643543, 'Учебные программы дисциплин', 'Навчальні програми дисциплін', 'Curriculum subjects', '', '', '', 'y', 2, 0x707265706f64, NULL);
INSERT INTO `obj_staticpages` VALUES (57, 12, 0, 1269643591, 1269643591, 'История кафедры', 'Історія кафедри', 'History Department', '', '', '', 'y', 2, 0x707265706f64, NULL);
INSERT INTO `obj_staticpages` VALUES (58, 13, 0, 1269643635, 1269643635, 'Списки групп', 'Списки групп', 'Groups Lists', '', '', '', 'y', 2, 0x66726565, NULL);
INSERT INTO `obj_staticpages` VALUES (59, 13, 0, 1269643670, 1269643670, 'Анкета для выпускников', 'Анкета для випускників', 'Questionnaire for graduates', '', '', '', 'y', 3, 0x66726565, NULL);

-- --------------------------------------------------------

-- 
-- Структура таблицы `professors`
-- 

DROP TABLE IF EXISTS `professors`;
CREATE TABLE `professors` (
  `ID` int(10) unsigned NOT NULL auto_increment,
  `User_ID` int(10) unsigned NOT NULL,
  `Subjects` varchar(200) NOT NULL,
  `Lector` tinyint(1) NOT NULL,
  PRIMARY KEY  (`ID`),
  KEY `User_ID` (`User_ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- 
-- Дамп данных таблицы `professors`
-- 

INSERT INTO `professors` VALUES (1, 1, '1||2||3', 0);

-- --------------------------------------------------------

-- 
-- Структура таблицы `ratings`
-- 

DROP TABLE IF EXISTS `ratings`;
CREATE TABLE `ratings` (
  `ID` int(10) unsigned NOT NULL auto_increment,
  `Tablename` varchar(30) NOT NULL,
  `Date_create` date NOT NULL,
  `Professor_ID` int(10) unsigned NOT NULL,
  `Group_ID` int(10) unsigned NOT NULL,
  `SubProf_ID` int(10) unsigned NOT NULL,
  `Subject_ID` int(10) unsigned NOT NULL,
  `Max_Rating` int(6) NOT NULL,
  `Col_Caption` varchar(60) NOT NULL,
  PRIMARY KEY  (`ID`),
  KEY `Professor_ID` (`Professor_ID`,`Group_ID`,`SubProf_ID`,`Subject_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Дамп данных таблицы `ratings`
-- 


-- --------------------------------------------------------

-- 
-- Структура таблицы `students`
-- 

DROP TABLE IF EXISTS `students`;
CREATE TABLE `students` (
  `ID` int(11) unsigned NOT NULL auto_increment,
  `User_ID` int(11) NOT NULL,
  `Group_ID` int(11) NOT NULL,
  `Rank` enum('student','praepostor','trade-union') NOT NULL default 'student',
  PRIMARY KEY  (`ID`),
  KEY `User_ID` (`User_ID`,`Group_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Дамп данных таблицы `students`
-- 


-- --------------------------------------------------------

-- 
-- Структура таблицы `subjects`
-- 

DROP TABLE IF EXISTS `subjects`;
CREATE TABLE `subjects` (
  `ID` int(10) unsigned NOT NULL auto_increment,
  `Title` varchar(40) NOT NULL,
  `Semester` varchar(60) NOT NULL,
  PRIMARY KEY  (`ID`),
  UNIQUE KEY `Title` (`Title`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

-- 
-- Дамп данных таблицы `subjects`
-- 

INSERT INTO `subjects` VALUES (1, 'Физика', '');
INSERT INTO `subjects` VALUES (2, 'Математический анализ', '');
INSERT INTO `subjects` VALUES (3, 'Линейная алгебра', '');

-- --------------------------------------------------------

-- 
-- Структура таблицы `users`
-- 

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `ID` int(11) unsigned NOT NULL auto_increment,
  `Name` varchar(20) NOT NULL,
  `Surname` varchar(20) NOT NULL,
  `Patronymic` varchar(20) NOT NULL,
  `Login` varchar(20) NOT NULL,
  `Password` varchar(60) NOT NULL,
  `Email` varchar(30) NOT NULL,
  `Sex` enum('M','F') NOT NULL,
  `Birthday` date NOT NULL,
  `Contact` text NOT NULL,
  `Phone` int(20) unsigned NOT NULL,
  `Photo` varchar(40) NOT NULL,
  `State` enum('P','S') NOT NULL default 'S',
  `Description` text NOT NULL,
  `Language` enum('ua','en','ru') NOT NULL default 'ua',
  `Session` char(150) NOT NULL,
  `IP_Login` varchar(25) NOT NULL,
  PRIMARY KEY  (`ID`),
  UNIQUE KEY `Email` (`Email`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- 
-- Дамп данных таблицы `users`
-- 

INSERT INTO `users` VALUES (1, 'toxa', 'chernyavskiy', 'sergeevich', 'splinter', '1f74df58d1c0f7b55b5caa01e6c7f806', 'i.splinter@i.ua', 'M', '1989-12-21', '', 123456789, 'rock_tux.png', 'P', '', 'ua', 'c8835a87f70f431a851b28cb00b432fb', '10.0.165.19');
