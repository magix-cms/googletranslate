<?php
require 'google-translate/vendor/autoload.php';

// [START translate_v3_translate_text]
use Google\Cloud\Translate\V3\TranslationServiceClient;

/*
 # -- BEGIN LICENSE BLOCK ----------------------------------
 #
 # This file is part of MAGIX CMS.
 # MAGIX CMS, The content management system optimized for users
 # Copyright (C) 2008 - 2021 magix-cms.com <support@magix-cms.com>
 #
 # OFFICIAL TEAM :
 #
 #   * Gerits Aurelien (Author - Developer) <aurelien@magix-cms.com> <contact@aurelien-gerits.be>
 #
 # Redistributions of files must retain the above copyright notice.
 # This program is free software: you can redistribute it and/or modify
 # it under the terms of the GNU General Public License as published by
 # the Free Software Foundation, either version 3 of the License, or
 # (at your option) any later version.
 #
 # This program is distributed in the hope that it will be useful,
 # but WITHOUT ANY WARRANTY; without even the implied warranty of
 # MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 # GNU General Public License for more details.
 #
 # You should have received a copy of the GNU General Public License
 # along with this program.  If not, see <http://www.gnu.org/licenses/>.
 #
 # -- END LICENSE BLOCK -----------------------------------
 #
 # DISCLAIMER
 #
 # Do not edit or add to this file if you wish to upgrade MAGIX CMS to newer
 # versions in the future. If you wish to customize MAGIX CMS for your
 # needs please refer to http://www.magix-cms.com for more information.
 */
class plugins_googletranslate_admin extends plugins_googletranslate_db
{
    protected $controller, $message, $template, $plugins,
        $modelLanguage, $collectionLanguage, $data, $header, $routingUrl, $domain;
    /**
     * GET
     * @var $getlang,
     * @var $edit
     */
    public $getlang, $action, $edit, $tab;

    /**
     * POST
     * @var $slide
     * @var $sliderorder
     */
    public $apiGData, $id;

    /**
     * Constructor
     */
    public function __construct($t = null){
        $this->template = $t ? $t : new backend_model_template;
        $this->plugins = new backend_controller_plugins();
        $this->message = new component_core_message($this->template);
        $this->modelLanguage = new backend_model_language($this->template);
        $this->collectionLanguage = new component_collections_language();
        $this->data = new backend_model_data($this);
        $this->header = new http_header();
        $this->domain = new backend_controller_domain();

        $this->routingUrl = new component_routing_url();

        $formClean = new form_inputEscape();

        // --- Get
        if (http_request::isGet('controller')) {
            $this->controller = $formClean->simpleClean($_GET['controller']);
        }
        if (http_request::isGet('edit')) {
            $this->edit = $formClean->numeric($_GET['edit']);
        }
        if (http_request::isGet('action')) {
            $this->action = $formClean->simpleClean($_GET['action']);
        } elseif (http_request::isPost('action')) {
            $this->action = $formClean->simpleClean($_POST['action']);
        }
        if (http_request::isGet('tabs')) {
            $this->tab = $formClean->simpleClean($_GET['tabs']);
        }
        if (http_request::isPost('apiGData')) {
            $this->apiGData = $formClean->arrayClean($_POST['apiGData']);
        }
    }
    /**
     * Method to override the name of the plugin in the admin menu
     * @return string
     */
    public function getExtensionName()
    {
        return $this->template->getConfigVars('googletranslate_plugin');
    }
    /**
     * Assign data to the defined variable or return the data
     * @param string $type
     * @param string|int|null $id
     * @param string $context
     * @param boolean $assign
     * @param boolean $pagination
     * @return mixed
     */
    private function getItems($type, $id = null, $context = null, $assign = true, $pagination = false) {
        return $this->data->getItems($type, $id, $context, $assign, $pagination);
    }

    /**
     * @param $data
     * @throws Exception
     */
    private function upd($data)
    {
        switch ($data['type']) {
            case 'config':
                parent::update(
                    array(
                        //'context' => $data['context'],
                        'type' => $data['type']
                    ),
                    $data['data']
                );
                break;
        }
    }

    /**
     * Update data
     * @param $data
     * @throws Exception
     */
    private function add($data)
    {
        switch ($data['type']) {
            case 'newConfig':
                parent::insert(
                    array(
                        //'context' => $data['context'],
                        'type' => $data['type']
                    ),
                    $data['data']
                );
                break;
        }
    }

    /**
     * @throws Exception
     */
    private function save(){
        $setData = $this->getItems('root',NULL,'one',false);
        $newData = array();
        
        $newData['credentials_gt'] = $this->apiGData['credentials_gt'];
        $newData['projectid_gt'] = $this->apiGData['projectid_gt'];

        if($setData['id_gt']){

            $this->upd(
                array(
                    'type' => 'config',
                    'data' => array(
                        'credentials_gt'     =>  $newData['credentials_gt'],
                        'projectid_gt'     =>  $newData['projectid_gt'],
                        'id'             =>  $setData['id_gt'],
                    )
                )
            );
        }else{
            $this->add(
                array(
                    'type' => 'newConfig',
                    'data' => array(
                        'credentials_gt'     =>  $newData['credentials_gt'],
                        'projectid_gt'     =>  $newData['projectid_gt']
                    )
                )
            );
        }

        $this->message->json_post_response(true, 'update');
    }
    /**
     * @return mixed
     */
    public function setItemData(){
        $setData = $this->getItems('root',NULL,'one',false);
        return $setData;
    }

    /**
    *
    * $googletranslate = new plugins_googletranslate_admin();
    $translate = array(
    'q'=>array("hello the world","my website"),
    'source'=>"en",
    'target'=>"fr"
    );

    $setTranslateApi = $googletranslate->getTranslateText($translate);
    print_r($setTranslateApi)
     * @param $data
     * @throws \Google\ApiCore\ApiException
     * @throws \Google\ApiCore\ValidationException
     */
    public function getTranslateText($data){
        $dataApiTranslate = $this->setItemData();
        $translationServiceClient = new TranslationServiceClient([
            'credentials' => component_core_system::basePath().$dataApiTranslate['credentials_gt']
        ]);
        $projectId = $dataApiTranslate['projectid_gt'];
        $sourceLanguage = $data['source'];
        $targetLanguage = $data['target'];
        $contents = $data['q'];
        $newData = array();
        try {
            $formattedParent = $translationServiceClient->locationName($projectId, 'global');
            $response = $translationServiceClient->translateText(
                $contents,
                $targetLanguage,
                $formattedParent,
                [
                    'sourceLanguageCode' => $sourceLanguage
                ]
            );
            // Display the translation for each input text provided
            foreach ($response->getTranslations() as $translation) {
                //printf('Translated text: %s' . PHP_EOL, $translation->getTranslatedText()).'<br />';
                $newData[] = $translation->getTranslatedText();
            }
            return $newData;
        } finally {
            $translationServiceClient->close();
        }
    }
    /**
     *
     */
    public function run(){
        if(isset($this->action)) {
            switch ($this->action) {
                case 'edit':
                    $this->save();
                    break;
            }
        }else{
            $data = $this->getItems('root',NULL,'one',false);
            $this->template->assign('apige', $data);
            $this->template->display('index.tpl');
        }
    }
}
