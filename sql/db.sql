CREATE TABLE IF NOT EXISTS `mc_googletranslate` (
  `id_gt` smallint(2) UNSIGNED NOT NULL AUTO_INCREMENT,
  `credentials_gt` varchar(150) NOT NULL,
  `projectid_gt` varchar(125) NOT NULL,
  PRIMARY KEY (`id_gt`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

INSERT INTO `mc_admin_access` (`id_role`, `id_module`, `view`, `append`, `edit`, `del`, `action`)
  SELECT 1, m.id_module, 1, 1, 1, 1, 1 FROM mc_module as m WHERE name = 'googletranslate';