-- phpMyAdmin SQL Dump
-- version 4.7.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: 17.06.2018 klo 02:19
-- Palvelimen versio: 5.6.36
-- PHP Version: 7.0.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `feleroidco_cms`
--

-- --------------------------------------------------------

--
-- Rakenne taululle `categories`
--

CREATE TABLE `categories` (
  `cat_id` int(3) NOT NULL,
  `cat_title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Vedos taulusta `categories`
--

INSERT INTO `categories` (`cat_id`, `cat_title`) VALUES
(2, 'JavaScript'),
(3, 'PHP'),
(4, 'Java'),
(17, 'HTML5'),
(19, 'CSS3'),
(20, 'AutoIt'),
(21, 'GML'),
(22, 'Python');

-- --------------------------------------------------------

--
-- Rakenne taululle `comments`
--

CREATE TABLE `comments` (
  `comment_id` int(3) NOT NULL,
  `comment_post_id` int(3) NOT NULL,
  `comment_author` varchar(255) NOT NULL,
  `comment_email` varchar(255) NOT NULL,
  `comment_content` text NOT NULL,
  `comment_status` varchar(255) NOT NULL,
  `comment_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Vedos taulusta `comments`
--

INSERT INTO `comments` (`comment_id`, `comment_post_id`, `comment_author`, `comment_email`, `comment_content`, `comment_status`, `comment_date`) VALUES
(20, 108, 'Guest', 'guest@example.com', 'Thank you for submitting a very informative article about Bootstrap!', 'approved', '2018-06-15'),
(21, 108, 'Joni Lähdesmäki', 'joni.lahdesmaki@hotmail.fi', 'You are welcome! :)', 'approved', '2018-06-15'),
(22, 107, 'anonymous', 'anon@example.com', 'HTML5 is so much better than the old HTML!', 'approved', '2018-06-15'),
(23, 106, 'Guest56', 'guest54@test.org', 'I have not used CSS3 yet.', 'unapproved', '2018-06-15'),
(24, 115, 'Joni Lähdesmäki', 'joni.lahdesmaki@hotmail.fi', 'I would like to learn Sass! I think it would be better than Less, which I have already learnt.', 'approved', '2018-06-15'),
(25, 110, 'Guest', 'guest@example.org', 'That elephant looks awesome! However the article could be a little more descriptive, because I\'d like to learn PHP.', 'approved', '2018-06-15');

-- --------------------------------------------------------

--
-- Rakenne taululle `posts`
--

CREATE TABLE `posts` (
  `post_id` int(4) NOT NULL,
  `post_category_id` int(4) NOT NULL,
  `post_title` varchar(255) NOT NULL,
  `post_author` varchar(255) NOT NULL,
  `post_user` varchar(255) NOT NULL,
  `post_date` date NOT NULL,
  `post_image` text NOT NULL,
  `post_content` text NOT NULL,
  `post_tags` varchar(255) NOT NULL,
  `post_comment_count` int(11) NOT NULL,
  `post_status` varchar(255) NOT NULL DEFAULT 'draft',
  `post_views_count` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Vedos taulusta `posts`
--

INSERT INTO `posts` (`post_id`, `post_category_id`, `post_title`, `post_author`, `post_user`, `post_date`, `post_image`, `post_content`, `post_tags`, `post_comment_count`, `post_status`, `post_views_count`) VALUES
(106, 19, 'CSS3 ', '', 'JoniLah', '2018-06-15', 'css3.png', '<p><strong>CSS3</strong> is the latest evolution of the <i>Cascading Style Sheets</i> language and aims at extending CSS2.1. It brings a lot of long-awaited novelties, like rounded corners, shadows, <a href=\"https://developer.mozilla.org/en-US/docs/Web/Guide/CSS/Using_CSS_gradients\">gradients</a>, <a href=\"https://developer.mozilla.org/en-US/docs/Web/Guide/CSS/Using_CSS_transitions\">transitions</a> or <a href=\"https://developer.mozilla.org/en-US/docs/Web/Guide/CSS/Using_CSS_animations\">animations</a>, as well as new layouts like <a href=\"https://developer.mozilla.org/en-US/docs/Web/Guide/CSS/Using_multi-column_layouts\">multi-columns</a>, <a href=\"https://developer.mozilla.org/en-US/docs/Web/Guide/CSS/Flexible_boxes\">flexible box</a> or grid layouts. Experimental parts are vendor-prefixed and should either be avoided in production environments, or used with extreme caution as both their syntax and semantics can change in the future.</p>', 'css3, cascading style sheets', 0, 'published', 6),
(107, 17, 'HTML5', '', 'JoniLah', '2018-06-15', 'html5.png', '<p>HTML5 is the latest evolution of the standard that defines <a href=\"https://developer.mozilla.org/en-US/docs/HTML\">HTML</a>. The term represents two different concepts. It is a new version of the language HTML, with new elements, attributes, and behaviors, <strong>and</strong> a larger set of technologies that allows the building of more diverse and powerful Web sites and applications. This set is sometimes called HTML5 &amp; friends and often shortened to just HTML5.</p>', 'html5, web', 0, 'published', 4),
(108, 17, 'Bootstrap', '', 'JoniLah', '2018-06-15', 'bootstrap.png', '<p>Build responsive, mobile-first projects on the web with the world\'s most popular front-end component library.</p><p>Bootstrap is an open source toolkit for developing with HTML, CSS, and JS. Quickly prototype your ideas or build your entire app with our Sass variables and mixins, responsive grid system, extensive prebuilt components, and powerful plugins built on jQuery.</p>', 'bootstrap, html5, css3, javascript, jquery', 0, 'published', 10),
(109, 2, 'JavaScript', '', 'JoniLah', '2018-06-15', 'javascript.png', '<p>JavaScript.com&nbsp;is a resource built by the <a href=\"https://www.pluralsight.com/\">Pluralsight</a>&nbsp;team for the JavaScript community.</p><p>Because JavaScript is a great language for coding beginners, we\'ve gathered some of the best&nbsp;<a href=\"https://www.javascript.com/resources\">learning resources</a>&nbsp;around and built a&nbsp;<a href=\"https://www.javascript.com/try\">JavaScript course</a>&nbsp;to help new developers get up and running.</p><p>With the help of community members contributing content to the site, JavaScript.com aims to also keep more advanced developers up to date on news, frameworks, and libraries.</p>', 'javascript, back-end, front-end', 0, 'published', 2),
(110, 3, 'PHP', '', 'Admin', '2018-06-15', 'php.png', '<p>PHP is a programming language that can do all sorts of things: evaluate form data sent from a browser, build custom web content to serve the browser, talk to a database, and even send and receive cookies (little packets of data that your browser uses to remember things, like if you\'re logged in to Codecademy).</p>', 'PHP, back-end, OOP', 0, 'published', 6),
(111, 2, 'Java', '', 'Admin', '2018-06-15', 'java.png', '<p>Java is among the most popular programming languages out there, thanks to its versatility and compatibility. Java is used for software development, mobile applications, and large systems development.</p>', 'java, back-end', 0, 'draft', 1),
(112, 19, 'Flexbox (CSS3)', '', 'JoniLah', '2018-06-15', 'flexbox.png', '<p>The Flexbox Layout (Flexible Box) module (currently a W3C Last Call Working Draft) aims at providing a more efficient way to lay out, align and distribute space among items in a container, even when their size is unknown and/or dynamic (thus the word \"flex\").</p><p>The main idea behind the flex layout is to give the container the ability to alter its items\' width/height (and order) to best fill the available space (mostly to accommodate to all kind of display devices and screen sizes). A flex container expands items to fill available free space, or shrinks them to prevent overflow.</p><p>Most importantly, the flexbox layout is direction-agnostic as opposed to the regular layouts (block which is vertically-based and inline which is horizontally-based). While those work well for pages, they lack flexibility (no pun intended) to support large or complex applications (especially when it comes to orientation changing, resizing, stretching, shrinking, etc.).</p><blockquote><p><strong>Note:</strong> Flexbox layout is most appropriate to the components of an application, and small-scale layouts, while the <a href=\"http://css-tricks.com/snippets/css/complete-guide-grid/\">Grid</a> layout is intended for larger scale layouts.</p></blockquote><p>Since flexbox is a whole module and not a single property, it involves a lot of things including its whole set of properties. Some of them are meant to be set on the container (parent element, known as \"flex container\") whereas the others are meant to be set on the children (said \"flex items\").</p><p>If regular layout is based on both block and inline flow directions, the flex layout is based on \"flex-flow directions\". Please have a look at this figure from the specification, explaining the main idea behind the flex layout.</p>', 'flexbox, css3, layout', 0, 'published', 2),
(114, 2, 'less', '', 'Hessu', '2018-06-15', 'less.png', '<h2>Overview</h2><blockquote><p>Less (which stands for Leaner Style Sheets) is a backwards-compatible language extension for CSS. This is the official documentation for Less, the language and Less.js, the JavaScript tool that converts your Less styles to CSS styles.</p></blockquote><p>Because Less looks just like CSS, learning it is a breeze. Less only makes a few convenient additions to the CSS language, which is one of the reasons it can be learned so quickly.</p><ul><li><i>For detailed documentation on Less language features, see </i><a href=\"http://lesscss.org/features/\"><i>Features</i></a></li><li><i>For a list of Less Built-in functions, see </i><a href=\"http://lesscss.org/functions/\"><i>Functions</i></a></li><li><i>For detailed usage instructions, see </i><a href=\"http://lesscss.org/usage/\"><i>Using Less.js</i></a></li><li><i>For third-party tools for Less, see </i><a href=\"http://lesscss.org/tools/\"><i>Tools</i></a></li></ul><p>What does Less add to CSS? Here\'s a quick overview of features.</p>', 'less, css3, tool', 0, 'published', 1),
(115, 19, 'Sass', '', 'Admin', '2018-06-15', 'sass.svg', '<p>There are an endless number of frameworks built with Sass. <a href=\"http://compass-style.org/\">Compass</a>, <a href=\"http://bourbon.io/\">Bourbon</a>, and <a href=\"http://susy.oddbird.net/\">Susy</a> just to name a&nbsp;few.</p><h3>FRAMEWORKS</h3><p>Sass is actively supported and developed by a consortium of several tech companies and hundreds of developers.</p><h3>LARGE COMMUNITY</h3><p>Over and over again, the industry is choosing Sass as the premier CSS extension language.</p><h3>INDUSTRY APPROVED</h3><p>Sass has been actively supported for over 11 years by its loving Core&nbsp;Team.</p><h3>MATURE</h3><p>Sass boasts more features and abilities than any other CSS extension language out there. The Sass Core Team has worked endlessly to not only keep up, but stay&nbsp;ahead.</p><h3>FEATURE RICH</h3><p>Sass is completely compatible with all versions of CSS. We take this compatibility seriously, so that you can seamlessly use any available CSS libraries.</p><h3>CSS COMPATIBLE</h3>', 'sass, css3, tool', 0, 'published', 7),
(116, 20, 'AutoIt', '', 'Admin', '2018-06-15', 'autoit.jpg', '<p>AutoIt v3 is a freeware BASIC-like scripting language designed for automating the Windows GUI and general scripting. It uses a combination of simulated keystrokes, mouse movement and window/control manipulation in order to automate tasks in a way not possible or reliable with other languages (e.g. VBScript and SendKeys). AutoIt is also very small, self-contained and will run on all versions of Windows out-of-the-box with no annoying “runtimes” required!</p><p>AutoIt was initially designed for PC “roll out” situations to reliably automate and configure thousands of PCs. Over time it has become a powerful language that supports complex expressions, user functions, loops and everything else that veteran scripters would expect.</p><ul><li>Easy to learn BASIC-like syntax</li><li>Simulate keystrokes and mouse movements</li><li>Manipulate windows and processes</li><li>Interact with all standard windows controls</li><li>Scripts can be compiled into standalone executables</li><li>Create Graphical User Interfaces (GUIs)</li><li>COM support</li><li>Regular expressions</li><li>Directly call external DLL and Windows API functions</li><li>Scriptable RunAs functions</li><li>Detailed helpfile and large community-based support forums</li><li>Compatible with Windows XP / 2003 / Vista / 2008 / Windows 7 / 2008 R2 / Windows 8 / 2012 R2</li><li>Unicode and x64 support</li><li>Digitally signed for peace of mind</li><li>Works with Windows Vista’s User Account Control (UAC)</li></ul><p>AutoIt has been designed to be as small as possible and stand-alone with no external .dll files or registry entries required making it safe to use on Servers. Scripts can be compiled into stand-alone executables with <strong>Aut2Exe</strong>.</p><p>Also supplied is a combined COM and DLL version of AutoIt called AutoItX that allows you to add the unique features of AutoIt to your own favourite scripting or programming languages!</p>', 'autoit, automation, back-end, screen reader', 0, 'draft', 6);

-- --------------------------------------------------------

--
-- Rakenne taululle `users`
--

CREATE TABLE `users` (
  `user_id` int(8) NOT NULL,
  `username` varchar(255) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_firstname` varchar(255) NOT NULL,
  `user_lastname` varchar(255) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_image` text NOT NULL,
  `user_role` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Vedos taulusta `users`
--

INSERT INTO `users` (`user_id`, `username`, `user_password`, `user_firstname`, `user_lastname`, `user_email`, `user_image`, `user_role`) VALUES
(19, 'JoniLah', '$2y$12$cLs8ZT3O5naT9QcKyN7rIuGU/h2y1Oe7r6GV0y8k/bao5KxUtUmUu', 'Joni', 'Lähdesmäki', 'joni.lahdesmaki@hotmail.fi', '', 'admin'),
(22, 'Hessu', '$2y$12$oMyqH/5Bc7hdlvNrjT9m7eOZR2QyxGL/klV8Zy7ow5xZJNRDGr6lW', '', '', 'hessuhopo@example.com', '', 'subscriber'),
(23, 'Admin', '$2y$10$z39NUPkaSPfwI5Z2TV5Z4.f3FclBdMQsnitwbRopT6V.yBclOlaPK', 'Herra', 'X', 'herrax@admin.com', '', 'admin'),
(25, 'phpsolutions', '$2y$12$XHgdQ3HAVWIbSnMUtJ/tw.oGOYhbTn4GoB3UzAb.7nyusqW9ZXS3S', 'Jarkko', 'Kähkönen', 'jarkko.kahkonen@phpsolutions.fi', '', 'admin'),
(26, 'pearsonfrank', '$2y$10$Z5raOQRZzRtvcJNvaIVjy.GhGZFH0TLpv72wlUCzvFUKXFRGndAjK', 'Pearson', 'Frank', 'example@example.com', '', 'admin');

-- --------------------------------------------------------

--
-- Rakenne taululle `users_online`
--

CREATE TABLE `users_online` (
  `id` int(11) NOT NULL,
  `session` varchar(255) NOT NULL,
  `time` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Vedos taulusta `users_online`
--

INSERT INTO `users_online` (`id`, `session`, `time`) VALUES
(2, 'thccilgpri23flijomo1tdv49f', 1528947226),
(4, '3ftbu9o05c18ug0v8qp36q3ud0', 1528916239),
(5, 'q8ogfadl43jg1q218k7hdha2q0', 1528918781),
(6, '0sq1vhnkjf3r3lit1je9nj45s8', 1528920516),
(7, 'i35c1jdvbf6abl96fbd4ijm1qc', 1528920553),
(8, 'e4tmu9h3m55912pacj6ik4h602', 1528947453),
(9, 'hvk6pfp5ehk2qnqvevpdht5g06', 1529104888),
(10, 'sva510eg427onrqsv5u3jc73o5', 1528960553),
(11, 'vgbrajr982p1sfjj4j8f66i711', 1528960366),
(12, 'rvh31o2ff01v5nvnejj6rltf22', 1528960818),
(13, '42iltgt0fap767iqpcnu3aof90', 1528962345),
(14, 'vqus0cu4bd2qq3l9l5avo47bf0', 1529023930),
(15, '6bqnticbei3aojn31ojj7ef485', 1529173206);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`cat_id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`post_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `users_online`
--
ALTER TABLE `users_online`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `cat_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `post_id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=117;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `users_online`
--
ALTER TABLE `users_online`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
