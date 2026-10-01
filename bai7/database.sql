CREATE DATABASE IF NOT EXISTS `tintuc`
  CHARACTER SET utf8
  COLLATE utf8_general_ci;

USE `tintuc`;

DROP TABLE IF EXISTS `theloai`;

CREATE TABLE `theloai` (
  `idTL` int(11) NOT NULL AUTO_INCREMENT,
  `TenTL` varchar(255) NOT NULL DEFAULT '',
  `ThuTu` int(11) DEFAULT '0',
  `AnHien` tinyint(1) DEFAULT '1',
  `icon` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`idTL`),
  UNIQUE KEY `TenTL` (`TenTL`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=11;

INSERT INTO `theloai` (`TenTL`, `ThuTu`, `AnHien`, `icon`) VALUES
('Giải trí', 11, 1, 'giai_tri.png'),
('pháp luật', 99, 0, 'phap_luat.png'),
('Văn Hóa', 44, 1, 'van_hoa.png');
