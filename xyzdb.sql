-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 21, 2022 at 06:44 AM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `xyzdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `brand`
--

CREATE TABLE `brand` (
  `BrandID` int(11) NOT NULL,
  `BrandName` varchar(50) NOT NULL,
  `Status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `brand`
--

INSERT INTO `brand` (`BrandID`, `BrandName`, `Status`) VALUES
(2, 'Redmi', 'Active'),
(3, 'Samsaung Gallaxy', 'Active'),
(4, 'Huawei', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `CategoryID` int(11) NOT NULL,
  `CategoryName` varchar(150) NOT NULL,
  `Status` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`CategoryID`, `CategoryName`, `Status`) VALUES
(1, 'Xiaomi Redmi Series', 'Active'),
(2, 'Samsaung Gallaxy Series', 'Active'),
(3, 'Huawei P Series', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `Admin`
--

CREATE TABLE `admin` (
  `adminID` int(11) NOT NULL,
  `adminname` varchar(100) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Password` varchar(25) NOT NULL,
  `Phone` varchar(25) NOT NULL,
  `Address` varchar(255) NOT NULL,
  `RegisterDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`adminID`, `adminname`, `Email`, `Password`, `Phone`, `Address`, `RegisterDate`) VALUES
(2, 'Alex Aung', 'alex@gmail.com', 'alex', '313033984930', 'Yangon', '2021-12-05 01:21:07'),
(3, 'linn htet aung', 'l@gmail.com', '12345', '095503564', 'aa', '2022-02-21 04:58:11'),
(4, 'joker', 'j@gmail.com', '12345', '5555555', 'aaa', '2022-02-21 05:02:00'),
(5, 'mufasar', 'm@gmail.com', '12345', '9999999', 'aa', '2022-02-21 05:13:36');

-- --------------------------------------------------------
-- Table structure for table `customer`
--
CREATE TABLE `customer` (
  `customerID` int(11) NOT NULL,
  `customername` varchar(100) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Password` varchar(25) NOT NULL,
  `Phone` varchar(25) NOT NULL,
  `Address` varchar(255) NOT NULL,
  `RegisterDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`customerID`, `customername`, `Email`, `Password`, `Phone`, `Address`, `RegisterDate`) VALUES
(2, 'Alex Aung', 'alex@gmail.com', 'alex', '313033984930', 'Yangon', '2021-12-05 01:21:07'),
(3, 'linn htet aung', 'l@gmail.com', '12345', '095503564', 'aa', '2022-02-21 04:58:11'),
(4, 'joker', 'j@gmail.com', '12345', '5555555', 'aaa', '2022-02-21 05:02:00'),
(5, 'mufasar', 'm@gmail.com', '12345', '9999999', 'aa', '2022-02-21 05:13:36');

-- --------------------------------------------------------

--
-- Table structure for table `orderdetails`
--

CREATE TABLE `orderdetails` (
  `OrderID` varchar(15) NOT NULL,
  `ProductID` int(11) NOT NULL,
  `Price` decimal(10,0) NOT NULL,
  `Quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orderdetails`
--

INSERT INTO `orderdetails` (`OrderID`, `ProductID`, `Price`, `Quantity`) VALUES
('ORD-000001', 2, '30', 1),
('ORD-000001', 3, '120', 1),
('ORD-000002', 4, '120', 5),
('ORD-000003', 3, '120', 6);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `OrderID` varchar(15) NOT NULL,
  `OrderDate` date NOT NULL,
  `CustomerID` int(11) NOT NULL,
  `DeliveryType` varchar(150) NOT NULL,
  `PaymentType` varchar(150) NOT NULL,
  `CustomerName` varchar(50) NOT NULL,
  `Phone` varchar(50) NOT NULL,
  `Address` varchar(255) NOT NULL,
  `Direction` varchar(255) NOT NULL,
  `CardNo` varchar(50) NOT NULL,
  `TotalQuantity` int(11) NOT NULL,
  `TotalAmount` decimal(10,0) NOT NULL,
  `VAT` decimal(10,0) NOT NULL,
  `GrandTotal` decimal(10,0) NOT NULL,
  `Status` varchar(30) NOT NULL,
  `DeliveryStatus` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`OrderID`, `OrderDate`, `CustomerID`, `DeliveryType`, `PaymentType`, `CustomerName`, `Phone`, `Address`, `Direction`, `CardNo`, `TotalQuantity`, `TotalAmount`, `VAT`, `GrandTotal`, `Status`, `DeliveryStatus`) VALUES
('ORD-000001', '0000-00-00', 1, 'SameAddress', 'COD', 'Alex John', '0959938988', 'No 331, Pyay Road, Yangon', 'Near Maharmyone Bus-Stop', '', 2, '150', '8', '158', 'Pending', 'Pending'),
('ORD-000002', '0000-00-00', 1, 'OtherAddress', 'COD', 'Mufasar', '095503564', '125,shwe wah street', 'Bus.stop 5', '', 5, '600', '30', '630', 'Pending', 'Pending'),
('ORD-000003', '0000-00-00', 1, 'SameAddress', 'Card', 'Alex John', '0959938988', 'No 331, Pyay Road, Yangon', 'jjdfo', '12345', 6, '720', '36', '756', 'Pending', 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `ProductID` int(11) NOT NULL,
  `ProductName` varchar(100) NOT NULL,
  `BrandID` int(11) NOT NULL,
  `CategoryID` int(11) NOT NULL,
  `Type` varchar(10) NOT NULL,
  `BottleType` varchar(40) NOT NULL,
  `Description` varchar(255) NOT NULL,
  `Capacity` varchar(50) NOT NULL,
  `Quantity` int(11) NOT NULL,
  `Price` decimal(10,0) NOT NULL,
  `ProductImage1` varchar(255) NOT NULL,
  `ProductImage2` varchar(255) NOT NULL,
  `ProductImage3` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`ProductID`, `ProductName`, `BrandID`, `CategoryID`, `Type`, `BottleType`, `Description`, `Capacity`, `Quantity`, `Price`, `ProductImage1`, `ProductImage2`, `ProductImage3`) VALUES
(2, 'xiaomi-redmi-note-11-pro-global', 3, 1, 'ALL', 'AllGlass', 'Fantasy Perfume by Britney Spears, Fantasy by britney spears is the 2nd of her perfume line, launched in 2005 as a fun, and invigorating scent. This feminine scent possesses a blend of red lychee, kiwi, cupcake, jasmine, white chocolate, musk, orris root.', '30 ml', 110, '30', 'ProductImage/_D1.jpg', 'ProductImage/_D2.jpg', 'ProductImage/_D3.jpg'),
(3, 'Galaxy S21 FE 5G', 2, 1, 'ALL', 'AllGlass', 'Pleasures Intense by EstÃ©e Lauder is a Floral fragrance for women. Pleasures Intense was launched in 2002. Top notes are Green Lily, Peony, Black Currant, Ylang-Ylang and Cassis; middle notes are Lily, Jasmine, Tiare Flower and Moroccan Rose; base notes ', '100', 120, '120', 'ProductImage/_A1.jpg', 'ProductImage/_A2.jpg', 'ProductImage/_A3.jpg'),
(4, 'HUAWEI P50 Pro', 2, 1, 'ALL', 'Titanium', 'Pleasures Intense by EstÃ©e Lauder is a Floral fragrance for women. Pleasures Intense was launched in 2002. Top notes are Green Lily, Peony, Black Currant, Ylang-Ylang and Cassis; middle notes are Lily, Jasmine, Tiare Flower and Moroccan Rose; base notes ', '100', 120, '120', 'ProductImage/_E1.jpg', 'ProductImage/_E2.jpg', 'ProductImage/_E3.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `purchaseorder`
--

CREATE TABLE `purchaseorder` (
  `PurchaseOrderID` varchar(15) NOT NULL,
  `PurchaseOrderDate` date NOT NULL,
  `TotalAmount` int(11) NOT NULL,
  `TotalQuantity` int(11) NOT NULL,
  `TaxAmount` int(11) NOT NULL,
  `GrandTotal` decimal(16,2) NOT NULL,
  `SupplierID` int(11) NOT NULL,
  `StaffID` int(11) NOT NULL,
  `Status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `purchaseorder`
--

INSERT INTO `purchaseorder` (`PurchaseOrderID`, `PurchaseOrderDate`, `TotalAmount`, `TotalQuantity`, `TaxAmount`, `GrandTotal`, `SupplierID`, `StaffID`, `Status`) VALUES
('PU-000001', '2021-12-11', 700, 7, 35, '735.00', 1, 2, 'Confirmed'),
('PU-000002', '2021-12-12', 500, 5, 25, '525.00', 1, 2, 'Pending'),
('PU-000003', '2021-12-13', 500, 5, 25, '525.00', 1, 2, 'Pending'),
('PU-000004', '2022-02-17', 0, 0, 0, '0.00', 1, 2, 'Pending'),
('PU-000005', '2022-02-20', 0, 0, 0, '0.00', 1, 2, 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `purchaseorderdetail`
--

CREATE TABLE `purchaseorderdetail` (
  `PurchaseOrderID` varchar(30) NOT NULL,
  `ProductID` int(11) NOT NULL,
  `PurchaseQuantity` int(11) NOT NULL,
  `PurchasePrice` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `purchaseorderdetail`
--

INSERT INTO `purchaseorderdetail` (`PurchaseOrderID`, `ProductID`, `PurchaseQuantity`, `PurchasePrice`) VALUES
('PU-000001', 2, 100, 5),
('PU-000001', 3, 100, 2),
('PU-000002', 2, 100, 5),
('PU-000004', 4, 6, 4),
('PU-000005', 2, 6, 19);

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `RoleID` int(11) NOT NULL,
  `RoleName` varchar(100) NOT NULL,
  `Status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`RoleID`, `RoleName`, `Status`) VALUES
(1, 'Area Sales Manager', 'Active'),
(2, 'eCommerce Administrator', 'Active'),
(3, 'Web Administrator', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `StaffID` int(11) NOT NULL,
  `StaffName` varchar(100) NOT NULL,
  `RoleID` int(11) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Password` varchar(25) NOT NULL,
  `Phone` varchar(25) NOT NULL,
  `Address` varchar(255) NOT NULL,
  `StaffPhoto` varchar(255) NOT NULL,
  `RegisterDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`StaffID`, `StaffName`, `RoleID`, `Email`, `Password`, `Phone`, `Address`, `StaffPhoto`, `RegisterDate`) VALUES
(2, 'Alex Aung', 1, 'alex@gmail.com', 'alex', '313033984930', 'Yangon', 'StaffPhoto/_Alex_1.jpg', '2021-12-05 07:51:07');

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `SupplierID` int(11) NOT NULL,
  `SupplierName` varchar(100) NOT NULL,
  `CompanyName` varchar(50) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Phone` varchar(100) NOT NULL,
  `Address` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`SupplierID`, `SupplierName`, `CompanyName`, `Email`, `Phone`, `Address`) VALUES
(1, 'Maria & Co', 'Maria Group of Companies', 'admin@maria.com', '73794980948930', 'YANGON');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `brand`
--
ALTER TABLE `brand`
  ADD PRIMARY KEY (`BrandID`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`CategoryID`);

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`adminID`);

-- Indexes for table `admin`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`customerID`);

--
-- Indexes for table `orderdetails`
--
ALTER TABLE `orderdetails`
  ADD PRIMARY KEY (`OrderID`,`ProductID`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`OrderID`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`ProductID`);

--
-- Indexes for table `purchaseorder`
--
ALTER TABLE `purchaseorder`
  ADD PRIMARY KEY (`PurchaseOrderID`);

--
-- Indexes for table `purchaseorderdetail`
--
ALTER TABLE `purchaseorderdetail`
  ADD PRIMARY KEY (`PurchaseOrderID`,`ProductID`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`RoleID`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`StaffID`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`SupplierID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `adminID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `customerID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `ProductID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `RoleID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `StaffID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
