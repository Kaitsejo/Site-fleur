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
CREATE TABLE `fleur` (
  `id` int(8) NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `image` text NOT NULL,
  `price` double(10,2) NOT NULL,
  `tag` varchar(255)
) 
CREATE TABLE `Bouquet` (
  `id` int(8) NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `image` text NOT NULL,
  `price` double(10,2) NOT NULL,
  `tag` varchar(255)
) 
CREATE TABLE `Boutique` (
  `id` int(8) NOT NULL,
  `name` varchar(255) NOT NULL,
  `Adresse`varchar(255) NOT NULL,
  `ZIPCODE` int(5) NOT NULL
) 



--
-- Dumping data for table `tblproduct`
--

INSERT INTO `tblproduct` (`id`, `name`, `code`, `image`, `price`, `tag`) 
VALUES 
('1', 'fleur 1 ','fp1','product-images/bouquets/fleur1.jpeg', '15.00', 'lol'),
('2', 'fleur 2', 'fp2', 'product-images/bouquets/fleur2.jpeg', '28.00', 'Ordinaire'),
('3', 'fleur 3', 'fp3', 'product-images/bouquets/fleur3.jpeg', '48.00', 'Ordinaire'),
('4', 'fleur 4', 'fp4', 'product-images/bouquets/fleur4.jpeg', '35.00', 'Ordinaire'), 
('5', 'fleur 5', 'fp5', 'product-images/bouquets/fleur5.jpeg', '21.35', 'Ordinaire'), 
('6', 'fleur 6', 'fp6', 'product-images/bouquets/fleur6.jpeg', '29.99', 'Ordinaire')

INSERT INTO `fleur` (`id`, `name`, `code`, `image`, `price`, `tag`) 
VALUES 
('1', 'Anémone ', 'f1', 'product-images/fleurs/f1.jpg', '15.00', 'lol'),
('2', 'Asclépia', 'f2', 'product-images/fleurs/f2.jpg', '28.00', 'Ordinaire'),
('3', 'Astrance', 'f3', 'product-images/fleurs/f3.jpg', '48.00', 'Ordinaire'),
('4', 'Clématite', 'f4', 'product-images/fleurs/f4.jpg', '35.00', 'Ordinaire'), 
('5', 'Camomille', 'f5', 'product-images/fleurs/f5.jpg', '21.35', 'Ordinaire'), 
('6', 'Chrysanthème', 'f6', 'product-images/fleurs/f6.jpg', '29.99', 'Ordinaire')

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