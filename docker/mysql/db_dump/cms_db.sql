-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Окт 20 2020 г., 03:09
-- Версия сервера: 8.0.15
-- Версия PHP: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `cms_db`
--

-- --------------------------------------------------------

--
-- Структура таблицы `comments`
--

CREATE TABLE `comments` (
  `id` int(12) NOT NULL,
  `text` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `post_id` int(12) NOT NULL,
  `author_id` int(12) NOT NULL,
  `is_applied` tinyint(2) NOT NULL,
  `created_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Дамп данных таблицы `comments`
--

INSERT INTO `comments` (`id`, `text`, `post_id`, `author_id`, `is_applied`, `created_at`) VALUES
(1, 'Отличная статья', 1, 7, 0, '2020-06-20'),
(2, 'Ставлю лайк статье', 1, 9, 0, '2020-06-23'),
(3, 'Пишите ещё, очень понравилось', 1, 8, 1, '2020-07-03'),
(4, 'Супер!', 1, 13, 1, '2020-07-11'),
(5, 'Ничего, нормально', 2, 7, 1, '2020-07-11'),
(6, 'Интересная статья, что было дальше?', 14, 20, 0, '2020-10-11');

-- --------------------------------------------------------

--
-- Структура таблицы `menu`
--

CREATE TABLE `menu` (
  `id` int(12) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `href` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Структура таблицы `pages`
--

CREATE TABLE `pages` (
  `id` int(12) NOT NULL,
  `alias` varchar(255) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `text` text NOT NULL,
  `is_active` tinyint(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Дамп данных таблицы `pages`
--

INSERT INTO `pages` (`id`, `alias`, `title`, `text`, `is_active`) VALUES
(1, 'static255', 'Статическая страница1', 'Sed ut perspiciatis, unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam eaque ipsa, quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt, explicabo. Nemo enim ipsam voluptatem, quia voluptas sit, aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos, qui ratione voluptatem sequi nesciunt, neque porro quisquam est...', 1),
(2, 'static2', 'Статическая страница2', 'Sed ut perspiciatis, unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam eaque ipsa, quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt, explicabo. Nemo enim ipsam voluptatem, quia voluptas sit, aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos, qui ratione voluptatem sequi nesciunt, neque porro quisquam est, qui dolorem ipsum, quia dolor sit, amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt, ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit, qui in ea voluptate velit esse, quam nihil molestiae consequatur, vel illum, qui dolorem eum fugiat, quo voluptas nulla pariatur? At vero eos et accusamus et iusto odio dignissimos ducimus, qui blanditiis praesentium voluptatum deleniti atque corrupti, quos dolores et quas molestias excepturi sint, obcaecati cupiditate non provident, similique sunt in culpa, qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio, cumque nihil impedit, quo minus id, quod maxime placeat, facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet, ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat.', 1),
(3, 'about', 'О нас', 'Немного о нас', 1),
(4, 'contacts', 'Контакты', 'Наши контакты', 1),
(5, 'history', 'Наша история', 'Наш блог был создан в далёком 2007 году', 1),
(6, 'all_new', 'Самое новое', 'Всё самое новое здесь', 1),
(7, 'rules', 'Правила сайта', 'Все материалы сайта относятся к интеллектуальной собственности, защищенной авторскими правами согласно части IV Гражданского кодекса РФ.\r\n\r\nСкачивать и распространять материал в сети Интернет и использовать материал любым другим способом, кроме личного пользования, без согласия автора, запрещается.\r\n\r\nНастоящее пользовательское соглашение (именуемое в дальнейшем «Соглашение») является юридически обязательным соглашением и регулирует отношения между сайтом DeusPost.ru, именуемым в дальнейшем &quot;Сайт&quot; или &quot;Администрация Сайта&quot;, и Вами - физическим или юридическим лицом, именуемым в дальнейшем «Пользователь» или «Вы», по пользованию Сайтом, его информационного наполнения, а также услугами и/или работами, указанными в настоящем Соглашении. Сайт оставляет за собой право в одностороннем порядке изменить, полностью или частично, условия настоящего Соглашения без уведомления Вас об этом. Изменения в Соглашение вступают в силу немедленно, после опубликования Соглашения на сайте. Ознакомиться с действующей версией настоящего Соглашения, Вы можете на Сайте, в разделе &quot;Правила сайта&quot;.\r\n\r\nПеред использованием ресурсов сайта, ознакомьтесь с основными правилами сайта, нажав здесь 1. Основные понятия, используемые в Соглашении Сайт - совокупность веб-страниц, размещенных на виртуальном сервере и образующих единую структуру веб-сайта http://www.DeusPost.ru (далее – «Сайт»), а также совокупность расположенных на веб-сайте информационных материалов; Файл - файл в формате PDF (.pdf), содержащий в себе обучающую информацию состоящую из текста и графических изображений (рисунков, фотографий и т.п.).\r\n\r\n2. ПРЕДМЕТ СОГЛАШЕНИЯ\r\n\r\n2.1.1. Настоящее Соглашение определяет условия предоставления Пользователю Сервисов и пользования Сайтами.\r\n\r\n2.1.2. Настоящее Соглашение считается заключенным с момента начала использования Сервисов и материалов Сайтов или с момента, когда Вы подтверждаете Ваше согласие с условиями данного Соглашения. Соглашение сохраняет силу в течение всего срока работы Сервисов и Сайтов. Если Вы не согласны с условиями настоящего Соглашения, не используйте Сайт и/или сервисы Сайта.\r\n\r\n3. ОБЯЗАТЕЛЬСТВА СТОРОН\r\n\r\n3.1. Права и обязанности Сайта\r\n\r\n3.1.1. Сайт предоставляет Пользователю возможность пользования Сайтом.\r\n\r\n3.1.2. Сайт оставляет за собой право видоизменять стоимость, информацию, предоставляемые услуги или работы в любое время без предварительного уведомления Пользователя.\r\n\r\n4. КОНФИДЕНЦИАЛЬНОСТЬ\r\n\r\n4.1 При регистрации на Сайте, а равно при заполнении любых Заказов, содержащих персональную информацию (регистрационные данные), Пользователь обязуется предоставить достоверную информацию, а при изменении такой информации - внести необходимые поправки в свои регистрационные данные. В свою очередь Администрация Сайта принимает на себя обязательство не разглашать информацию о персональных данных и иной коммерческой информации Пользователей, сообщенных ими посредством Сайта.\r\n\r\n6. ОГРАНИЧЕНИЕ ОТВЕТСТВЕННОСТИ\r\n\r\n6.1. Сайт не несет никаких обязательств по наличию и качеству доступа Пользователя в Интернет, наличию и качеству соответствующего оборудования и необходимого ПО для доступа в Интернет. Сайт не несёт ответственность за любые сбои или иные проблемы любых телефонных сетей или служб, компьютерных систем, серверов или провайдеров, компьютерного или телефонного оборудования, программного обеспечения, сбоев электронной почты или скриптов (программ) по каким-либо причинам. Сайт не несет ответственности за воспроизведение видео материала опубликованного на сайте на мобильных устройствах и гаджетах пользователей. Сайт не несет ответственности за Лимитный и/или платный тарифный план пользователя.\r\n\r\n6.3. Администрация Сайта не гарантирует, что Сайт будет отвечать Вашим требованиям, что он не содержит ошибок, или что он всегда будет доступен в любое время. Мы не гарантируем, что вся информация на сайте не содержат ошибок. Мы не гарантируем, что Вы сможете осуществить доступ к Сайту или использовать его (напрямую или через сторонние сети) в любое удобное для Вас время и из любого места по Вашему выбору.\r\n\r\n6.4. Администрация Сайта оставляет за собой право в любое время и без уведомления закрыть или изменить любую информацию, сервис, услугу на Сайте.\r\n\r\n7. АВТОРСКОЕ ПРАВО\r\n\r\n7.1 Авторские права на все материалы, документы, данного сайта или на их части (текстовая информация, графические изображения, фотографии, являющиеся объектами авторского права), находящиеся или использующиеся на сайте, принадлежат их автору и/или владельцу сайта www.DeusPost.ru и охраняются на основании международных конвенций об авторском праве и действующего законодательства Российской Федерации. Копирование и использование информации, разрешается только при условии личного использования информации и нераспространении полученной с сайта информации любым способом.\r\n\r\n7.2. Копирование, распространение (в сети интернет, в печатных изданиях, на дисках, на любых других информационных носителях и т.п.) любого материала, содержащегося на этом сайте, может стать нарушением законов об авторских правах, торговых знаков, законов о защите информации личного характера и о гласности, а также правил и положений в области средств связи. Пользуясь данным сайтом, пользователь подтверждает, что он полностью согласен с настоящими Условиями пользования сайтом и с тем, о чем было написано выше.', 1),
(24, 'static36', 'Новая статья', 'Sed ut perspiciatis, unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam eaque ipsa, quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt, explicabo. Nemo enim ipsam voluptatem, quia voluptas sit, aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos, qui ratione voluptatem sequi nesciunt, neque porro quisquam est...', 1),
(25, 'new_stat', 'Новая приновая страница', 'Sed ut perspiciatis, unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam eaque ipsa, quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt, explicabo. Nemo enim ipsam voluptatem, quia voluptas sit, aspernatur aut odit aut fugit, sed quia consequ', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `posts`
--

CREATE TABLE `posts` (
  `id` int(12) NOT NULL,
  `user_id` int(12) NOT NULL,
  `created_at` date NOT NULL,
  `img` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `text` text CHARACTER SET utf8 COLLATE utf8_bin,
  `is_active` tinyint(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Дамп данных таблицы `posts`
--

INSERT INTO `posts` (`id`, `user_id`, `created_at`, `img`, `title`, `text`, `is_active`) VALUES
(1, 8, '2020-05-12', '/uploads/img/Gottfrid_af_Bouillon.jpg', 'Godefroi de Bouillon', 'Известно, что в молодости Готфрид принимал участие в войне между Генрихом IV и Папой Григорием VII, сражаясь на стороне императора; именно в ходе этого противостояния он впервые продемонстрировал свои военные способности[2].\r\n\r\nПосле поражения Крестового похода бедноты Готфрид Бульонский (к тому времени ставший герцогом Нижней Лотарингии) вместе с братьями Балдуином и Эсташем возглавил организованную армию крестоносцев, двинувшуюся в путь из Лотарингии, рейнских и нижних[3] земель. В это войско принимали как сторонников Папы, так и приверженцев императорской власти, а основную часть армии составляли валлоны[3]. По словам Анны Комниной, численность лотарингских крестоносцев составила 10 тыс. всадников и 70 тыс. пехотинцев, однако эти цифры, скорее всего, завышены[4]. Перед тем, как встать во главе войска, Готфрид продал большую часть своего имущества, включая графство Бульонское[5].\r\n\r\nЛотарингцы выступили в поход первыми, и их предводителям пришлось приложить немало усилий, чтобы преодолеть враждебность жителей Венгрии, которые хорошо помнили бесчинства крестоносцев-простолюдинов. Неподалёку от Белграда Готфрид встретился с послами византийского императора Алексея Комнина, заключив с ними соглашение, согласно которому византийцы обязывались снабжать его армию провизией в обмен на защиту их земель[6]. Этот договор соблюдался до тех пор, пока крестоносцы не вышли к Селимбрии; по неизвестным причинам лотарингцы осадили этот город, взяли его штурмом и разграбили[6]. Встревоженный Алексей приказал Готфриду явиться в Константинополь, дать разъяснения и принести василевсу присягу на верность. Однако герцог, будучи вассалом германского императора, даже не рассматривал возможность такого оммажа; более того, он вовсе не подозревал, что Крестовый поход может рассматриваться как помощь Византии, и ожидал, что сам Алексей со своими силами присоединится к крестоносцам[5]. Поэтому Готфрид отказался от аудиенции, и 23 декабря 1096 года вся лотарингская армия встала под стенами Константинополя[5].\r\n\r\nПытаясь заставить Готфрида подчиниться, Алексей прекратил снабжать крестоносцев провизией, однако когда те начали грабить окрестности города, императору пришлось уступить: он вновь наладил поставки провианта и разрешил лотарингцам стать лагерем в районе Перы и Галаты[5]. Герцог в очередной раз отказался от аудиенции и продолжил ждать прибытия остальных крестоносных войск. Анна Комнина в «Алексиаде» обвиняет Готфрида в том, что он «хотел свергнуть Самодержца и захватить столицу», и сообщает, что Алексей тайно организовал военные отряды, следившие за тем, чтобы лотарингцы не смогли отправить посланцев к Боэмунду Тарентскому или другим предводителям похода[7][8].\r\n\r\n\r\nГотфрид Бульонский и бароны в императорском дворце Алексея I Комнина\r\nИмператор также пригласил ко двору нескольких знатных крестоносцев, надеясь заручиться их поддержкой, однако Готфрид, решив, что Алексей захватил его приближённых, приказал сжечь лагерь в Галате и повёл войска к крепостным валам Константинополя, где между греками и латинянами начались стычки[8]. Если верить Анне Комниной, византийцы пытались избежать боя, однако крестоносцы вынудили их обороняться[9]. В завязавшемся сражении лотарингцы потерпели поражение. Алексей Комнин отправил к герцогу Гуго де Вермандуа, который жил при императорском дворе как почётный гость, чтобы тот уговорил Готфрида сложить оружие и принести василевсу присягу, однако ни проигранный бой, ни увещевания Гуго не смогли переубедить лотарингского феодала[10]. На следующий день состоялось ещё одно сражение между крестоносцами и византийцами, вновь завершившееся разгромом людей Готфрида[10]. Только после этого герцог согласился принять условия Алексея, присягнув ему на верность и поклявшись передать все завоёванные им земли одному из военачальников византийского императора[7]. Он «получил много денег» и «после пышных пиров переправился через пролив», став лагерем близ Пелекана[11]. Перед тем, как принять оммаж, Алексей, следуя византийскому обычаю, формально усыновил Готфрида[12].\r\n\r\n\r\nГотфрида Бульонского ведут к церкви Гроба Господня\r\nКогда в Константинополь прибыли войска других представителей похода, император вынудил Готфрида вернуться ко двору, где он выступал в качестве гаранта исполнения клятвы[13]. Затем герцог принял командование и выступил на Никею в начале мая 1097 года. Он приказал отправить вперёд авангард из трёх тысяч человек, которым поручил вырубить просеку, чтобы армия могла двигаться беспрепятственно, и к середине мая крестоносцы достигли столицы Румского султаната[14].\r\n\r\nПосле взятия Никеи войска франков разделились на два корпуса. Одним из них, шедшим в авангарде, командовал Боэмунд, второй, выступивший позже и состоявший примерно из 30 тысяч воинов, возглавил Готфрид[15].', 1),
(2, 10, '2020-05-11', '/uploads/img/Bohemond_I_of_Antioch_(by_Blondel).jpg', 'Bohémond de Tarente', 'Боэму́нд Таре́нтский (1054—17 марта 1111) — первый князь Таранто с 1088 года, первый князь Антиохии с 1098 года, один из предводителей Первого Крестового похода. По происхождению норманн, представитель рода Отвилей. Сын Роберта Гвискара, герцога Апулии и Калабрии, двоюродный брат Рожера II, первого короля Сицилийского королевства.\r\n\r\nБоэмунд принимал активное участие в военных кампаниях против Византийской империи, организованных его отцом Робертом Гвискаром. Впоследствии, после смерти Роберта, он вступил в ожесточённое противостояние со своим единокровным братом Рожером и завоевал часть его владений, основав княжество Таранто и став его первым правителем. Однако сравнительно небольшой удел в Италии не мог удовлетворить честолюбия Боэмунда, в связи с чем он присоединился к Крестовому походу в надежде основать на Востоке собственное государство.\r\n\r\nБлагодаря участию в Первом Крестовом походе Боэмунд заслужил репутацию одного из лучших полководцев своего времени. Он захватил Антиохию, тогда находившуюся в руках мусульман, и с согласия других лидеров крестоносцев провозгласил себя её правителем, основав Антиохийское княжество — одно из первых государств крестоносцев на Востоке. Боэмунд вёл непрерывные войны с турками-сельджуками и византийцами, стремясь расширить свои новообретённые владения. В 1100 году он попал в плен к Гази ибн Данишменду, эмиру Каппадокии, и провёл три года в заточении. После освобождения антиохийский князь возобновил войны с соседними государствами, однако успех ему не сопутствовал. Организованный Боэмундом поход против Византии окончился провалом, и князь Тарентский был вынужден признать своё поражение. Сломленный, он вернулся в Италию, где и скончался.\r\n\r\nНесмотря на то, что Боэмунд предпринимал все усилия для укрепления своей власти на Востоке, к концу его правления Антиохийское княжество находилось в состоянии, близком к гибели. Экономика государства была подорвана, военная мощь — сведена на нет после ряда крупных поражений. Современные историки оценивают деятельность Боэмунда I двояко — с одной стороны, они признают его талантливым стратегом и неплохим политиком, с другой же — возлагают на него ответственность за основные неудачи крестоносцев и критикуют за непомерные амбиции, жестокость и алчность.', 1),
(3, 9, '2020-05-06', '/uploads/img/800px-Robert_normandie.jpg', 'Robert Courteheuse', 'итуация в англо-нормандских отношениях кардинально изменилась в 1096 году. Роберт Куртгёз, воодушевлённый призывами Урбана II на Клермонском соборе, принял решение отправиться в крестовый поход в Палестину[14]. Для финансирования этого мероприятия Роберт обратился за помощью к Вильгельму II. Братья заключили соглашение, согласно которому король Англии предоставлял Роберту займ в размере 10 000 марок серебром, в обеспечение которого Нормандия передавалась на три года в залог Вильгельму II[15]. Получив денежные средства и собрав под своими знамёнами большое число нормандских баронов, Роберт Куртгёз в конце 1096 года отправился в Святую землю. Он избрал путь через Италию и в Диррахии соединился с отрядами Гуго де Вермандуа и Раймунда Тулузского[16]. Во время похода Роберт активно участвовал в осадах и взятии Никеи, Антиохии и Иерусалима, под его руководством был захвачен один из главных портов Сирии — Латакия[17]. Благодаря своему мужеству герцог Нормандский заслужил значительное уважение крестоносцев. Позднее о нём был сложен целый цикл рыцарских романсов.\r\n\r\nПока Роберт находился в Палестине, Нормандия управлялась Вильгельмом II Руфусом. Власть английского короля была гораздо более жёсткой и деспотичной, ему удалось восстановить работоспособность центральной администрации и усмирить баронов. Более того, возобновилась нормандская экспансия в южном направлении: в 1097 году Вильгельм вторгся во французскую часть Вексена, а в 1098 году предпринял поход в Мэн. Хотя Вексен подчинить не удалось — из-за энергичного сопротивления наследника престола Франции Людовика, — в Мэне нормандцам сопутствовал успех, и до конца жизни Вильгельма II это графство оставалось в орбите англонормандского влияния.\r\n\r\nВ конце 1099 года Роберт Куртгёз отправился в обратный путь из Палестины. Остановившись в Южной Италии, он женился на Сибилле, дочери богатого апулийского графа Жоффруа де Конверсана, племянника Роберта Гвискара. Приданое оказалось достаточным, чтобы выкупить Нормандию из залога[18]. Вильгельм II не был готов возвращать герцогство, но 2 августа 1100 году он был убит во время охоты в Нью-Форесте при невыясненных обстоятельствах.', 1),
(10, 7, '2020-09-26', '/uploads/img/_Без названия (1).jpg', 'Тестовая статья дополнительно', 'Sed ut perspiciatis, unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam eaque ipsa, quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt, explicabo. Nemo enim ipsam voluptatem, quia voluptas sit, aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos, qui ratione voluptatem sequi nesciunt, neque porro quisquam est, qui dolorem ipsum, quia dolor sit, amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt, ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit, qui in ea voluptate velit esse, quam nihil molestiae consequatur, vel illum, qui dolorem eum fugiat, quo voluptas nulla pariatur? At vero eos et accusamus et iusto odio dignissimos ducimus, qui blanditiis praesentium voluptatum deleniti atque corrupti, quos dolores et quas molestias excepturi sint, obcaecati cupiditate non provident, similique sunt in culpa, qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio, cumque nihil impedit, quo minus id, quod maxime placeat, facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet, ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat.', 1),
(14, 7, '2020-10-02', '/uploads/img/post_crossies.jpg', 'Новая статья Lorem Ipsum', 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?', 1),
(15, 7, '2020-10-02', '/uploads/img/post_dengi-armflot4.jpg', 'Ещё одна статья Lorem ipsum', 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?', 1),
(17, 7, '2020-10-02', '/uploads/img/post06_31_06_krest.jpg', 'Sed ut perspiciatis unde omnis iste natus', 'But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you a complete account of the system, and expound the actual teachings of the great explorer of the truth, the master-builder of human happiness. No one rejects, dislikes, or avoids pleasure itself, because it is pleasure, but because those who do not know how to pursue pleasure rationally encounter consequences that are extremely painful. Nor again is there anyone who loves or pursues or desires to obtain pain of itself, because it is pain, but because occasionally circumstances occur in which toil and pain can procure him some great pleasure. To take a trivial example, which of us ever undertakes laborious physical exercise, except to obtain some advantage from it? But who has any right to find fault with a man who chooses to enjoy a pleasure that has no annoying consequences, or one who avoids a pain that produces no resultant pleasure?', 1),
(19, 20, '2020-10-11', '/uploads/img/post04_50_17_terraoko-2015020207-5.jpg', 'Новая статья о крестовых походах в Блоге', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 1),
(20, 20, '2020-10-11', '', 'Статья на Deus_Post', 'But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you a complete account of the system, and expound the actual teachings of the great explorer of the truth, the master-builder of human happiness. No one rejects, dislikes, or avoids pleasure itself, because it is pleasure, but because those who do not know how to pursue pleasure rationally encounter consequences that are extremely painful. Nor again is there anyone who loves or pursues or desires to obtain pain of itself, because it is pain, but because occasionally circumstances occur in which toil and pain can procure him some great pleasure. To take a trivial example, which of us ever undertakes laborious physical exercise, except to obtain some advantage from it? But who has any right to find fault with a man who chooses to enjoy a pleasure that has no annoying consequences, or one who avoids a pain that produces no resultant pleasure?', 1),
(21, 7, '2020-10-14', '/uploads/img/post07_04_55_crossies.jpg', 'Новая статья 451', 'Sed ut perspiciatis, unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam eaque ipsa, quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt, explicabo. Nemo enim ipsam voluptatem, quia voluptas sit, aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos, qui ratione voluptatem sequi nesciunt, neque porro quisquam est, qui dolorem ipsum, quia dolor sit, amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt, ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel e', 1),
(22, 7, '2020-10-14', '', 'Тестовая статья111', 'Sed ut perspiciatis, unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam eaque ipsa, quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt, explicabo. Nemo enim ipsam voluptatem, quia voluptas sit, aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos, qui ratione voluptatem sequi nesciunt, neque porro quisquam est, qui dolorem ipsum, quia dolor sit, amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt, ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit, qui in ea voluptate velit esse, quam nihil molestiae consequatur, vel illum, qui dolorem eum fugiat, quo voluptas nulla pariatur? At vero eos et accusamus et iusto odio dignissimos ducimus, qui blanditiis praesentium voluptatum deleniti atque corrupti, quos dolores et quas molestias excepturi sint, obcaecati cupiditate non provident, similique sunt in culpa, qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio, cumque nihil impedit, quo minus id, quod maxime placeat, facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet, ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat.', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `roles`
--

CREATE TABLE `roles` (
  `id` int(12) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `roles`
--

INSERT INTO `roles` (`id`, `name`, `description`) VALUES
(1, 'admin', 'полный доступ'),
(2, 'manager', ' может изменять/создавать статьи и модерирует комментарии к ним'),
(3, 'registered', 'может оставлять комментарии'),
(4, 'unregistered', 'может просматривать статьи в блоге, подписаться, авторизоваться и зарегистрироваться');

-- --------------------------------------------------------

--
-- Структура таблицы `settings`
--

CREATE TABLE `settings` (
  `id` int(12) NOT NULL,
  `parent_id` int(12) DEFAULT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Дамп данных таблицы `settings`
--

INSERT INTO `settings` (`id`, `parent_id`, `name`) VALUES
(2, 4, 'maxSize'),
(3, 2, '1048576'),
(4, NULL, 'file'),
(5, NULL, 'pagination'),
(6, 5, 'selects'),
(7, 6, 'default'),
(8, 7, '3'),
(12, 6, '4'),
(13, 6, '2'),
(14, 6, '5'),
(15, 2, 'default'),
(16, 15, '614400'),
(17, 2, '307200'),
(18, 2, '2097152'),
(19, 2, '5242880');

-- --------------------------------------------------------

--
-- Структура таблицы `subscribed`
--

CREATE TABLE `subscribed` (
  `id` int(12) NOT NULL,
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `is_active` tinyint(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Дамп данных таблицы `subscribed`
--

INSERT INTO `subscribed` (`id`, `email`, `is_active`) VALUES
(12, 'knght@gmail.com', 0),
(14, 'miha@mih.com', 1),
(15, 'mih@gmail.com', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(12) NOT NULL,
  `role_id` int(12) NOT NULL,
  `login` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `password` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `img` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `about` text CHARACTER SET utf8 COLLATE utf8_bin,
  `is_active` tinyint(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `role_id`, `login`, `password`, `email`, `img`, `about`, `is_active`) VALUES
(7, 1, 'Mih', '$2y$10$e4cA5yOsUehHB9imOz7RYO1HFf.Ge4nyR0wGO1ognmoW3u7MKFbIm', 'mih@gmail.com', '/uploads/img/Mih_crs.jpeg', 'Здравствуйте! Я любитель истории крестовых походов. Особенно люблю первый крестовый поход:)', 1),
(8, 2, 'Nikky', '$2y$10$J5dP7GyUZwO/8fjdw/eyWOr11rbIELi9vwJ5cWsEXjujnXKM.UQJS', 'nikky@mail.ru', '/uploads/img/Nikky_Без названия.jpg', 'Интересуюсь первым и четвёртым крестовыми походами', 1),
(9, 3, 'Kirill', '$2y$10$9gWOCpPQf5CHCKNBS6hfm.eDljyVTZpK2wP5x/Qif87lzDSZU6xv6', 'kir@mail.ru', '/uploads/img/Kirill_cross.jpg', 'Deus vult!', 0),
(10, 3, 'Monk', '$2y$10$gTcPb40YRCZdcgpx9tB5jusGMNefUi6x8J.YzHXKr01lQOiFO38ku', 'mnk@mail.ru', '/uploads/img/Monk_crusader.png', '', 1),
(11, 3, 'Knight', '$2y$10$Gw4qhGcCdmXKl2PQVonKp.YQyGUnQ1ECg3HOqqrTSKau1GHleaSsq', 'knght@gmail.com', '/uploads/img/Knight_krestonosec2.jpg', '', 1),
(12, 3, 'Volodiya', '$2y$10$wAJLRW7jwlkVXjkq.GE2Jux4qY6CEMEW//CvvIL2nJ9.5OcNceMci', 'volod@gmail.com', '/uploads/img/Volodiya_crusader.png', '', 1),
(13, 3, 'Grom', '$2y$10$LUhx98T4W9acH6EbstAXregk3yt/C8YGXihfQG8GhGKbBwhtlxZ2K', 'grm@mail.ru', '/uploads/img/Grom_cross.jpg', '', 1),
(14, 3, 'Bob', '$2y$10$QLhaEQ58f.3XW6tp2CyhoeCTWkHvFExEpExshNzl1aIVg8z1.sLSG', 'bob13@yah.com', '/uploads/img/Bob_crs.jpeg', 'My name is Bob!', 1),
(15, 3, 'Soul', '$2y$10$HIXBxy2gZRf7nffTnApLzOVQmV21llyVbEemjI6iCUCbw6modYSG2', 'soul@goodman.com', '/uploads/img/Soul_Без названия (1).jpg', '', 1),
(16, 3, 'Slim', '$2y$10$et8ROEyhfY8ahCmG1YGgye8Km4tveke0bHKc1vkPdWwL/O7HhdM/W', 'slim@fit.com', '/uploads/img/Slim_terraoko-2015020207-5.jpg', '', 1),
(18, 3, 'Kir87', '$2y$10$tOOgVVaTXaQD/hQ7H6mhkO7khQLiNjyHrw2gRptiiNK0DhJGyorJu', 'krl@yahoo.com', '/uploads/img/Kir87_crs.jpeg', '', 1),
(19, 3, 'Mihasu', '$2y$10$WtdssHWQf3n.ycLIwXG3POSLJi1jgKXhYWHXkK7u2C0TShxWTO8fq', 'mihasu@gmail.com', '', '', 1),
(20, 3, 'Little', '$2y$10$QQPnQab5YbbE.tylLPNLyuxozYc53nCV/HDRkVi209wuCbc9dvMGG', 'little@mail.ru', '', '', 1),
(21, 3, 'Konst', '$2y$10$pLg4XQS4pgdhN3UUcY1TE.JeIDA1pmNSBFGTZ.O.Bw3SiQOmHVR7S', 'konst@gmail.com', '/uploads/img/Konst_Без названия.jpg', '', 1);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comment_post_id_idx` (`post_id`);

--
-- Индексы таблицы `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `subscribed`
--
ALTER TABLE `subscribed`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email_UNIQUE` (`email`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `login_UNIQUE` (`login`),
  ADD UNIQUE KEY `email_UNIQUE` (`email`),
  ADD KEY `role_id_idx` (`role_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `pages`
--
ALTER TABLE `pages`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT для таблицы `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT для таблицы `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT для таблицы `subscribed`
--
ALTER TABLE `subscribed`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comment_post_id` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`);

--
-- Ограничения внешнего ключа таблицы `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `role_id` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
