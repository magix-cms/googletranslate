<?php
class plugins_googletranslate_db
{
    /**
     * @param $config
     * @param bool $params
     * @return mixed|null
     * @throws Exception
     */
    public function fetchData($config, $params = false)
    {
        if (!is_array($config)) return '$config must be an array';

        $sql = '';

        if($config['context'] === 'all') {
            switch ($config['type']) {
                /*case 'images':
                    $sql = 'SELECT img.name_img
							FROM mc_catalog_cat_club AS img
							WHERE img.id_product = :id';
                    break;*/
            }

            return $sql ? component_routing_db::layer()->fetchAll($sql,$params) : null;
        }
        elseif($config['context'] === 'one') {
            switch ($config['type']) {
                case 'root':
                    $sql = 'SELECT * FROM mc_googletranslate ORDER BY id_gt DESC LIMIT 0,1';
                    break;
                case 'page':
                    $sql = 'SELECT * FROM `mc_googletranslate` WHERE `id_gt` = :id_gt';
                    break;
            }

            return $sql ? component_routing_db::layer()->fetch($sql,$params) : null;
        }
    }

    /**
     * @param $config
     * @param array $params
     * @return bool|string
     */
    public function insert($config,$params = array())
    {
        if (!is_array($config)) return '$config must be an array';

        $sql = '';

        switch ($config['type']) {
            case 'newConfig':
                $sql = 'INSERT INTO mc_googletranslate (credentials_gt,projectid_gt) VALUE(:credentials_gt,:projectid_gt)';

                break;
        }

        if($sql === '') return 'Unknown request asked';

        try {
            component_routing_db::layer()->insert($sql,$params);
            return true;
        }
        catch (Exception $e) {
            return 'Exception reçue : '.$e->getMessage();
        }
    }

    /**
     * @param $config
     * @param array $params
     * @return bool|string
     */
    public function update($config,$params = array())
    {
        if (!is_array($config)) return '$config must be an array';

        $sql = '';

        switch ($config['type']) {
            case 'config':
                $sql = 'UPDATE mc_googletranslate
                    SET credentials_gt=:credentials_gt,
                        projectid_gt=:projectid_gt
                    WHERE id_gt=:id';
                break;
        }

        if($sql === '') return 'Unknown request asked';

        try {
            component_routing_db::layer()->update($sql,$params);
            return true;
        }
        catch (Exception $e) {
            return 'Exception reçue : '.$e->getMessage();
        }
    }
}
?>