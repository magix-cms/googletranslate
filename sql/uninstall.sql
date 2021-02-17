TRUNCATE TABLE `mc_googletranslate`;
DROP TABLE `mc_googletranslate`;

DELETE FROM `mc_admin_access` WHERE `id_module` IN (
    SELECT `id_module` FROM `mc_module` as m WHERE m.name = 'googletranslate'
);