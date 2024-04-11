--
-- Table structure for table `tblproduct`
--

CREATE TABLE `tblproduct` (
  `id` int(8) NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `image` text NOT NULL,
  `price` double(10,2) NOT NULL,
  `tag` varchar(255)
) 

--
-- Dumping data for table `tblproduct`
--

INSERT INTO `tblproduct` (`id`, `name`, `code`, `image`, `price`, `tag`) 
VALUES ('1', 'fleur 1 ', 'f1', 'product-images\\fleur1.jpeg', '15.00', 'lol'),
('2', 'fleur 2', 'f2', 'product-images\\fleur2.jpeg', '28.00', 'Ordinaire'),
('3', 'fleur 3', 'f3', 'product-images\\fleur3.jpeg', '48.00', 'Ordinaire'),
('4', 'fleur 4', 'f4', 'product-images\\fleur4.jpeg', '35.00', 'Ordinaire'), 
('5', 'fleur 5', 'f5', 'product-images\\fleur5.jpeg', '21.35', 'Ordinaire'), 
('6', 'fleur 6', 'f6', 'product-images\\fleur6.jpeg', '29.99', 'Ordinaire')

--
-- Indexes for table `tblproduct`
--
ALTER TABLE `tblproduct`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `product_code` (`code`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tblproduct`
--
ALTER TABLE `tblproduct`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;