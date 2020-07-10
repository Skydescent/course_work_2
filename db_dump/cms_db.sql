-- MySQL dump 10.13  Distrib 8.0.20, for Win64 (x86_64)
--
-- Host: localhost    Database: cms_db
-- ------------------------------------------------------
-- Server version	8.0.15

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `comments` (
  `id` int(12) NOT NULL,
  `text` text COLLATE utf8_bin NOT NULL,
  `post_id` int(12) NOT NULL,
  `author_id` int(12) NOT NULL,
  `is_applied` tinyint(2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `comment_post_id_idx` (`post_id`),
  CONSTRAINT `comment_post_id` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comments`
--

LOCK TABLES `comments` WRITE;
/*!40000 ALTER TABLE `comments` DISABLE KEYS */;
INSERT INTO `comments` VALUES (1,'Отличная статья',1,1,0),(2,'Ставлю лайк статье',1,2,0),(3,'Пишите ещё, очень понравилось',1,3,0);
/*!40000 ALTER TABLE `comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `menu`
--

DROP TABLE IF EXISTS `menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `menu` (
  `id` int(12) NOT NULL,
  `name` varchar(45) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `href` varchar(60) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menu`
--

LOCK TABLES `menu` WRITE;
/*!40000 ALTER TABLE `menu` DISABLE KEYS */;
/*!40000 ALTER TABLE `menu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `posts` (
  `id` int(12) NOT NULL AUTO_INCREMENT,
  `created_at` date NOT NULL,
  `img` varchar(90) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `title` varchar(60) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `text` text CHARACTER SET utf8 COLLATE utf8_bin,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `posts`
--

LOCK TABLES `posts` WRITE;
/*!40000 ALTER TABLE `posts` DISABLE KEYS */;
INSERT INTO `posts` VALUES (1,'2020-05-12','/uploads/img/Gottfrid_af_Bouillon.jpg','Godefroi de Bouillon','Известно, что в молодости Готфрид принимал участие в войне между Генрихом IV и Папой Григорием VII, сражаясь на стороне императора; именно в ходе этого противостояния он впервые продемонстрировал свои военные способности[2].\r\n\r\nПосле поражения Крестового похода бедноты Готфрид Бульонский (к тому времени ставший герцогом Нижней Лотарингии) вместе с братьями Балдуином и Эсташем возглавил организованную армию крестоносцев, двинувшуюся в путь из Лотарингии, рейнских и нижних[3] земель. В это войско принимали как сторонников Папы, так и приверженцев императорской власти, а основную часть армии составляли валлоны[3]. По словам Анны Комниной, численность лотарингских крестоносцев составила 10 тыс. всадников и 70 тыс. пехотинцев, однако эти цифры, скорее всего, завышены[4]. Перед тем, как встать во главе войска, Готфрид продал большую часть своего имущества, включая графство Бульонское[5].\r\n\r\nЛотарингцы выступили в поход первыми, и их предводителям пришлось приложить немало усилий, чтобы преодолеть враждебность жителей Венгрии, которые хорошо помнили бесчинства крестоносцев-простолюдинов. Неподалёку от Белграда Готфрид встретился с послами византийского императора Алексея Комнина, заключив с ними соглашение, согласно которому византийцы обязывались снабжать его армию провизией в обмен на защиту их земель[6]. Этот договор соблюдался до тех пор, пока крестоносцы не вышли к Селимбрии; по неизвестным причинам лотарингцы осадили этот город, взяли его штурмом и разграбили[6]. Встревоженный Алексей приказал Готфриду явиться в Константинополь, дать разъяснения и принести василевсу присягу на верность. Однако герцог, будучи вассалом германского императора, даже не рассматривал возможность такого оммажа; более того, он вовсе не подозревал, что Крестовый поход может рассматриваться как помощь Византии, и ожидал, что сам Алексей со своими силами присоединится к крестоносцам[5]. Поэтому Готфрид отказался от аудиенции, и 23 декабря 1096 года вся лотарингская армия встала под стенами Константинополя[5].\r\n\r\nПытаясь заставить Готфрида подчиниться, Алексей прекратил снабжать крестоносцев провизией, однако когда те начали грабить окрестности города, императору пришлось уступить: он вновь наладил поставки провианта и разрешил лотарингцам стать лагерем в районе Перы и Галаты[5]. Герцог в очередной раз отказался от аудиенции и продолжил ждать прибытия остальных крестоносных войск. Анна Комнина в «Алексиаде» обвиняет Готфрида в том, что он «хотел свергнуть Самодержца и захватить столицу», и сообщает, что Алексей тайно организовал военные отряды, следившие за тем, чтобы лотарингцы не смогли отправить посланцев к Боэмунду Тарентскому или другим предводителям похода[7][8].\r\n\r\n\r\nГотфрид Бульонский и бароны в императорском дворце Алексея I Комнина\r\nИмператор также пригласил ко двору нескольких знатных крестоносцев, надеясь заручиться их поддержкой, однако Готфрид, решив, что Алексей захватил его приближённых, приказал сжечь лагерь в Галате и повёл войска к крепостным валам Константинополя, где между греками и латинянами начались стычки[8]. Если верить Анне Комниной, византийцы пытались избежать боя, однако крестоносцы вынудили их обороняться[9]. В завязавшемся сражении лотарингцы потерпели поражение. Алексей Комнин отправил к герцогу Гуго де Вермандуа, который жил при императорском дворе как почётный гость, чтобы тот уговорил Готфрида сложить оружие и принести василевсу присягу, однако ни проигранный бой, ни увещевания Гуго не смогли переубедить лотарингского феодала[10]. На следующий день состоялось ещё одно сражение между крестоносцами и византийцами, вновь завершившееся разгромом людей Готфрида[10]. Только после этого герцог согласился принять условия Алексея, присягнув ему на верность и поклявшись передать все завоёванные им земли одному из военачальников византийского императора[7]. Он «получил много денег» и «после пышных пиров переправился через пролив», став лагерем близ Пелекана[11]. Перед тем, как принять оммаж, Алексей, следуя византийскому обычаю, формально усыновил Готфрида[12].\r\n\r\n\r\nГотфрида Бульонского ведут к церкви Гроба Господня\r\nКогда в Константинополь прибыли войска других представителей похода, император вынудил Готфрида вернуться ко двору, где он выступал в качестве гаранта исполнения клятвы[13]. Затем герцог принял командование и выступил на Никею в начале мая 1097 года. Он приказал отправить вперёд авангард из трёх тысяч человек, которым поручил вырубить просеку, чтобы армия могла двигаться беспрепятственно, и к середине мая крестоносцы достигли столицы Румского султаната[14].\r\n\r\nПосле взятия Никеи войска франков разделились на два корпуса. Одним из них, шедшим в авангарде, командовал Боэмунд, второй, выступивший позже и состоявший примерно из 30 тысяч воинов, возглавил Готфрид[15].'),(2,'2020-05-11','/uploads/img/Bohemond_I_of_Antioch_(by_Blondel).jpg','Bohémond de Tarente','Боэму́нд Таре́нтский (1054—17 марта 1111) — первый князь Таранто с 1088 года, первый князь Антиохии с 1098 года, один из предводителей Первого Крестового похода. По происхождению норманн, представитель рода Отвилей. Сын Роберта Гвискара, герцога Апулии и Калабрии, двоюродный брат Рожера II, первого короля Сицилийского королевства.\r\n\r\nБоэмунд принимал активное участие в военных кампаниях против Византийской империи, организованных его отцом Робертом Гвискаром. Впоследствии, после смерти Роберта, он вступил в ожесточённое противостояние со своим единокровным братом Рожером и завоевал часть его владений, основав княжество Таранто и став его первым правителем. Однако сравнительно небольшой удел в Италии не мог удовлетворить честолюбия Боэмунда, в связи с чем он присоединился к Крестовому походу в надежде основать на Востоке собственное государство.\r\n\r\nБлагодаря участию в Первом Крестовом походе Боэмунд заслужил репутацию одного из лучших полководцев своего времени. Он захватил Антиохию, тогда находившуюся в руках мусульман, и с согласия других лидеров крестоносцев провозгласил себя её правителем, основав Антиохийское княжество — одно из первых государств крестоносцев на Востоке. Боэмунд вёл непрерывные войны с турками-сельджуками и византийцами, стремясь расширить свои новообретённые владения. В 1100 году он попал в плен к Гази ибн Данишменду, эмиру Каппадокии, и провёл три года в заточении. После освобождения антиохийский князь возобновил войны с соседними государствами, однако успех ему не сопутствовал. Организованный Боэмундом поход против Византии окончился провалом, и князь Тарентский был вынужден признать своё поражение. Сломленный, он вернулся в Италию, где и скончался.\r\n\r\nНесмотря на то, что Боэмунд предпринимал все усилия для укрепления своей власти на Востоке, к концу его правления Антиохийское княжество находилось в состоянии, близком к гибели. Экономика государства была подорвана, военная мощь — сведена на нет после ряда крупных поражений. Современные историки оценивают деятельность Боэмунда I двояко — с одной стороны, они признают его талантливым стратегом и неплохим политиком, с другой же — возлагают на него ответственность за основные неудачи крестоносцев и критикуют за непомерные амбиции, жестокость и алчность.'),(3,'2020-05-06','/uploads/img/800px-Robert_normandie.jpg','Robert Courteheuse','итуация в англо-нормандских отношениях кардинально изменилась в 1096 году. Роберт Куртгёз, воодушевлённый призывами Урбана II на Клермонском соборе, принял решение отправиться в крестовый поход в Палестину[14]. Для финансирования этого мероприятия Роберт обратился за помощью к Вильгельму II. Братья заключили соглашение, согласно которому король Англии предоставлял Роберту займ в размере 10 000 марок серебром, в обеспечение которого Нормандия передавалась на три года в залог Вильгельму II[15]. Получив денежные средства и собрав под своими знамёнами большое число нормандских баронов, Роберт Куртгёз в конце 1096 года отправился в Святую землю. Он избрал путь через Италию и в Диррахии соединился с отрядами Гуго де Вермандуа и Раймунда Тулузского[16]. Во время похода Роберт активно участвовал в осадах и взятии Никеи, Антиохии и Иерусалима, под его руководством был захвачен один из главных портов Сирии — Латакия[17]. Благодаря своему мужеству герцог Нормандский заслужил значительное уважение крестоносцев. Позднее о нём был сложен целый цикл рыцарских романсов.\r\n\r\nПока Роберт находился в Палестине, Нормандия управлялась Вильгельмом II Руфусом. Власть английского короля была гораздо более жёсткой и деспотичной, ему удалось восстановить работоспособность центральной администрации и усмирить баронов. Более того, возобновилась нормандская экспансия в южном направлении: в 1097 году Вильгельм вторгся во французскую часть Вексена, а в 1098 году предпринял поход в Мэн. Хотя Вексен подчинить не удалось — из-за энергичного сопротивления наследника престола Франции Людовика, — в Мэне нормандцам сопутствовал успех, и до конца жизни Вильгельма II это графство оставалось в орбите англонормандского влияния.\r\n\r\nВ конце 1099 года Роберт Куртгёз отправился в обратный путь из Палестины. Остановившись в Южной Италии, он женился на Сибилле, дочери богатого апулийского графа Жоффруа де Конверсана, племянника Роберта Гвискара. Приданое оказалось достаточным, чтобы выкупить Нормандию из залога[18]. Вильгельм II не был готов возвращать герцогство, но 2 августа 1100 году он был убит во время охоты в Нью-Форесте при невыясненных обстоятельствах.');
/*!40000 ALTER TABLE `posts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles` (
  `id` int(12) NOT NULL,
  `name` varchar(45) NOT NULL,
  `description` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'admin','полный доступ'),(2,'manager',' может изменять/создавать статьи и модерирует комментарии к ним'),(3,'registered','может оставлять комментарии'),(4,'unregistered','может просматривать статьи в блоге, подписаться, авторизоваться и зарегистрироваться');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subscribed`
--

DROP TABLE IF EXISTS `subscribed`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `subscribed` (
  `id` int(12) NOT NULL AUTO_INCREMENT,
  `email` varchar(60) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email_UNIQUE` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subscribed`
--

LOCK TABLES `subscribed` WRITE;
/*!40000 ALTER TABLE `subscribed` DISABLE KEYS */;
INSERT INTO `subscribed` VALUES (10,'99@mih.com'),(12,'knght@gmail.com'),(11,'mih@yah.com'),(14,'miha@mih.com');
/*!40000 ALTER TABLE `subscribed` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int(12) NOT NULL AUTO_INCREMENT,
  `login` varchar(60) COLLATE utf8_bin NOT NULL,
  `password` varchar(60) COLLATE utf8_bin NOT NULL,
  `email` varchar(60) COLLATE utf8_bin NOT NULL,
  `role` enum('admin','manager','registered') COLLATE utf8_bin NOT NULL DEFAULT 'registered',
  `img` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `about` text COLLATE utf8_bin,
  PRIMARY KEY (`id`,`role`),
  UNIQUE KEY `login_UNIQUE` (`login`),
  UNIQUE KEY `email_UNIQUE` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (7,'Mih','$2y$10$ZKEZq81IQbau3bk8Kl5L.eXvO.n2bUzwapnLQRq3DsqnorvJWPcKW','miha1977@mih.com','registered','/uploads/img/Mih_cross.jpg','Здравствуйте! Я любитель истории крестовых походов '),(8,'Nikky','$2y$10$lklg.6MOYoDBn6gDeHCD5.j3ffJ17YbFRKJ3M7Lptji6YuPNprgVu','nikky@mail.ru','registered','','Интересуюсь первым и четвёртым крестовыми походами'),(9,'Kirill','$2y$10$9gWOCpPQf5CHCKNBS6hfm.eDljyVTZpK2wP5x/Qif87lzDSZU6xv6','kir@mail.ru','registered','','Deus vult!'),(10,'Monk','$2y$10$gTcPb40YRCZdcgpx9tB5jusGMNefUi6x8J.YzHXKr01lQOiFO38ku','mnk@mail.ru','registered','',''),(11,'Knight','$2y$10$Gw4qhGcCdmXKl2PQVonKp.YQyGUnQ1ECg3HOqqrTSKau1GHleaSsq','knght@gmail.com','registered','',''),(12,'Volodiya','$2y$10$wAJLRW7jwlkVXjkq.GE2Jux4qY6CEMEW//CvvIL2nJ9.5OcNceMci','volod@gmail.com','registered','','');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'cms_db'
--

--
-- Dumping routines for database 'cms_db'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-07-10 17:33:06
