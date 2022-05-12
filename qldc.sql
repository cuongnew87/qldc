-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th5 12, 2022 lúc 04:42 PM
-- Phiên bản máy phục vụ: 10.4.22-MariaDB
-- Phiên bản PHP: 8.0.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `qldc`
--

DELIMITER $$
--
-- Thủ tục
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `LoopDemo` ()  BEGIN
DECLARE building_id  INT;
DECLARE num_service  INT;
DECLARE x  INT;     
SET x = 1;
SET building_id = (SELECT `buildings`.`bldid` FROM `buildings` ORDER BY `buildings`.`bldid` DESC LIMIT 1);
SET num_service =  (SELECT COUNT(*) FROM `utilities`);      
loop_label:LOOP
IF  x > num_service THEN 
LEAVE loop_label;
END  IF;
INSERT INTO `utilities_building`(bldid, utltid) VALUES(building_id, x);
SET  x = x + 1;
END LOOP;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `apartments`
--

CREATE TABLE `apartments` (
  `aid` int(11) NOT NULL,
  `bldid` int(11) NOT NULL,
  `a_name` varchar(200) CHARACTER SET utf8 NOT NULL,
  `a_size` int(200) NOT NULL,
  `atype_id` int(11) NOT NULL,
  `r_status` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `apartments`
--

INSERT INTO `apartments` (`aid`, `bldid`, `a_name`, `a_size`, `atype_id`, `r_status`) VALUES
(1, 1, 'Căn hộ A10201', 20, 1, 1),
(2, 1, 'Căn hộ A20201', 20, 2, 0),
(3, 2, 'Căn hộ B10101', 19, 3, 0),
(4, 2, 'Căn hộ B20101', 19, 3, 0),
(5, 3, 'Căn biệt thự C10101', 50, 7, 1),
(6, 3, 'Căn biệt thự C20101', 70, 8, 1),
(7, 1, 'Căn hộ A103', 20, 2, 1),
(8, 1, 'Căn hộ A104', 30, 1, 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `apartment_type`
--

CREATE TABLE `apartment_type` (
  `atype_id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `atype_name` varchar(200) CHARACTER SET utf8 NOT NULL,
  `atype_area` varchar(200) CHARACTER SET utf8 NOT NULL,
  `atype_acreage` varchar(200) CHARACTER SET utf8 NOT NULL,
  `atype_style` varchar(200) CHARACTER SET utf8 NOT NULL,
  `atype_des` varchar(200) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `apartment_type`
--

INSERT INTO `apartment_type` (`atype_id`, `branch_id`, `atype_name`, `atype_area`, `atype_acreage`, `atype_style`, `atype_des`) VALUES
(1, 1, 'Căn hộ chung cư 3 phòng ngủ', 'Khu vực A', '123', 'Căn hộ chung cư hiện đại', 'Thuộc khu vực A nằm ơ phía tây khu dân cư. Tháp cao 21 tầng với tổng số 158 căn hộ, 08 căn/sàn, Chia làm 2 loại 03 phòng ngủ và 04 phòng ngủ. Các căn đước bán với mức giá 37,4 triệu'),
(2, 1, 'Căn hộ chung cư 4 phòng ngủ', 'Khu vực A', '153', 'Căn hộ chung cư hiện đại', 'Thuộc khu vực A nằm ơ phía tây khu dân cư. Tháp cao 21 tầng với tổng số 158 căn hộ, 08 căn/sàn, Chia làm 2 loại 03 phòng ngủ và 04 phòng ngủ. Các căn đước bán với mức giá 37,4 triệu'),
(3, 2, 'Nhà phố', 'Khu vực B', '126', 'Nhà phố liền kề B1', 'Thuộc khu vực B phía đông khu dân cư. Với quy mô 200 căn có diện tích điển hình: 126m2 – 180m2- 230m2- 300m2. Khách hàng có thể mua để ở, thuê để kinh doanh hoặc vừa ở vừa kinh doanh với mức giá cho m'),
(4, 2, 'Nhà phố', 'Khu vực B', '180', 'Nhà phố liền kề B1', 'Thuộc khu vực B phía đông khu dân cư. Với quy mô 200 căn có diện tích điển hình: 126m2 – 180m2- 230m2- 300m2. Khách hàng có thể mua để ở, thuê để kinh doanh hoặc vừa ở vừa kinh doanh với mức giá cho m'),
(5, 2, 'Nhà phố', 'Khu vực B', '230', 'Nhà phố liền kề B2', 'Thuộc khu vực B phía đông khu dân cư. Với quy mô 200 căn có diện tích điển hình: 126m2 – 180m2- 230m2- 300m2. Khách hàng có thể mua để ở, thuê để kinh doanh hoặc vừa ở vừa kinh doanh với mức giá cho m'),
(6, 2, 'Nhà phố', 'Khu vực B', '300', 'Nhà phố liền kề B2', 'Thuộc khu vực B phía đông khu dân cư. Với quy mô 200 căn có diện tích điển hình: 126m2 – 180m2- 230m2- 300m2. Khách hàng có thể mua để ở, thuê để kinh doanh hoặc vừa ở vừa kinh doanh với mức giá cho m'),
(7, 3, 'Biệt thự đơn lập', 'Khu vực C', '140', 'Biệt thự nghỉ dưỡng truyền thống', 'Thuộc khu vực C ở trung tâm khu dân cư ngay sát hồ Điều Hòa. Khu biệt thự bao gồm chỉ 160 căn mức giá 100 triệu đồng/m2.'),
(9, 3, 'Biệt thự đơn lập', 'Khu vực C', '300', 'Biệt thự nghỉ dưỡng hiện đại', 'Thuộc khu vực C ở trung tâm khu dân cư ngay sát hồ Điều Hòa. Khu biệt thự bao gồm chỉ 160 căn mức giá 100 triệu đồng/m2.'),
(10, 3, 'Biệt thự sân vườn', 'Khu vực C', '300', 'Biệt thự nghỉ dưỡng truyền thống', 'Thuộc khu vực C ở trung tâm khu dân cư ngay sát hồ Điều Hòa. Khu biệt thự bao gồm chỉ 160 căn mức giá 100 triệu đồng/m2.');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `bills`
--

CREATE TABLE `bills` (
  `bill_id` int(11) NOT NULL,
  `aid` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  `bill_paydate` varchar(200) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `bills`
--

INSERT INTO `bills` (`bill_id`, `aid`, `total`, `bill_paydate`) VALUES
(1, 1, 10000, '01/04/2022'),
(2, 5, 6000, '01/04/2022'),
(3, 1, 472000, '2022-05-18');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `branches`
--

CREATE TABLE `branches` (
  `branch_id` int(11) NOT NULL,
  `branch_name` varchar(100) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `branches`
--

INSERT INTO `branches` (`branch_id`, `branch_name`) VALUES
(1, 'Chung cư cao cấp'),
(2, 'Nhà phố'),
(3, 'Biệt thự nghỉ dưỡng ');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `buildings`
--

CREATE TABLE `buildings` (
  `bldid` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `ownid` int(11) NOT NULL,
  `bld_name` varchar(200) CHARACTER SET utf8 NOT NULL,
  `bld_address` varchar(200) CHARACTER SET utf8 NOT NULL,
  `bld_image` varchar(200) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `buildings`
--

INSERT INTO `buildings` (`bldid`, `branch_id`, `ownid`, `bld_name`, `bld_address`, `bld_image`) VALUES
(1, 1, 1, 'Tháp chung cư cao cấp A12', 'Hà Nội, NV ,hddd', '3-phong-ngu.jpg'),
(2, 1, 1, 'Tháp chung cư cao cấp A2', 'Hà Nội', 'bkaptech.jpg'),
(3, 2, 2, 'Dãy nhà phố B1', 'Hà Nội', 'cddl.jpg'),
(4, 2, 2, 'Dãy nhà phố B2', 'Hà Nội', 'cdnn.jpg'),
(5, 3, 3, 'Khu biệt thự nghỉ dưỡng C1', 'Hà Nội', 'cdyd.jpg'),
(6, 3, 3, 'Khu biệt thự nghỉ dưỡng C2', 'Hà Nội', 'epu.jpg'),
(7, 2, 3, 'Kiot 14', 'Số nhà 16A ngõ 3 Nguyễn Văn Huyên, Quan Hoa, Cầu Giấy, Hà Nội', '2.png'),
(8, 3, 2, 'Star', 'Số nhà 16A ngõ 3 Nguyễn Văn Huyên, Quan Hoa, Cầu Giấy, Hà Nội', '1.png'),
(9, 1, 3, 'Chung cư A91', 'Số nhà 16A ngõ 3 Nguyễn Văn Huyên, Quan Hoa, Cầu Giấy, Hà Nội', '1.png');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `complains`
--

CREATE TABLE `complains` (
  `cplid` int(11) NOT NULL,
  `aid` int(11) NOT NULL,
  `spl_subject` varchar(200) CHARACTER SET utf8 NOT NULL,
  `cpl_complain` varchar(200) CHARACTER SET utf8 NOT NULL,
  `cpl_date` varchar(200) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `complains`
--

INSERT INTO `complains` (`cplid`, `aid`, `spl_subject`, `cpl_complain`, `cpl_date`) VALUES
(1, 1, 'Vệ sinh công cộng', 'Sàn nhà tầng 2 thường xuyên không được lau dọn', '12/04/2022'),
(2, 1, 'Lau san', 'Lau san di', '2022/05/12');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `contracts`
--

CREATE TABLE `contracts` (
  `ctrid` int(11) NOT NULL,
  `aid` int(11) NOT NULL,
  `rsdid` int(11) NOT NULL,
  `ctr_name` varchar(200) CHARACTER SET utf8 NOT NULL,
  `ctr_type` varchar(200) CHARACTER SET utf8 NOT NULL,
  `rent_fee` int(11) NOT NULL,
  `buy_fee` int(11) NOT NULL,
  `ctr_date` varchar(200) CHARACTER SET utf8 NOT NULL,
  `file_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `contracts`
--

INSERT INTO `contracts` (`ctrid`, `aid`, `rsdid`, `ctr_name`, `ctr_type`, `rent_fee`, `buy_fee`, `ctr_date`, `file_name`) VALUES
(1, 1, 1, 'Hợp đồng mua căn hộ A10201', 'Hợp đồng mua nhà', 0, 10000, '01/01/2000', ''),
(2, 5, 2, 'Hợp đồng thuê biệt thự', 'Hợp đồng cho thuê dài hạn', 20, 0, '01/02/2001', ''),
(3, 7, 7, 'Hợp đồng thuê căn hộ A103', 'Hợp đồng thuê', 60000, 0, '2022-05-11', 'ER_diagram.pdf'),
(5, 6, 8, 'Hợp đồng mua biệt thự', 'Hợp đồng mua', 0, 120000, '2022-05-09', 'Active Ecommerce CMS Documentation .pdf');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `owners`
--

CREATE TABLE `owners` (
  `ownid` int(11) NOT NULL,
  `o_name` varchar(200) CHARACTER SET utf8 NOT NULL,
  `o_sex` varchar(200) CHARACTER SET utf8 NOT NULL,
  `o_phone` varchar(200) CHARACTER SET utf8 NOT NULL,
  `o_mail` varchar(200) CHARACTER SET utf8 NOT NULL,
  `o_image` varchar(200) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `owners`
--

INSERT INTO `owners` (`ownid`, `o_name`, `o_sex`, `o_phone`, `o_mail`, `o_image`) VALUES
(1, 'Nguyễn Văn A', 'Nam', '555666999', 'nva123@gmail.com', 'Hình ảnh ông Nguyễn Văn A'),
(2, 'Bùi Thị T', 'Nữ', '444888444', 'btt123@gmail.com', 'Hình ảnh bà Bùi Thị T'),
(3, 'Lê Văn L', 'Nam', '333666777', 'lvl123@gmail.com', 'Hình ảnh anh Lê Văn L');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `residents`
--

CREATE TABLE `residents` (
  `rsdid` int(11) NOT NULL,
  `bldid` int(11) NOT NULL,
  `aid` int(11) NOT NULL,
  `rsd_name` varchar(200) CHARACTER SET utf8 NOT NULL,
  `rsd_identity` varchar(200) CHARACTER SET utf8 NOT NULL,
  `rsd_phone` varchar(200) CHARACTER SET utf8 NOT NULL,
  `rsd_mail` varchar(200) CHARACTER SET utf8 NOT NULL,
  `rsd_sex` varchar(200) CHARACTER SET utf8 NOT NULL,
  `rsd_dob` varchar(200) CHARACTER SET utf8 NOT NULL,
  `rsd_relationship` varchar(200) CHARACTER SET utf8 NOT NULL DEFAULT 'Không',
  `rsd_image` varchar(200) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `residents`
--

INSERT INTO `residents` (`rsdid`, `bldid`, `aid`, `rsd_name`, `rsd_identity`, `rsd_phone`, `rsd_mail`, `rsd_sex`, `rsd_dob`, `rsd_relationship`, `rsd_image`) VALUES
(1, 1, 1, 'Phạm Tiến Đức', '12345678912', '985316428734', 'ptd123@gmail.com', 'Nam', '2000-07-05', 'Chủ hộ', '2.png'),
(2, 5, 5, 'Hồ Hoàng Trung Anh', '0305506843', '123654987', 'hhta123@gmail.com', 'Nam', '04/12/2001', 'Chủ hộ', 'Hình ảnh anh Trung ANh'),
(3, 1, 1, 'Phạm Tiến Độ', '040300008435', '9853164287', '', 'Nam', '03/02/2014', 'Con trai chủ hộ', 'Tt.png'),
(4, 1, 1, 'Lê Xuân Anhs', '050300006359', '555666333', 'lxa123@gmail.com', 'Nữ', '04/12/2002', 'Vợ chủ hộ', 'lebong.jpg'),
(5, 1, 1, 'Phạm Thị Hoài Anh', '040300008436', '9853164287', '', 'Nữ', '03/02/2009', 'Con gái chủ hộ', 'Tt.png'),
(6, 5, 5, 'Phạm Tiến Duật', '001200005125', '0976947354', 'phamtienduat@gmail.com', 'Nữ', '2022-05-03', 'ông', 'user-default.png'),
(7, 1, 7, 'Lê Minh Hiếu', '0124578522', '09769473455', 'leminhhieu@gmail.com', 'Nam', '2022-05-01', 'Chủ hộ', 'user-default.png'),
(8, 3, 6, 'Wolf', '001200005232', '125542666', 'wolf@gmail.com', 'Nam', '2022-05-01', 'Chủ hộ', 'user-default.png');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `user_mail` varchar(200) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `user_pass` varchar(200) NOT NULL,
  `role` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `user`
--

INSERT INTO `user` (`id`, `user_mail`, `user_name`, `user_pass`, `role`) VALUES
(1, 'nva123@gmail.com', 'Phạm Tiến Đức', '123456', 0),
(2, 'ptd123@gmail.com', 'Phạm Tiến Duật', '123456', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `utilities`
--

CREATE TABLE `utilities` (
  `utltid` int(11) NOT NULL,
  `utlt_name` varchar(200) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `utilities`
--

INSERT INTO `utilities` (`utltid`, `utlt_name`) VALUES
(1, 'Vệ sinh công cộng'),
(2, 'Nước '),
(3, 'Gửi xe'),
(4, 'Điện'),
(5, 'Gas');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `utilities_building`
--

CREATE TABLE `utilities_building` (
  `utlt_bld_id` int(11) NOT NULL,
  `bldid` int(11) NOT NULL,
  `utltid` int(11) NOT NULL,
  `utlt_cost` int(200) NOT NULL DEFAULT 0,
  `register` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `utilities_building`
--

INSERT INTO `utilities_building` (`utlt_bld_id`, `bldid`, `utltid`, `utlt_cost`, `register`) VALUES
(1, 1, 1, 200000, 1),
(2, 1, 2, 62000, 1),
(3, 1, 3, 200000, 1),
(4, 1, 4, 10000, 1),
(5, 1, 5, 0, 0),
(6, 2, 1, 0, 0),
(7, 2, 2, 0, 0),
(8, 2, 3, 0, 0),
(9, 2, 4, 0, 0),
(10, 2, 5, 0, 0),
(11, 3, 1, 0, 0),
(12, 3, 2, 0, 0),
(13, 3, 3, 0, 0),
(14, 3, 4, 0, 0),
(15, 3, 5, 0, 0),
(16, 4, 1, 0, 0),
(17, 4, 2, 0, 0),
(18, 4, 3, 0, 0),
(19, 4, 4, 0, 0),
(20, 4, 5, 0, 0),
(21, 5, 1, 0, 0),
(22, 5, 2, 0, 0),
(23, 5, 3, 0, 0),
(24, 5, 4, 0, 0),
(25, 5, 5, 0, 0),
(26, 6, 1, 0, 0),
(27, 6, 2, 0, 0),
(28, 6, 3, 0, 0),
(29, 6, 4, 0, 0),
(30, 6, 5, 0, 0),
(31, 7, 1, 0, 0),
(32, 7, 2, 0, 0),
(33, 7, 3, 0, 0),
(34, 7, 4, 0, 0),
(35, 7, 5, 0, 0),
(36, 8, 1, 0, 0),
(37, 8, 2, 0, 0),
(38, 8, 3, 0, 0),
(39, 8, 4, 0, 0),
(40, 8, 5, 0, 0),
(51, 9, 1, 0, 0),
(52, 9, 2, 0, 0),
(53, 9, 3, 0, 0),
(54, 9, 4, 0, 0),
(55, 9, 5, 0, 0);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `apartments`
--
ALTER TABLE `apartments`
  ADD PRIMARY KEY (`aid`);

--
-- Chỉ mục cho bảng `apartment_type`
--
ALTER TABLE `apartment_type`
  ADD PRIMARY KEY (`atype_id`);

--
-- Chỉ mục cho bảng `bills`
--
ALTER TABLE `bills`
  ADD PRIMARY KEY (`bill_id`);

--
-- Chỉ mục cho bảng `branches`
--
ALTER TABLE `branches`
  ADD PRIMARY KEY (`branch_id`);

--
-- Chỉ mục cho bảng `buildings`
--
ALTER TABLE `buildings`
  ADD PRIMARY KEY (`bldid`);

--
-- Chỉ mục cho bảng `complains`
--
ALTER TABLE `complains`
  ADD PRIMARY KEY (`cplid`);

--
-- Chỉ mục cho bảng `contracts`
--
ALTER TABLE `contracts`
  ADD PRIMARY KEY (`ctrid`);

--
-- Chỉ mục cho bảng `owners`
--
ALTER TABLE `owners`
  ADD PRIMARY KEY (`ownid`);

--
-- Chỉ mục cho bảng `residents`
--
ALTER TABLE `residents`
  ADD PRIMARY KEY (`rsdid`);

--
-- Chỉ mục cho bảng `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `utilities`
--
ALTER TABLE `utilities`
  ADD PRIMARY KEY (`utltid`);

--
-- Chỉ mục cho bảng `utilities_building`
--
ALTER TABLE `utilities_building`
  ADD PRIMARY KEY (`utlt_bld_id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `apartments`
--
ALTER TABLE `apartments`
  MODIFY `aid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT cho bảng `apartment_type`
--
ALTER TABLE `apartment_type`
  MODIFY `atype_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT cho bảng `bills`
--
ALTER TABLE `bills`
  MODIFY `bill_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `branches`
--
ALTER TABLE `branches`
  MODIFY `branch_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `buildings`
--
ALTER TABLE `buildings`
  MODIFY `bldid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT cho bảng `complains`
--
ALTER TABLE `complains`
  MODIFY `cplid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `contracts`
--
ALTER TABLE `contracts`
  MODIFY `ctrid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `owners`
--
ALTER TABLE `owners`
  MODIFY `ownid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `residents`
--
ALTER TABLE `residents`
  MODIFY `rsdid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT cho bảng `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `utilities`
--
ALTER TABLE `utilities`
  MODIFY `utltid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `utilities_building`
--
ALTER TABLE `utilities_building`
  MODIFY `utlt_bld_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
