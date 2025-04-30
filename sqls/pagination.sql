CREATE TABLE IF NOT EXISTS `pagination_users` (
  `id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `city` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

INSERT INTO `pagination_users` (`id`, `name`, `email`, `city`) VALUES
(1, 'Yogesh singh', 'yogesh@makitweb.com', 'Bhopal'),
(2, 'Sonarika Bhadoria', 'bsonarika@makitweb.com', 'Indore'),
(3, 'Sunil singh', 'sunil@makitweb.com', 'Pune'),
(4, 'Vishal Sahu', 'vishal@makitweb.com', 'Bhopal'),
(5, 'jitendra singh', 'jitendra@makitweb.com', 'Delhi'),
(6, 'Shreya joshi', 'shreya@makitweb.com', 'Indore'),
(7, 'Abhilash namdev', 'abhilash@makitweb.com', 'Pune'),
(8, 'Ekta patidar', 'ekta@makitweb.com', 'Bhopal'),
(9, 'Deepak singh', 'deepak@makitweb.com', 'Delhi'),
(10, 'Rohit Kumar', 'rohit@makitweb.com', 'Bhopal'),
(11, 'Bhavna Mahajan', 'bhavna@makitweb.com', 'Indore'),
(12, 'Ajay singh', 'ajay@makitweb.com', 'Delhi'),
(13, 'Mohit', 'mohit@makitweb.com', 'Pune'),
(14, 'Akhilesh Sahu', 'akhilesh@makitweb.com', 'Indore'),
(15, 'Ganesh', 'ganesh@makitweb.com', 'Pune'),
(16, 'Vijay', 'vijay@makitweb.com', 'Delhi');
