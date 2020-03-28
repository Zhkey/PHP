-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2019-06-12 18:28:51
-- 服务器版本： 10.1.19-MariaDB
-- PHP Version: 5.5.38

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db001`
--

-- --------------------------------------------------------

--
-- 表的结构 `member`
--

CREATE TABLE `member` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(64) NOT NULL,
  `realname` varchar(255) DEFAULT NULL,
  `age` varchar(3) DEFAULT NULL,
  `gender` varchar(12) DEFAULT NULL,
  `picurl` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `member`
--

INSERT INTO `member` (`id`, `username`, `password`, `realname`, `age`, `gender`, `picurl`) VALUES
(47, 'xjl', 'e10adc3949ba59abbe56e057f20f883e', '徐佳乐', '20', '男', NULL),
(46, 'zq', '05d4292e7fd0bd736d337cb69fb79ada', '张奇', '20', '男', NULL);

-- --------------------------------------------------------

--
-- 表的结构 `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `gid` varchar(255) DEFAULT NULL,
  `uid` int(11) DEFAULT NULL,
  `paymoney` float(12,2) DEFAULT NULL,
  `ptime` int(11) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `orders`
--

INSERT INTO `orders` (`id`, `title`, `gid`, `uid`, `paymoney`, `ptime`, `status`) VALUES
(40, '2019061213552546', '1:2', 46, 520.00, 1560318925, '3'),
(39, '2019061213450946', '3:2', 46, 360.00, 1560318309, '1'),
(41, '2019061213570246', '4:1', 46, 120.00, 1560319022, '1'),
(42, '2019061214484546', '4:2', 46, 240.00, 1560322125, '1'),
(43, '2019061214505946', '4:2', 46, 240.00, 1560322259, '3');

-- --------------------------------------------------------

--
-- 表的结构 `scenicspot`
--

CREATE TABLE `scenicspot` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `sort` int(11) DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `scenicspot`
--

INSERT INTO `scenicspot` (`id`, `title`, `sort`) VALUES
(1, '西施故里景区', 1),
(2, '五泄风景区', 2),
(3, '斗岩风景区', 3),
(4, '老鹰山风景区', 4),
(5, '白塔胡国家湿地公园', 5);

-- --------------------------------------------------------

--
-- 表的结构 `shoppingcart`
--

CREATE TABLE `shoppingcart` (
  `id` int(11) NOT NULL,
  `gid` int(3) DEFAULT NULL,
  `buyname` varchar(255) DEFAULT NULL,
  `num` int(3) NOT NULL DEFAULT '1',
  `ptime` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `shoppingcart`
--

INSERT INTO `shoppingcart` (`id`, `gid`, `buyname`, `num`, `ptime`) VALUES
(51, 4, 'zq', 1, 1560322507);

-- --------------------------------------------------------

--
-- 表的结构 `ticket`
--

CREATE TABLE `ticket` (
  `id` int(11) NOT NULL,
  `tid` int(11) DEFAULT '0',
  `title` varchar(255) DEFAULT NULL,
  `content` text,
  `price` float(12,2) DEFAULT '0.00',
  `picurl` varchar(255) DEFAULT NULL,
  `ptime` int(11) DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `ticket`
--

INSERT INTO `ticket` (`id`, `tid`, `title`, `content`, `price`, `picurl`, `ptime`) VALUES
(1, 3, '门票', '原名陡岩。属丹霞地质地貌景区。五泄国家级风景名胜区的组成部分。国家登山队攀岩训练基地。位于浙江绍兴诸暨市城西南部的牌头镇。离市区十五公里，景区面积八平方公里。具有峰、岩、石、洞、泉等旅游资源。斗岩之名说法颇多，主要有三种：一是这里的山岩非常陡峭，当地百姓称之为“陡岩”，“陡”与“斗”在当地音相近。二是此地山峰错落参差，形如北斗七星，北斗被称为“斗宿”，故有此名。三是明开国皇帝朱元璋曾于1365年在此乘大雾发动过“新州大战”，大败张士诚主力，奠定了明天下的建国基础，“斗”这里是打仗的意思。斗岩旅游区的主要景观有斗岩、白云禅寺、天然大佛、汤江岩、凉风洞、张秋人烈士墓和边村祠堂等。\r\n\r\n　　主景斗岩群山蜿蜒起伏，山体沟壑纵横，犹如游龙盘绕。山顶岩石裸露,山岩的形状大多相似呈圆状，山腰之下林木茂盛。斗岩景区以峰险、岩秀、泉清、风凉为特色。斗岩山峰并不十分高大，主峰海拔仅在494米左右，由于地处平原地带，紧邻杭金高速公路，给人以挺拔峥嵘，孤峰插天之感。斗岩南侧1.5公里处为西黄岩，中部有一因山体与岩石长期变动，凹陷而成的巨型岩洞，后人曾在洞中建庙，称为西黄庙。西黄岩高有50米，长100米，颜色呈赭黄。其中有一岩石如猴在四顾，名为“猴头岩”。西黄岩岩顶有“盘陀卧石”，从远处看恰似如鳄鱼出游。从西黄岩远眺斗岩，组成斗岩的众多岩石均呈佛面，故斗岩又有“千佛山”之称。', 260.00, 'uploadfile/2019-06/1559580640WcSGegQsV9Ed.jpg', 0),
(2, 4, '门票', '老鹰山，又名鹞鹰山。位于浙江省诸暨市城西，青山秀丽的老鹰山，不但景美，还是休闲和锻炼的地方，是诸暨市民早晨、周末或假期的一个爬山休闲和户外健身的向往乐地。登上老鹰山，坐拥诸暨，远眺城区，高楼大厦历历在目，诸暨美景尽收眼底。老鹰山位于诸暨旧城区的西北端，也就是丫路头（今三角广场）那一座小山头，海拔59米，1982年建立了烈士陵园，2011年陵园入口处进行移位，2015年又进行了新的整修。整个陵园包括入口处的英雄浮雕、上山的262级台阶、六位著名烈士的塑像、诸暨革命烈士纪念馆、高达8米的革命烈士纪念碑。', 99.00, 'uploadfile/2019-06/1559580629w9d7ELtGa69H.jpg', 0),
(3, 2, '门票', '五泄（Five drainage area），位于诸暨市西30公里群山之中。瀑从五泄山巅的崇崖峻壁间飞流而下，折为五级，总称“五泄溪”。主要由五泄湖、桃源、东源和西源峡谷等四个景区组成。溪两岸异峰怪石，争奇竞秀，有"72峰，36洞，25崖"，壑飞得崖瀑之胜，为国家级森林公园。', 180.00, 'uploadfile/2019-06/1559580571z6kcueUx5NIe.jpg', 0),
(4, 5, '门票', '白塔湖国家湿地公园位于诸暨市北部，是浦阳江流域的一个天然湖荡，是我市最大的生态湿地，公园总面积13.86公顷，其中规划面积8.56公顷。内部共有78个岛屿，呈现“湖中有田、田中有湖、人湖共居”的景象，是一个集自然湿地、农耕湿地、文化湿地于一体的国家湿地公园。', 120.00, 'uploadfile/2019-06/1559580606VxbijcgWIIyB.jpg', 0),
(5, 1, '门票', '西施故里旅游区坐落于西施的故乡——浙江诸暨，是诸暨唯一的国家级风景名胜区――五泄国家重点风景名胜区的重要组成部分。\r\n整个旅游区规划总面积1.85平方公里。按功能划分为一轴一心六区。一轴为南北穿越整个旅游区的浣江游览带，一心指已有一定规模的西施殿景区，六片指主入口管理区、鸬鹚湾古渔村景区、古越文化区、美苑休闲娱乐区、三江口湿地生态保护区、休闲度假区。', 80.00, 'uploadfile/2019-06/15595805824MiT5tCDceD4.jpg', 0);

-- --------------------------------------------------------

--
-- 表的结构 `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(64) NOT NULL,
  `age` varchar(3) DEFAULT NULL,
  `gender` varchar(12) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `age`, `gender`) VALUES
(21, 'zhkey', '05d4292e7fd0bd736d337cb69fb79ada', '20', '男');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `scenicspot`
--
ALTER TABLE `scenicspot`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shoppingcart`
--
ALTER TABLE `shoppingcart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ticket`
--
ALTER TABLE `ticket`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `member`
--
ALTER TABLE `member`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;
--
-- 使用表AUTO_INCREMENT `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;
--
-- 使用表AUTO_INCREMENT `scenicspot`
--
ALTER TABLE `scenicspot`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- 使用表AUTO_INCREMENT `shoppingcart`
--
ALTER TABLE `shoppingcart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;
--
-- 使用表AUTO_INCREMENT `ticket`
--
ALTER TABLE `ticket`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- 使用表AUTO_INCREMENT `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
