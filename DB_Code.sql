-- Database: `capstone_db`
-- --------------------------------------------------------
-- Table structure for table `exchange`

CREATE TABLE `exchange` (
  `exchange` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `exchange`
--

INSERT INTO `exchange` (`exchange`) VALUES
('NYSE'),
('NASDAQ'),
('AMEX'),
('EURONET'),
('TSX'),
('ETF'),
('Mutual Fund');

-- --------------------------------------------------------

-- Table structure for table `industry`
--

CREATE TABLE `industry` (
  `industry` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `industry`
--

INSERT INTO `industry` (`industry`) VALUES
('Banks'),
('Banks Diversified'),
('Software'),
('Banks Regional'),
('Beverages Alcoholic'),
('Beverages Brewers'),
('Beverages Non-Alcoholic'),
('Autos');

-- --------------------------------------------------------

-- Table structure for table `sector`
--

CREATE TABLE `sector` (
  `sector` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sector`
--

INSERT INTO `sector` (`sector`) VALUES
('Consumer Cyclical'),
('Energy'),
('Technology'),
('Industrials'),
('Financial Services'),
('Basic Materials'),
('Communication Services'),
('Consumer Defensive'),
('Healthcare'),
('Real Estate'),
('Utilities'),
('Industrial Goods'),
('Financial'),
('Services'),
('Conglomerates');

-- --------------------------------------------------------

-- Table structure for table `stocks`
--

CREATE TABLE `stocks` (
  `id` int(200) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `ticker` varchar(8) NOT NULL,
  `share_num` int(255) NOT NULL,
  `cost` decimal(10,2) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `stocks`
--

INSERT INTO `stocks` (`id`, `user_id`, `ticker`, `share_num`, `cost`, `date`) VALUES
(9, 9654, 'MSFT', 4, '260.00', '2023-04-04'),
(10, 9654, 'AAPL', 1, '100.00', '2023-04-03'),
(11, 9654, 'SOFI', 10, '3.80', '2023-04-06');

-- --------------------------------------------------------

-- Table structure for table `options`
--

CREATE TABLE `options` (
  `id` int(200) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `ticker` varchar(8) NOT NULL,
  `con_num` int(255) NOT NULL,
  `call_put` varchar(8) NOT NULL,
  `cost` decimal(10,2) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;


-- --------------------------------------------------------

-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` bigint(15) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `pword` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `first_name`, `last_name`, `email`, `pword`) VALUES
(9654, 'Ramsey', 'Holeman', 'rjholeman25@gmail.com', '1234');

--
-- Indexes for dumped tables

-- Indexes for table `stocks`
--
ALTER TABLE `stocks`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables

-- AUTO_INCREMENT for table `stocks`
--
ALTER TABLE `stocks`
  MODIFY `id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;