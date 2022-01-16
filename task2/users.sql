
START TRANSACTION;
--
-- Database: `ezora`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `age` int(2) NOT NULL,
  `job_title` varchar(255) NOT NULL,
  `inserted_on` datetime NOT NULL DEFAULT current_timestamp(),
  `last_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `name`, `age`, `job_title`, `inserted_on`, `last_updated`) VALUES
(1, 'John Connor', 23, 'Intern', '2022-01-16 15:44:21', '2022-01-16 15:44:21'),
(2, 'Ellen Ripley', 35, 'Cleaner', '2022-01-16 16:08:48', '2022-01-16 16:08:48'),
(3, 'Rick Deckard', 45, 'Detective', '2022-01-16 16:32:21', '2022-01-16 16:48:36');

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;
