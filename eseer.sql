

CREATE TABLE `pending` (
  `id` varchar(32) NOT NULL,
  `email` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `time` int(11) NOT NULL,
  `imageurl` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
