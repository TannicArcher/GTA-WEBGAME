-- phpMyAdmin SQL Dump
-- version 2.6.1
-- http://www.phpmyadmin.net
-- 
-- Хост: localhost
-- Время создания: Дек 09 2009 г., 15:50
-- Версия сервера: 5.0.45
-- Версия PHP: 5.2.4
-- 
-- БД: `table`
-- 

-- --------------------------------------------------------

-- 
-- Структура таблицы `attack`
-- 

CREATE TABLE `attack` (
  `id` int(11) NOT NULL auto_increment,
  `userid` int(11) NOT NULL default '0',
  `who` text,
  `msg` text,
  `power` int(11) NOT NULL default '0',
  `time` int(11) NOT NULL default '0',
  `what` text,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Дамп данных таблицы `attack`
-- 


-- --------------------------------------------------------

-- 
-- Структура таблицы `bands`
-- 

CREATE TABLE `bands` (
  `id` int(11) NOT NULL auto_increment,
  `name` text,
  `boss` text,
  `members` text,
  `avtoritet` text,
  `cars` text,
  `guns` text,
  `money` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Дамп данных таблицы `bands`
-- 


-- --------------------------------------------------------

-- 
-- Структура таблицы `clicks`
-- 

CREATE TABLE `clicks` (
  `dbid` int(10) unsigned NOT NULL default '0',
  `ip` varchar(15) NOT NULL default '',
  `time` int(10) unsigned NOT NULL default '0',
  `browser` blob NOT NULL,
  PRIMARY KEY  (`dbid`,`ip`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

-- 
-- Дамп данных таблицы `clicks`
-- 


-- --------------------------------------------------------

-- 
-- Структура таблицы `fights`
-- 

CREATE TABLE `fights` (
  `id` int(11) NOT NULL auto_increment,
  `userid` int(11) NOT NULL default '0',
  `last` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Дамп данных таблицы `fights`
-- 


-- --------------------------------------------------------

-- 
-- Структура таблицы `forsage`
-- 

CREATE TABLE `forsage` (
  `id` int(11) NOT NULL auto_increment,
  `users` text NOT NULL,
  `stage` int(2) NOT NULL default '1',
  `win` text NOT NULL,
  `time` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Дамп данных таблицы `forsage`
-- 


-- --------------------------------------------------------

-- 
-- Структура таблицы `forsage_cars`
-- 

CREATE TABLE `forsage_cars` (
  `id` int(11) NOT NULL auto_increment,
  `userid` int(11) NOT NULL default '0',
  `gonka` int(11) NOT NULL default '0',
  `car` text NOT NULL,
  `mods` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Дамп данных таблицы `forsage_cars`
-- 


-- --------------------------------------------------------

-- 
-- Структура таблицы `gb`
-- 

CREATE TABLE `gb` (
  `dbid` int(3) NOT NULL auto_increment,
  `text` text NOT NULL,
  `login` varchar(20) NOT NULL default '',
  `date` char(10) default NULL,
  PRIMARY KEY  (`dbid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Дамп данных таблицы `gb`
-- 


-- --------------------------------------------------------

-- 
-- Структура таблицы `gorod_conf`
-- 

CREATE TABLE `gorod_conf` (
  `open` varchar(2) NOT NULL,
  `kopi` int(11) NOT NULL,
  `kopi_v` varchar(32) NOT NULL,
  `kopi_k` varchar(32) NOT NULL,
  `kopi_time` int(11) NOT NULL,
  `luna` int(11) default '0'
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

-- 
-- Дамп данных таблицы `gorod_conf`
-- 


-- --------------------------------------------------------

-- 
-- Структура таблицы `gorod_firm`
-- 

CREATE TABLE `gorod_firm` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(50) NOT NULL,
  `opis` varchar(250) NOT NULL,
  `lasttake` bigint(20) NOT NULL,
  `dohod` int(11) NOT NULL,
  `balans` int(11) NOT NULL,
  `login` varchar(32) NOT NULL,
  `date` bigint(20) NOT NULL,
  `update` bigint(20) NOT NULL,
  `pritok` int(11) NOT NULL,
  `birga` varchar(3) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Дамп данных таблицы `gorod_firm`
-- 


-- --------------------------------------------------------

-- 
-- Структура таблицы `gorod_tbega`
-- 

CREATE TABLE `gorod_tbega` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(32) NOT NULL,
  `bet` smallint(6) NOT NULL,
  `last` varchar(32) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Дамп данных таблицы `gorod_tbega`
-- 


-- --------------------------------------------------------

-- 
-- Структура таблицы `kasino`
-- 

CREATE TABLE `kasino` (
  `id` int(11) NOT NULL auto_increment,
  `userid` int(11) NOT NULL default '0',
  `combo` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Дамп данных таблицы `kasino`
-- 


-- --------------------------------------------------------

-- 
-- Структура таблицы `krisha`
-- 

CREATE TABLE `krisha` (
  `id` int(2) NOT NULL auto_increment,
  `city` int(2) NOT NULL default '0',
  `house` text NOT NULL,
  `money` int(2) NOT NULL default '0',
  `band` text NOT NULL,
  `users` text NOT NULL,
  `time` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Дамп данных таблицы `krisha`
-- 


-- --------------------------------------------------------

-- 
-- Структура таблицы `messagi`
-- 

CREATE TABLE `messagi` (
  `id` int(11) NOT NULL auto_increment,
  `kto` int(11) NOT NULL default '0',
  `komu` int(11) NOT NULL default '0',
  `msg` text,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Дамп данных таблицы `messagi`
-- 


-- --------------------------------------------------------

-- 
-- Структура таблицы `news`
-- 

CREATE TABLE `news` (
  `dbid` int(3) NOT NULL auto_increment,
  `text` text NOT NULL,
  `login` varchar(20) NOT NULL default '',
  `date` char(10) default NULL,
  PRIMARY KEY  (`dbid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Дамп данных таблицы `news`
-- 


-- --------------------------------------------------------

-- 
-- Структура таблицы `opros`
-- 

CREATE TABLE `opros` (
  `dbid` int(11) NOT NULL auto_increment,
  `name` varchar(200) default NULL,
  `golos` int(11) NOT NULL default '0',
  PRIMARY KEY  (`dbid`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251 AUTO_INCREMENT=1 ;

-- 
-- Дамп данных таблицы `opros`
-- 


-- --------------------------------------------------------

-- 
-- Структура таблицы `osobnyaki`
-- 

CREATE TABLE `osobnyaki` (
  `id` int(11) NOT NULL auto_increment,
  `bandname` text NOT NULL,
  `type` int(2) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Дамп данных таблицы `osobnyaki`
-- 


-- --------------------------------------------------------

-- 
-- Структура таблицы `refers`
-- 

CREATE TABLE `refers` (
  `id` int(11) NOT NULL auto_increment,
  `userid` int(11) NOT NULL default '0',
  `refer` text,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Дамп данных таблицы `refers`
-- 


-- --------------------------------------------------------

-- 
-- Структура таблицы `rnews`
-- 

CREATE TABLE `rnews` (
  `id` int(3) NOT NULL auto_increment,
  `title` varchar(50) NOT NULL default '',
  `text` text NOT NULL,
  `login` varchar(20) NOT NULL default '',
  `time` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Дамп данных таблицы `rnews`
-- 


-- --------------------------------------------------------

-- 
-- Структура таблицы `sklad`
-- 

CREATE TABLE `sklad` (
  `id` int(11) NOT NULL auto_increment,
  `kto` int(11) NOT NULL default '0',
  `komu` int(11) NOT NULL default '0',
  `chto` text NOT NULL,
  `type` int(2) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Дамп данных таблицы `sklad`
-- 


-- --------------------------------------------------------

-- 
-- Структура таблицы `user_home`
-- 

CREATE TABLE `user_home` (
  `id` int(11) NOT NULL auto_increment,
  `userid` int(11) NOT NULL default '0',
  `cars` text,
  `guns` text,
  `money` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Дамп данных таблицы `user_home`
-- 


-- --------------------------------------------------------

-- 
-- Структура таблицы `users`
-- 

CREATE TABLE `users` (
  `id` int(11) NOT NULL auto_increment,
  `login` text NOT NULL,
  `pass` text NOT NULL,
  `mobile` text,
  `email` text,
  `about` text,
  `status` text,
  `reg_data` text,
  `money` int(11) NOT NULL default '0',
  `level` int(4) NOT NULL default '0',
  `police` int(3) NOT NULL default '0',
  `health` int(4) NOT NULL default '0',
  `band` text NOT NULL,
  `last` text NOT NULL,
  `cars` text NOT NULL,
  `guns` text NOT NULL,
  `nums` int(11) NOT NULL default '0',
  `voodoo` int(1) NOT NULL default '0',
  `golod` int(4) NOT NULL default '0',
  `secur` int(3) NOT NULL default '0',
  `city` int(3) NOT NULL default '0',
  `admin` int(6) NOT NULL default '0',
  `ban` int(1) NOT NULL default '0',
  `zav` int(25) NOT NULL default '0',
  `lsd` int(25) NOT NULL default '0',
  `redaktor` int(2) NOT NULL default '0',
  `gorod_firm` varchar(50) NOT NULL,
  `gorod_kopi` bigint(20) NOT NULL,
  `pol` enum('0','1') NOT NULL default '1',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- 
-- Дамп данных таблицы `users`
-- 

INSERT INTO `users` VALUES (1, 'admin', '1234', NULL, NULL, NULL, NULL, NULL, 300, 100, 0, 150, '', '', '', '', 0, 0, 300, 0, 0, 7, 0, 0, 0, 0, '', 0, '1');
        